import axios, { AxiosResponse } from 'axios';

interface Block {
  id: number;
  hash: string;
  value: string;
  date: string;
}

export class Cache {
  // private host = 'apache-shntr';
  private host = 'localhost';

  async get(key) {
    try {
      const response: AxiosResponse = await axios.get(
        `http://${this.host}/run/get/${encodeURIComponent(btoa(key))}`,
      );

      if (response.status === 200) {
        const block: Block = response.data;
        return JSON.parse(block.value);
      }
    } catch (e) {
      console.warn('no block : ', e.response.statusText);
    }
  }

  async set(key, value) {
    try {
      await axios.post(
        `http://${this.host}/run/set/${encodeURIComponent(btoa(key))}`,
        JSON.stringify(value),
        {
          headers: {
            'Content-Type': 'plain/text',
          },
        },
      );
    } catch (e) {
      console.warn('failed caching : ', e);
    }
  }
}
