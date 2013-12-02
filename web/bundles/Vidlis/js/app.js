var http    =   require('http');
var fs      =   require('fs');

// Variables globales
// Ces variables resteront durant toute la vie du seveur et sont communes pour chaque client (node server.js)
// Liste des messages de la forme { pseudo : 'Mon pseudo', message : 'Mon message' }
var app = http.createServer(function (req, res) {
});
var videos = [];

//// SOCKET.IO ////

var io      =   require('socket.io');

// Socket.IO écoute maintenant notre application !
io = io.listen(app);

// Quand une personne se connecte au serveur
io.sockets.on('connection', function (socket) {
    console.log('connexion');
    // Quand un client lance une vidéo
    socket.on('launch', function (info) {
        console.log('Launch' + info.videoId);
        // On envoie à tout les clients connectés
        socket.broadcast.emit('getLaunched', info);
    });
});

///////////////////

// Notre application écoute sur le port 8080
app.listen(8080);
console.log('Live Chat App running at http://localhost:8080/');