const server = require('http').Server();
const io = require('socket.io')(server);
const Redis = require('ioredis');
const redis = new Redis();

redis.subscribe('room-channel');
redis.on('message', (channel, message) => {
  const {event, data} = message;
  io.emit(`${channel}:${event}`, data);
});

server.listen(3000);
