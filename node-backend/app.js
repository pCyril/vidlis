const app = require('express')();
const server = require('http').Server(app);
const io = require('socket.io')(server);
const axios = require('axios');
const bodyParser = require('body-parser');

app.use(bodyParser.json());

const users = [];

io.on('connection', function (socket) {

    users.push({socket_id: socket.id, isRadio: false});

    socket.emit(`me`, { socket_id : socket.id});

    socket.on('current', function(data){
        users.forEach((user, index) => {
            if (user.socket_id == data.socket_id) {
                user.current = data;
            }
        });

        io.emit(`currents`, users);
    });

    socket.on('currents', function(){
        io.emit(`currents`, users);
    });

    socket.on('toggleRadio', function(data){
        users.forEach((user, index) => {
            if (user.socket_id == data.socket_id) {
                user.isRadio = data.isRadio;
            }
        });
        io.emit(`currents`, users);
    });

    socket.on('disconnect', function () {
        let sockets = Object.keys(io.sockets.sockets);
        users.forEach((user, index) => {
           if (sockets.indexOf(user.socket_id) == -1) {
               users.splice(index, 1);
           }
        });

        io.emit(`currents`, users);
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