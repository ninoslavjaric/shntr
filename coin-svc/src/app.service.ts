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
}
