var http    =   require('http');
var fs      =   require('fs');

// Variables globales
// Ces variables resteront durant toute la vie du seveur et sont communes pour chaque client (node server.js)
var app = http.createServer(function (req, res) {
});
var users = [];
var groups = [];
var i = 0;
var io      =   require('socket.io');

io = io.listen(app);

// Quand une personne se connecte au serveur
io.sockets.on('connection', function (socket) {
    // A la connexion je récupère les informations des utilisateurs
    socket.on('connectMe', function(user){
        user.id = socket.id;
        users[i] = user;
        i++;
        socket.emit('setUserId', socket.id);
        socket.emit('getAllLaunched', users);
        socket.emit('getGroups', groups);
    });
    socket.on('getVideoLaunchByUserName', function(userName){
        var user = {videoId: ''};
        var j = 0;
        while (j < users.length) {
            if (users[j].name == userName)
                user = users[j];
            j++;
        }
        socket.emit('videoLaunchByUserName', user.videoId);
    });
    // Quand un client lance une vidéo
    socket.on('launch', function (user) {
        var j = 0;
        while (j < users.length) {
            if (users[j].id == user.id)
                users[j] = user;
            j++;
        }
        // On envoie à tout les clients connectés
        socket.broadcast.emit('getLaunched', user);
    });

    socket.on('updateUserStatus', function (user) {
        var j = 0;
        while (j < users.length) {
            if (users[j].id == user.id)
                users[j] = user;
            j++;
        }
        // On envoie à tout les clients connectés
        socket.broadcast.emit('userStatusChange', user);
    });

    socket.on('updateUserStatusByRemote', function (info) {
        var user = {name: ''};
        var j = 0;
        while (j < users.length) {
            if (users[j].name == info.username) {
                user = users[j];
                user.status = info.status
            }
            j++;
        }
        socket.broadcast.emit('updateUserStatus', user);
    });

    socket.on('changeVideoByRemote', function(info) {
        socket.broadcast.emit('previewNext', info);
    });

    socket.on('launchOnScreen', function(item){
        socket.broadcast.emit('addToPlaylistFromRemote', item);
    });

    socket.on('addToPlaylist', function (user, videoId) {
        groupVideoAdded = {
            user: user,
            videoId: videoId
        };
        socket.broadcast.emit('addToPlaylistGroup', groupVideoAdded);
    });
    socket.on('createGroup', function(user, groupName){
        group = {
            name: groupName,
            user: user,
            users: []
        }
        groups.push(group);
        socket.broadcast.emit('getGroups', groups);
    });
    socket.on('disconnect', function () {
        var j = 0;
        var n = 0;
        var tmp = [];

        while (n < users.length) {
            if (users[j].id == socket.id) {
                n++;
                for (var k = 0; k < groups.length; k++) {
                    if (groups[k].user.id == socket.id) {
                        groups.splice(k, 1);
                    }
                }
            }
            if (n < users.length) {
                tmp[j] = users[n];
                j++;
                n++;
            }
        }
        users = tmp;
        i = j;
        socket.broadcast.emit('remove', this.id);
        socket.broadcast.emit('getGroups', groups);
    });
});

app.listen(8080);