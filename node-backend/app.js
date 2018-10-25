const app = require('express')();
const server = require('http').Server(app);
const io = require('socket.io')(server);
const axios = require('axios');
const bodyParser = require('body-parser');

app.use(bodyParser.json());

const users = [];

io.on('connection', function (socket) {

    io.emit(`me`, { socket_id : socket.id});

    socket.on('current', function(data){
        console.log(data);
    });

});

io.emitTo = function(users, message, data) {
    Object.keys(io.sockets.sockets).forEach(function (socketId) {
        var socket = io.sockets.sockets[socketId];

        if (users.indexOf(socket.userId) !== -1 || !socket.userId) {
            socket.emit(message, data);
        }
    });
};

server.listen(8080);