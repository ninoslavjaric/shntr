FROM node:14-alpine

COPY . /usr/app
RUN cd /usr/app && npm i && npm run-script build

CMD ["node", "/usr/app/dist/main.js"]
