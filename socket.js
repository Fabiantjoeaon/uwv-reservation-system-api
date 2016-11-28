process.env.NODE_TLS_REJECT_UNAUTHORIZED = '0';
const app = require('express')();
const fs = require('fs');
const privateKey = fs.readFileSync('./storage/ssl/certificate.key').toString();
const certificate = fs.readFileSync('./storage/ssl/certificate.crt').toString();

const https = require('https');
const HTTPSOptions = {
    cert: certificate,
    key: privateKey,
    passphrase: '67?BFiVLuJ6pzjgvX4jX'
};

const server = https.createServer(HTTPSOptions, app);
const io = require('socket.io')(server, {origins: '*:*'});
server.listen(8080);
const Redis = require('ioredis');
const redis = new Redis();

redis.subscribe('room-channel');
redis.on('message', (channel, message) => {
  const jsonMessage = JSON.parse(message);
  console.log(`${channel}:${jsonMessage.event}, @ room ${jsonMessage.data.id}`);
  io.emit(`${channel}:${jsonMessage.event}`, jsonMessage.data);
});
