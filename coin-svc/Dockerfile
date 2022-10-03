FROM node:16.17.1-alpine

RUN apk update; apk upgrade;

RUN npm install -g npm@8.15.0; npm --version

COPY . /usr/app
RUN cd /usr/app && npm i && npm run-script build

RUN apk add --no-cache aws-cli

CMD ["node", "/usr/app/dist/main.js"]
