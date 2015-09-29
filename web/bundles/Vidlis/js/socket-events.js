
var MySocket = function(urlNode) {

    socket = io.connect('http://' + urlNode + '/');

    socket.on('getLaunched', function (info) {
        $('#'+info.id).remove();
        formatPlayingList(info);
    });

    socket.on('logoutUser', function (userEmit) {
        if (userEmit.id == user.id) {
            user.changeName('');
            socket.emit('updateUser', user);
            $.ajax({
                type: 'GET',
                url: DOMAIN_NAME + '/logout',
                cache: false,
                beforeSend: function () {
                    $('.modalHTML.modal, .overlay').show();
                },
                success: function (data) {
                    loadBox($.address.value());
                    $('.modalHTML.modal').show();
                    $(".modalHTML.modal .modal-content").html(data);
                },
                error: function () {
                    $(".modalWithHeader .modal-header h4").html('Oups :\'(');
                    $(".modalWithHeader .modal-body").html('Oh Mince ! Une erreur c\'est produite');
                }
            });

            $.ajax({
                type: 'GET',
                url: this,
                cache: false,
                dataType: 'html',
                beforeSend: function () {
                    $('.modalHTML.modal, .overlay').show();
                },
                success: function (data) {
                    $('.modalHTML.modal').show();
                    $(".modalHTML.modal .modal-content").html(data);
                },
                error: function () {
                    $(".modalHTML.modal .modal-content").html('Oh Mince ! Une erreur c\'est produite');
                }
            }).done(function () {
                sendFormToAjax();
            });
        }
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
