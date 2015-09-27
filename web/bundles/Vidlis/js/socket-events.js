
var MySocket = function(urlNode) {
    socket = io.connect('http://' + urlNode + '/');
    socket.on('getLaunched', function (info) {
        $('#'+info.id).remove();
        formatPlayingList(info);
    });
    socket.on('addToPlaylistGroup', function (videoAdded) {
        if (videoAdded.user.group == user.group) {
            addToQueue(videoAdded.videoId, false, true);
        }
    });
    socket.on('updateUserStatus', function(info) {
        if (info.name == user.name) {
            if (info.status == 1) {
                playVideo();
            } else {
                pauseVideo();
            }
        }
    });
    socket.on('previewNext', function(info) {
        if (info.username == user.name) {
            if (info.status == 1) {
                next();
            } else {
                preview();
            }
        }
    });
    socket.on('addToPlaylistFromRemote', function (itemAdded) {
        if (itemAdded.username == user.name && user.name != '') {
            addToQueue(itemAdded.videoId);
        }
    });
    socket.on('getGroups', function (groups) {
        groupList = groups;
    });
    socket.on('connect', function () {
        socket.emit('connectMe', user);
    });
    socket.on('setUserId', function(id) {
        user.id = id;
    });
    socket.on('remove', function(userToRemove){
        $('#'+userToRemove).remove();
    });
    socket.on('getAllLaunched', function (users) {
        $.each(users, function (){
            var infoAllLaunched = this;
            if (infoAllLaunched.videoId != '') {
                formatPlayingList(infoAllLaunched);
            } else {
                $('#'+infoAllLaunched.id).remove();
            }
        });
    });

    return socket;
}
