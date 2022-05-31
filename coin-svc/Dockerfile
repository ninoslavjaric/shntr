FROM node:14-alpine

COPY . /usr/app
RUN cd /usr/app && npm i && npm run-script build

RUN apk add --no-cache aws-cli

CMD ["node", "/usr/app/dist/main.js"]
