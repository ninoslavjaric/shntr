import * as fs from 'fs';

export class Cache {
  async get(key) {
    const path = `/tmp/cache/${btoa(key)}`;
    if (fs.existsSync(path)) {
      return JSON.parse(fs.readFileSync(path).toString());
    }
  }

  async set(key, value) {
    const dir = `/tmp/cache`;

    if (!fs.existsSync(dir)) {
      fs.mkdirSync(dir);
    }

    const path = `${dir}/${btoa(key)}`;
    fs.writeFileSync(path, JSON.stringify(value));
  }
}

// import axios, { AxiosResponse } from 'axios';
//
// interface Block {
//   id: number;
//   hash: string;
//   value: string;
//   date: string;
// }
//
// export class Cache {
//   // private host = 'apache-shntr';
//   private host = 'localhost';
//
//   async get(key) {
//     try {
//       const response: AxiosResponse = await axios.get(
//         `http://${this.host}/run/get/${encodeURIComponent(btoa(key))}`,
//       );
//
//       if (response.status === 200) {
//         const block: Block = response.data;
//         return JSON.parse(block.value);
//       }
//     } catch (e) {
//       console.warn('no block : ', e.response.statusText);
//     }
//   }
//
//   async set(key, value) {
//     try {
//       await axios.post(
//         `http://${this.host}/run/set/${encodeURIComponent(btoa(key))}`,
//         JSON.stringify(value),
//         {
//           headers: {
//             'Content-Type': 'plain/text',
//           },
//         },
//       );
//     } catch (e) {
//       console.warn('failed caching : ', e);
//     }
//   }
// }
