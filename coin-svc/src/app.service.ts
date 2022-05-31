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

@Injectable()
export class AppService {
  private readonly superRunner: Run;
  constructor() {
    this.superRunner = new Run({ network: 'mock' });
    // (async () => {
    //   SHNT.symbol = 'SHNT'
    //   SHNT.metadata = {emoji: '💵'}
    //
    //   this.superRunner.deploy(SHNT)
    //   await this.superRunner.sync()
    // })()
  }
  getHello(): string {
    return 'Hello World!';
  }
  getSuperRunner(): Run {
    return this.superRunner;
  }

  async getPurse(): Promise<Credentials> {
    const client = new SecretsManager({
      region: 'us-east-1',
    });

    const djes = await client.getSecretValue({ SecretId: 'purse' });

    const path = __dirname + '/../purse.json';
    if (fs.existsSync(path)) {
      return JSON.parse(fs.readFileSync(path).toString());
    }
  }
}
