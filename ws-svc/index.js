const axios = require('axios');
const { createServer } = require('http')
const { io } = require('socket.io-client')
const {WebSocketServer} = require('ws')
const { SQS } = require('aws-sdk')

let wsPool = [];
const sqsParams = {};

if (process.env.AWS_ENDPOINT) {
  sqsParams.endpoint = process.env.AWS_ENDPOINT
}

const sqsClient = new SQS({ ...sqsParams, region: process.env.AWS_DEFAULT_REGION });

const pingSqs = async () => {
  console.log('Ping sqs');
  let data = null;

  try {
    data = await sqsClient.receiveMessage({
      QueueUrl: process.env.SQS_QUEUE_URL,
      WaitTimeSeconds: 10,
    }).promise();
  } catch (e) {
    console.warn(e)
    return pingSqs()
  }

  for (const message of data.Messages || []) {
    const messageBody = JSON.parse(message.Body)
    console.log('incoming ', messageBody)

    console.log('pool ', wsPool.length)

    let wsrs = messageBody.userIds.length > 0
      ? wsPool.filter(ws => messageBody.userIds.includes(parseInt(ws.userId))) : wsPool

    if (wsrs.length === 0) {
      continue
    }

    wsrs.forEach(ws => ws.send(JSON.stringify(messageBody.data || {})))

    await sqsClient.deleteMessage({
      QueueUrl: process.env.SQS_QUEUE_URL,
      ReceiptHandle: message.ReceiptHandle,
    }).promise()
  }

  setTimeout(pingSqs, 5000)
}
setTimeout(pingSqs, 10000)

const relysiaHook = async () => {
  const relysiaEndpoint = 'api.relysia.com';

  let token;

  try {
    const { data } = await axios.get('http://apache-shntr/api/relysia_treasury_token');
    token = data.token
  } catch (e) {
    token = null
  }

  if (!token) {
    const loginObject = await axios.post(
      `https://${relysiaEndpoint}/v1/auth`,
      {email: process.env.shntr_TOKEN_USERNAME, password: process.env.shntr_TOKEN_PASSWORD_DECRYPT},
      {
        headers: {serviceID: '9ab1b69e-92ae-4612-9a4f-c5a102a6c068'}
      }
    );
    token = loginObject.data.data.token
    console.log('Login completed', loginObject.data);
  }


  const socket = io(`wss://${relysiaEndpoint}`, {
    extraHeaders: {
      authToken: token,
      serviceID: '9ab1b69e-92ae-4612-9a4f-c5a102a6c068'
    },
    transports: ['websocket', 'polling']
  });

  socket.on('error', function(error) {
    console.log("Connection Error: " + error.toString());
  });

  socket.on('notification', async (message) => {
    if (message.tokenId !== '9a0e862be07d8aa56311e5b211a4fdf9ddf03b2f-SHNATST') {
      return
    }

    console.log('event received', message);


    const resp = await axios.post('http://apache-shntr/api/relysia_balance_refresh', { ...message, id: ws.userId})

    console.log('balance refresh ', resp)

    for (const ws of wsPool) {
      const balance = resp.data.find(blnc => blnc.id === ws.userId)

      if (!balance) {
        continue;
      }

      ws.send(JSON.stringify({
        event: 'balance',
        data: {
          balance: balance.balance
        }
      }))
    }
  })

  socket.on('connect', function(connection) {
    console.log('Client Connected ');
  });

  socket.on('close', function() {
    console.log('echo-protocol Connection Closed ');
  });
}
relysiaHook()

const server = createServer((req, res) => {
  res.writeHead(200, {'Content-Type': 'text/plain'});
  res.write(wsPool.map(ws=>ws.userId).join("\n"))
  res.end();
})

const wss = new WebSocketServer({ server })

server.listen(8083)

wss.on('connection', function connection(ws) {
  ws.send('welcome!')


  ws.on('message', async function(data) {
    if (!ws.userId) {
      const resp = await axios.post(`http://apache-shntr/api/ws_check`, {param: data.toString()})

      if (resp.data.userId) {
        const {userId} = resp.data
        ws.userId = parseInt(userId)
        wsPool.push(ws)
      } else {
        console.log('closing ' + data.toString())
        ws.close()
      }

      return
    }

    ws.send(data.toString())
  })

  ws.on('close', function(data) {
    wsPool = wsPool.filter(wsp => wsp.userId !== this.userId)
  })

});


