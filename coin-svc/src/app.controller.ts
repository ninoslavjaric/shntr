import { Controller, Get, Post, Header, Request, Req } from '@nestjs/common';
import { AppService } from './app.service';
import * as numble from '@runonbitcoin/nimble';
import * as Run from 'run-sdk';

type SendTokensRequest = Request | { body: string };

@Controller()
export class AppController {
  constructor(private readonly appService: AppService) {}

  @Get()
  async getHello(): Promise<string> {
    return this.appService.getHello();
  }

  @Get('/generate-wallet')
  @Header('content-type', 'application/json')
  generateWallet(): string {
    const key = numble.PrivateKey.fromRandom();

    return JSON.stringify({
      private: key.toString(),
      public: key.toPublicKey().toString(),
      address: key.toAddress().toString(),
    });
  }

  @Get('/balance')
  @Header('content-type', 'application/json')
  async getBalance(@Req() request: Request): Promise<string> {
    try {
      if (!request.headers['x-key']) {
        return JSON.stringify({ message: 'no key', amount: 0 });
      }
      const classLocation =
        'd2be93e9866d070bc0247c66faeb6d13506a593926ccaab079657a63f8fd655f_o2';
      const privateKey = request.headers['x-key'];
      const runner = new Run({ owner: privateKey });

      runner.trust('*');
      const SHNA = await runner.load(classLocation);
      // await SHNA.sync();

      await runner.inventory.sync();

      const tokens = runner.inventory.jigs.filter((jig) => jig instanceof SHNA);

      if (tokens.length == 0) {
        return JSON.stringify({ msg: 'no tokens', amount: 0 });
      }

      return JSON.stringify({
        amount:
          tokens
            .map((i) => i.amount)
            .reduce((partialSum, a) => partialSum + a, 0) / SHNA.decimals,
      });
    } catch (e) {
      return JSON.stringify({
        message: e.message,
        amount: 0,
      });
    }
  }

  @Post('/pay')
  @Header('content-type', 'application/json')
  async sendTokens(@Req() request: Request): Promise<string> {
    try {
      if (!request.headers['x-key']) {
        return JSON.stringify({ message: 'no key' });
      }
      const message = await this.appService.sendFunds(
        request.headers['x-key'],
        // eslint-disable-next-line @typescript-eslint/ban-ts-comment
        // @ts-ignore
        request.body,
      );

      return JSON.stringify({
        message: message,
      });
    } catch (e) {
      console.warn(e);
      return JSON.stringify({
        message: e.message,
      });
    }
  }

  @Get('/purse')
  @Header('content-type', 'application/json')
  async getPurseData(): Promise<string> {
    return JSON.stringify({
      satoshis: await this.appService.getSuperRunner().purse.balance(),
    });
  }
}
