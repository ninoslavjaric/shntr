#!/bin/sh
npm install -g npm@8.15.0; npm --version
cd /usr/app && npm i && npm run-script build

node /usr/app/dist/main.js
