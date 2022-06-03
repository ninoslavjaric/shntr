import { Injectable } from '@nestjs/common';
import * as Run from 'run-sdk';
import * as fs from 'fs';
import { SecretsManager } from 'aws-sdk';
// import { SHNT } from './SHNT';

interface Credentials {
  private: string;
  public: string;
  address: string;
}

type CredentialsOrNull = Credentials | null;

interface FundSendParams {
  recipientAddress: string;
  amount: number;
}

interface TokenFunds {
  location: string;
  origin: string;
  nonce: number;
  owner: string;
  satoshis: number;
  sender: null | string;
  amount: number;
  send: (address: string, amount: number) => TokenFunds;
  sync: () => Promise<void>;
}

@Injectable()
export class AppService {
  private superRunner: Run;
  private readonly tokenAddress: string =
    'd2be93e9866d070bc0247c66faeb6d13506a593926ccaab079657a63f8fd655f_o2';
  constructor() {
    this.initSuperRunner();
    // (async () => {
    //   SHNT.symbol = 'SHNT'
    //   SHNT.metadata = {emoji: '💵'}
    //
    //   this.superRunner.deploy(SHNT)
    //   await this.superRunner.sync()
    // })()
  }
  private getPurseCreds(): Promise<CredentialsOrNull> {
    return new Promise((resolve) => {
      const client = new SecretsManager({
        region: 'us-east-1',
      });
      client.getSecretValue(
        { SecretId: 'purse' },
        (err, data: SecretsManager.Types.GetSecretValueResponse) => {
          if (err) {
            console.log(err);
            return resolve(null);
          }

          return resolve(JSON.parse(data.SecretString));
        },
      );
    });
  }
  getHello(): string {
    return 'Hello World!';
  }
  getSuperRunner(): Run {
    this.superRunner.sync();
    return this.superRunner;
  }

  async getPurse(): Promise<CredentialsOrNull> {
    const credentials = await this.getPurseCreds();

    if (credentials) {
      return credentials;
    }

    const path = __dirname + '/../purse.json';

    if (fs.existsSync(path)) {
      return JSON.parse(fs.readFileSync(path).toString());
    }

    return null;
  }

  private async initSuperRunner(): Promise<void> {
    const purse = await this.getPurse();
    this.superRunner = new Run({
      owner: purse.private,
      purse: purse.private,
    });
    this.superRunner.activate();
  }

  async sendFunds(
    senderPrivateKey: string,
    params: FundSendParams,
  ): Promise<string> {
    const purse = await this.getPurse();
    const sender = new Run({
      owner: senderPrivateKey,
      purse: purse.private,
    });
    sender.activate();
    sender.trust(
      'd2be93e9866d070bc0247c66faeb6d13506a593926ccaab079657a63f8fd655f',
    );
    await sender.inventory.sync();
    const TokenClass = await sender.load(this.tokenAddress);
    const funds: TokenFunds = sender.inventory.jigs.find(
      (jig) => jig instanceof TokenClass,
    );

    if (!funds || funds.amount < params.amount) {
      return 'not enough funds';
    }

    const sentFunds: TokenFunds = funds.send(
      params.recipientAddress,
      params.amount,
    );
    await sentFunds.sync();
    await funds.sync();

    return `${sentFunds.amount} tokens sent successfully`;
  }
}
