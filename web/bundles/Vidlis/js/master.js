$(document).ready(function () {
    $('.formSearch').live('submit', function () {
        if ($('#search').val()) {
            url = '/search/' + encodeURIComponent($('#search').val());
            loadBox(url);
            $(window).scrollTop(0);
        } else {
            showError('Oui, mais tu cherches quoi exactement ?');
        }
        return false;
    });
    $('.closeShowPlaylist').live('click', function () {
        $('#playlistContent, .underVideo, .closeShowPlaylist, #suggestionContent').toggleClass('open', 500);
        if ($('.closeShowPlaylist').hasClass('open')) {
            $('.closeShowPlaylist').html('>');
        } else {
            $('.closeShowPlaylist').html('<');
        }
    });
    $('.showPlaying').live('click', function () {
        $('.infoPlayed, .showPlaying').toggleClass('open', 500);
        if ($('.showPlaying').hasClass('open')) {
            $('.showPlaying').html('+');
        } else {
            $('.showPlaying').html('-');
        }
    });
    $('.formSearchHome').live('submit', function () {
        if ($('#q').val()) {
            url = '/search/' + encodeURIComponent($('#q').val());
            loadBox(url);
            $(window).scrollTop(0);
        } else {
            showError('Oui, mais tu cherches quoi exactement ?');
        }
        return false;
    });
    setupCustomScrollbar();
    $(".mCustomScrollbarExist").each(function () {
        $(this).mCustomScrollbar(
            {
                scrollInertia: 0,
                advanced:{
                    updateOnContentResize: true
                }
            }
        );
    });
    $(".playButtonRow, .videoName, .itemSearch, #suggestionContent .itemPlaylist, .itemLaunched").live("click", function () {
        addToQueue($(this).data('id'));
        if ($('.btn-suggestion').hasClass('active')) {
            $('#suggestionContent').hide();
            $('.btn-suggestion').removeClass('active');
            $('#playlistContent, .btn-save').show();
        }
    });
    $(".readAfter").live("click", function () {
        addToQueue($(this).data('id'), true);
    });
    $("#playlistContent .itemPlaylist").live("click", function () {
        launch($(this));
    });
    $(".deleteItemPlaylist").live("click", function () {
        deleteItem($(this));
    });
    $(".btn-suggestion").on("click", function () {
        $(this).toggleClass('active');
        if ($('.btn-suggestion').hasClass('active')) {
            $('#playlistContent, .btn-save').hide();
            getSuggestion($('.itemPlaylist.active').data('id'));
        } else {
            $('#suggestionContent').hide();
            $('#playlistContent, .btn-save').show();
        }
        return false;
    });
    $('#playlistContent, #suggestionContent').css('height', ($(window).height() - 89) + 'px');
    $('#playlistContent, #suggestionContent').mCustomScrollbar(
        {scrollInertia: 0, mouseWheel: true, autoHideScrollbar: true,
            advanced: {
                updateOnContentResize: true
            }}
    );
    $('.loadPlaylist').live('click', function () {
        $('#' + $(this).data('idplaylist') + ' .rowItem .playButtonRow').each(function () {
            addToQueue($(this).data('id'));
        });
    });
    $('.btn-grow').bind('click', function () {
        $('.overlay').show();
        $('.playerVideo').addClass('grow');
        $('.playerVideo').css('width', ($(window).width() - 40) + 'px');
        $('.playerVideo').css('height', ($(window).height() - 40) + 'px');
        $('#ytPlayer').attr('width', ($(window).width() - 62));
        $('#ytPlayer').attr('height', ($(window).height() - 62));
        return false;
    });
});

$('.mouseoverInfo').live('mousemove', function (e) {
    $('#infoLabel').css('top', ($(e.target).offset().top - 30) + 'px').css('left', ($(e.target).offset().left - 30) + 'px').css('display', 'block');
    $('#infoLabel').html($(e.target).data('info'));
    console.log($(e.target).offset().top);
});

$('.mouseoverInfo').live('mouseout', function () {
    $('#infoLabel').css('display', 'none');
});
window.onbeforeunload = function() {
    if (typeof socket != 'undefined') {
        socket.disconnect();
    }
    if ($('#playlistContent .mCustomScrollBox .mCSB_container .itemPlaylist').length > 0) {
        return 'En quittant cette page vous allez perdre votre playlist en cours';
    }
}
$(window).resize(function () {
    $('#playlistContent, #suggestionContent').css('height', ($(window).height() - 89) + 'px');
});

$(".modal .close, .overlay").live('click', function(){
    $('.modal, .overlay').hide();
});
$('body').bind('click', function (e) {
    if ($('.overlay').css('display') == 'block'
        && $(e.target).is('.modal, .modal-dialog')) {
        $('.modal, .overlay').hide();
    }
    if ($('.playerVideo').hasClass('grow')
        && $(e.target).is('.overlay')) {
        $('.overlay').hide();
        $('.playerVideo').removeClass('grow');
        $('#ytPlayer').attr('width', 219);
        $('#ytPlayer').attr('height', 200);
        $('.playerVideo').css('width', 219 + 'px');
        $('.playerVideo').css('height', 200 + 'px');
    }
});
$(document).keyup(function (e) {
    if ($('.playerVideo').hasClass('grow')
        && e.keyCode == 27) {
        $('.overlay').hide();
        $('.playerVideo').removeClass('grow');
        $('#ytPlayer').attr('width', 219);
        $('#ytPlayer').attr('height', 200);
        $('.playerVideo').css('width', 219 + 'px');
        $('.playerVideo').css('height', 200 + 'px');
    }
});

$(".toModal").live('click', function () {
        element = $(this);
        $.ajax({
            type: 'GET',
            url: this,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $(".modal-header h4").html('Chargement en cours');
                $(".modal-body").html('');
                $('.modal, .overlay').show();
            },
            success: function (data) {
                $('.modal').show();
                $(".modal-header h3").html(data.title);
                $(".modal-body").html(data.content);
            },
            error: function () {
                $(".modal-header h3").html('Oups :\'(');
                $(".modal-body").html('Oh Mince ! Une erreur c\'est produite');
            }
        }).done(function () {
                sendFormToAjax();
            });
        return false;
    }
);


$(".toModalHTML").live('click', function () {
        element = $(this);
        $.ajax({
            type: 'GET',
            url: this,
            cache: false,
            dataType: 'html',
            beforeSend: function () {
                $(".modal-header h4").html('Chargement en cours');
                $(".modal-body").html('');
                $('.modal, .overlay').show();
            },
            success: function (data) {
                $('.modal').show();
                $(".modal-content").html(data);
            },
            error: function () {
                $(".modal-header h3").html('Oups :\'(');
                $(".modal-body").html('Oh Mince ! Une erreur c\'est produite');
            }
        }).done(function () {
                sendFormToAjax();
            });
        return false;
    }
);

function loadBox(url) {
    if ($.address.value() != url) {
        $.address.value(url);
    } else {
        forceLoad(url);
    }
}

function setupCustomScrollbar() {
    $(".mCustomScrollbarActiv").each(function () {
        $(this).mCustomScrollbar(
            {scrollInertia: 0}
        );
    });
    $(".boxHeader").each(function () {
        if ($(this).height() > 50) {
            $(this).parent().find('.boxBody').css('height', (276 - $(this).height() + 50)+'px');
        }
    });
    $(".playlistCreatorName").each(function () {
        $(this).parent().find('h2').css('padding-right', ($(this).width() + 15)+'px');
    });
}

function sendFormToAjax() {
    $(".form-ajax").unbind();
    $(".form-ajaxHTML").unbind();
    var isLoding = false
    $(".form-ajax").each(function (index, element) {
        form = $(element);
        if (!isLoding) {
            $(element).submit(function () {
                post = $(element).serialize();
                $.ajax({
                    type: 'post',
                    url: $(element).attr('action'),
                    cache: false,
                    dataType: 'json',
                    data: post,
                    beforeSend: function () {
                        isLoding = true;
                    },
                    success: function (data) {
                        idContainer = form.data('container');
                        $('.' + idContainer).html(data.content);
                        sendFormToAjax();
                        isLoding = false;
                    },
                    error: function () {
                        $(".modal-header h3").html('Oups :\\');
                        $(".modal-body").html('Une erreur c\'est produite');
                        isLoding = false;
                    }
                });
                return false;
            });
        } else {
            return false;
        }
    });

    $(".form-ajaxHTML").each(function (index, element) {
        form = $(element);
        if (!isLoding) {
            $(element).submit(function () {
                post = $(element).serialize();
                $.ajax({
                    type: 'post',
                    url: $(element).attr('action'),
                    cache: false,
                    dataType: 'html',
                    data: post,
                    beforeSend: function () {
                        isLoding = true;
                    },
                    success: function (data) {
                        idContainer = form.data('container');
                        $('.' + idContainer).html(data);
                        sendFormToAjax();
                        isLoding = false;
                    },
                    error: function () {
                        $(".modal-header h3").html('Oups :\\');
                        $(".modal-body").html('Une erreur c\'est produite');
                        isLoding = false;
                    }
                });
                return false;
            });
        } else {
            return false;
        }
    });
}

/*
 * Chromeless player has no controls.
 */

// Update a particular HTML element with a new value
function updateHTML(elmId, value) {
    document.getElementById(elmId).innerHTML = value;
}

// This function is called when an error is thrown by the player
function onPlayerError(errorCode) {
    if (errorCode == 150 || errorCode == 101) {
        showError("Le propriétaire de la vidéo ne souhaite qu'elle soit lancée en dehors de Youtube.");
    } else if (errorCode == 100) {
        showError("L'id de la vidéo n'a pas été trouvé.");
    } else {
        showError("Une erreur s'est produite avec le lecteur.");
    }
}

// This function is called when the player changes state
function onPlayerStateChange(newState) {
    if (newState == -1 || newState == 0 || newState == 2 || newState == 3) {
        $("#play_b").css('display', 'none');
        $("#play_p").css('display', 'block');
    } else {
        $("#play_p").css('display', 'none');
        $("#play_b").css('display', 'block');
    }
    if (newState == 0) {
        next();
    }
}

// Display information about the current state of the player
function updatePlayerInfo() {
    // Also check that at least one function exists since when IE unloads the
    // page, it will destroy the SWF before clearing the interval.
    if (ytplayer && ytplayer.getDuration) {
        updateHTML("time", getTime(ytplayer.getCurrentTime()));

        duration = ytplayer.getDuration();
        preload = parseInt($('#seekbar').css('width')) * ((Math.floor(ytplayer.getVideoBytesLoaded() * 10) / 10) / ytplayer.getVideoBytesTotal());
        result = parseInt($('#seekbar').css('width')) * ((Math.floor(ytplayer.getCurrentTime() * 10) / 10) / duration);
        $("#play").css('width', result);
        $("#preload").css('width', preload);
    }
}

// Allow the user to set the volume from 0-100
function setVideoVolume(volume) {
    if (isNaN(volume) || volume < 0 || volume > 100) {
        alert("Please enter a valid volume between 0 and 100.");
    }
    else if (ytplayer) {
        ytplayer.setVolume(volume);
    }
}

function playVideo() {
    if (ytplayer) {
        $("#play_b").css('display', 'none');
        $("#play_p").css('display', 'block');
        ytplayer.playVideo();
    }
}

function pauseVideo() {
    if (ytplayer) {
        $("#play_p").css('display', 'none');
        $("#play_b").css('display', 'block');
        ytplayer.pauseVideo();
    }
}

function muteVideo() {
    if (ytplayer) {
        ytplayer.mute();
    }
}

function unMuteVideo() {
    if (ytplayer) {
        ytplayer.unMute();
    }
}


// This function is automatically called by the player once it loads
function onYouTubePlayerReady(playerId) {
    $('#play_b').on('click', function () {
        pauseVideo();
    });
    $('#play_p').on('click', function () {
        playVideo();
    });
    $('#next_b').on('click', function () {
        next();
    });
    $('#preview_b').on('click', function () {
        preview();
    });
    $('.btn-trash').on('click', function () {
        clearPlaylist();
    });
    $('#preload,#play').on('click', function (event) {
        eLeft = event.pageX - $('#seekbar').offset().left;
        var widthSeek = $('#seekbar').width();
        ytplayer.seekTo(Math.round(ytplayer.getDuration() * (eLeft / widthSeek)));
    });
    $('#preload,#play').on('click', function (event) {
        eLeft = event.pageX - $('#seekbar').offset().left;
        var widthSeek = $('#seekbar').width();
        ytplayer.seekTo(Math.round(ytplayer.getDuration() * (eLeft / widthSeek)));
    });
    $('#preload,#play').live('mousemove',function (event) {
        eLeft = event.pageX - $('#seekbar').offset().left;
        var widthSeek = $('#seekbar').width();
        $('#timeSearch').html(getTime(Math.round(ytplayer.getDuration() * (eLeft / widthSeek))));
        $('#timeSearch').css('display', 'block');
        $('#timeSearch').css('left', (event.pageX - ($('#timeSearch').width() / 2)) + 'px');
    });
    $('#preload,#play').live('mouseout', function () {
        $('#timeSearch').css('display', 'none');
    });
    $('#bar_v,#current_v').on('click', function (event) {
        eLeft = event.pageX - $('#bar_v').offset().left;
        var widthSeek = $('#bar_v').width();
        $('#current_v').css('width', (Math.round((eLeft / widthSeek) * $('#bar_v').width()) + 'px'));
        setVideoVolume(Math.round((eLeft / widthSeek) * 100));
    });
    ytplayer = document.getElementById("ytPlayer");
    // This causes the updatePlayerInfo function to be called every 250ms to
    // get fresh data from the player
    setInterval(updatePlayerInfo, 250);
    updatePlayerInfo();
    ytplayer.addEventListener("onStateChange", "onPlayerStateChange");
    ytplayer.addEventListener("onError", "onPlayerError");
    //Load an initial video into the player
    //ytplayer.cueVideoById("OeOdMsEWbB4");
}

// The "main method" of this sample. Called when someone clicks "Run".
function loadPlayer() {
    // Lets Flash from another domain call JavaScript
    var params = { allowScriptAccess: "always" };
    // The element id of the Flash embed
    var atts = { id: "ytPlayer" };
    // All of the magic handled by SWFObject (http://code.google.com/p/swfobject/)
    swfobject.embedSWF("http://www.youtube.com/apiplayer?" +
        "version=3&enablejsapi=1&playerapiid=player1",
        "videoDiv", "219", "200", "9", null, null, params, atts);
}

function addToQueue(id, after) {
    $.ajax({
        url: DOMAIN_NAME + '/addToQueue',
        type: 'post',
        dataType: 'json',
        data: { videoid: id},
        beforeSend: function () {
            $('.loadQueue, .successAddedToQueue').show();
            $('.successAddedToQueue').html('Ajout en cours à la playlist');
        },
        success: function (data, textStatus, jqXHR) {
            formatPlaylist(data.video, after);
        }
    });
}

function formatPlaylist(video, after) {
    if ( typeof after === 'undefined') {
        after = false;
    }
    $.each(video.items, function () {
        $c = $('#playlistContent .mCustomScrollBox .mCSB_container');
        $container = $('<div class="itemContainer ui-state-default" />');
        $item = $('<div class="itemPlaylist" data-id="' + this.id + '" data-viewcount="' + this.statistics.viewCount + '" data-title="' + this.snippet.title.replace(/"/g, "&quot;") + '" data-channelid="' + this.snippet.title.channelId + '" data-likecount="' + this.statistics.likeCount + '" data-dislikecount="' + this.statistics.dislikeCount + '"/>');
        $nameTitle = $('<div class="titlePlaylist"/>');
        $playIcon = $('<div class="buttonPlayPlaylist"/>');
        $deleteItem = $('<div class="deleteItemPlaylist"/>');

        len = this.snippet.title.length;
        if (len > 46) {
            title = (this.snippet.title.substr(0, 46) + ' ...');
        } else {
            title = this.snippet.title;
        }
        $nameTitle.html(title);
        $nameChannel = $('<div class="channelPlaylist"/>');
        $nameChannel.html('De ' + this.snippet.channelTitle);
        $nameTitle.append($nameChannel);
        $thumb = $('<div class="thumbPlaylist"/>');
        $thumb.html('<img src="' + this.snippet.thumbnails.default.url + '" width="64px" />');
        $item.append($thumb);
        $item.append($nameTitle);
        $item.append($playIcon);
        $container.append($item);
        $container.append($deleteItem);
        if (!after || $('#playlistContent .itemPlaylist.active').length == 0) {
            $c.append($container);
        } else {
            $('#playlistContent .itemPlaylist.active').parent().after($container);
        }

        playlistItem = $('#playlistContent .mCustomScrollBox .mCSB_container .itemPlaylist');
        if (playlistItem.size() == 1) {
            ytplayer.cueVideoById(this.id);
            launched(this.id);
            $('#title').html(this.snippet.title);
            ytplayer.playVideo();
            $item.addClass('active');
            $('#viewCount span').html(makeSeperator(this.statistics.viewCount, ' '));
            $('#viewCount').css('display', 'block');
            $('#vote').css('display', 'block');
            totLike = parseInt(this.statistics.likeCount) + parseInt(this.statistics.dislikeCount);
            $('#vote .like').css('width', Math.round(parseInt(this.statistics.likeCount) / (totLike) * 100) + '%');
            $('.btn-save').show();
            if (!$('.closeShowPlaylist').hasClass('open')) {
                $('#playlistContent, .underVideo, .closeShowPlaylist, #suggestionContent').toggleClass('open', 500);
                $('.closeShowPlaylist').html('<');
            }
        }
        if (ytplayer.getPlayerState() == 0) {
            next();
        }
        $('.loadQueue').hide();
        $('.btn-suggestion').show();
        $('.successAddedToQueue').html('Le titre a bien été ajouté à la playlist');
        $('.successAddedToQueue').delay(800).fadeOut();
    });
    $("#playlistContent .mCSB_container").sortable({ axis: "y" });
    $("#playlistContent .mCSB_container").disableSelection();
}

function _run() {
    loadPlayer();
}

function launch(element) {
    $('.itemPlaylist.active').removeClass('active');
    ytplayer.cueVideoById(element.data('id'));
    launched(element.data('id'));
    $('#title').html(element.data('title'));
    $('#viewCount span').html(makeSeperator(element.data('viewcount'), ' '));
    $('#vote .like').css('width', Math.round(element.data('likecount') / (element.data('likecount') + element.data('dislikecount')) * 100) + '%');
    ytplayer.playVideo();
    $('#viewCount').css('display', 'block');
    $('#vote').css('display', 'block');
    element.addClass('active');
}

function next() {
    element = $('.itemPlaylist.active').parent().next().children(".itemPlaylist")[0];
    if ($(element).hasClass('itemPlaylist')) {
        $('.itemPlaylist.active').removeClass('active');
        ytplayer.cueVideoById($(element).data('id'));
        launched($(element).data('id'));
        $('#title').html($(element).data('title'));
        $('#vote .like').css('width', Math.round($(element).data('likecount') / ($(element).data('likecount') + $(element).data('dislikecount')) * 100) + '%');
        $('#viewCount span').html(makeSeperator($(element).data('viewcount'), ' '));
        ytplayer.playVideo();
        $(element).addClass('active');

        if ($('.btn-suggestion').hasClass('active')) {
            getSuggestion($(element).data('id'));
        }
        return true;
    }
    return false;
}

function preview() {
    element = $('.itemPlaylist.active').parent().prev().children(".itemPlaylist")[0];
    if ($(element).hasClass('itemPlaylist')) {
        $('.itemPlaylist.active').removeClass('active');
        ytplayer.cueVideoById($(element).data('id'));
        launched($(element).data('id'));
        $('#title').html($(element).data('title'));
        $('#vote .like').css('width', Math.round($(element).data('likecount') / ($(element).data('likecount') + $(element).data('dislikecount')) * 100) + '%');
        $('#viewCount span').html(makeSeperator($(element).data('viewcount'), ' '));
        ytplayer.playVideo();
        $(element).addClass('active');
        if ($('.btn-suggestion').hasClass('active')) {
            getSuggestion($(element).data('id'));
        }
        return true;
    }
}

function clearPlaylist() {
    c = $('#playlistContent .mCustomScrollBox .mCSB_container');
    c.html('');
    $('#title').html('');
    $('#time').html('00:00');
    $('#preload').css('width', '0px');
    $('#play').css('width', '0px');
    $('#vote .like').css('width', '0px');
    $('#viewCount span').html('');
    $('#viewCount').css('display', 'none');
    $('#vote').css('display', 'none');
    ytplayer.cueVideoById('');
    $('.btn-save').hide();
    $('.btn-suggestion').hide();
    return false;
}

function makeSeperator(n, seperator) {
    var rx = /(\d+)(\d{3})/;
    return String(n).replace(/^\d+/, function (w) {
        while (rx.test(w)) {
            w = w.replace(rx, '$1' + seperator + '$2');
        }
        return w;
    });
}

function deleteItem(element) {
    if ($('.itemContainer').length === 1) {
        clearPlaylist();
    } else {
        elementItem = element.parent().children('.itemPlaylist')[0];
        if ($(elementItem).hasClass('active')) {
            if (next()) {
                element.parent().remove();
            } else {
                $('#title').html('');
                $('#time').html('00:00');
                $('#preload').css('width', '0px');
                $('#play').css('width', '0px');
                $('#vote .like').css('width', '0px');
                $('#viewCount span').html('');
                $('#viewCount').css('display', 'none');
                $('#vote').css('display', 'none');
                ytplayer.cueVideoById('');
                element.parent().remove();
            }
        } else {
            element.parent().remove();
        }
    }
}

function getSuggestion(id) {
    $('#suggestionContent').show();
    $c = $('#suggestionContent .mCustomScrollBox .mCSB_container');
    $c.html('');
    $.ajax({
        url: DOMAIN_NAME + '/getSuggestion',
        type: 'post',
        dataType: 'json',
        data: { videoid: id},
        beforeSend: function () {
            $('.loadQueue, .successAddedToQueue').show();
            $('.successAddedToQueue').html('Chargement de la suggestion');
        },
        success: function (data, textStatus, jqXHR) {
            formatSuggestion(data.suggestion);
        }
    });
}


function formatSuggestion(video) {
    $c = $('#suggestionContent .mCustomScrollBox .mCSB_container');
    $.each(video.items, function () {
        $container = $('<div class="itemContainer ui-state-default" />');
        $item = $('<div class="itemPlaylist" data-id="' + this.id.videoId + '" data-title="' + this.snippet.title.replace(/"/g, "&quot;") + '" data-channelid="' + this.snippet.title.channelId + '"/>');
        $nameTitle = $('<div class="titlePlaylist"/>');
        $playIcon = $('<div class="buttonPlaySuggestion"/>');

        len = this.snippet.title.length;
        if (len > 46) {
            title = (this.snippet.title.substr(0, 46) + ' ...');
        } else {
            title = this.snippet.title;
        }
        $nameTitle.html(title);
        $nameChannel = $('<div class="channelPlaylist"/>');
        $nameChannel.html('De ' + this.snippet.channelTitle);
        $nameTitle.append($nameChannel);
        $thumb = $('<div class="thumbPlaylist"/>');
        $thumb.html('<img src="' + this.snippet.thumbnails.default.url + '" width="64px" />');
        $item.append($thumb);
        $item.append($playIcon);
        $item.append($nameTitle);
        $container.append($item);
        $c.append($container);

        $('.loadQueue').hide();
        $('.successAddedToQueue').delay(800).fadeOut();
    });
}

function auth(connected) {
    if (connected == 'true') {
        $('.reloadAfterAuth').each(function(){
            var container = $(this).data('container');
            $.ajax({
                type: 'GET',
                url: $(this).data('url'),
                cache: false,
                dataType: 'html',
                success: function (data) {
                    $('.' + container).html(data);
                }
            }).done(function () {
                sendFormToAjax();
            });
        });
    }
}

function showError(message) {
    $('.errorMessage').html(message).show().delay(3000).fadeOut();
}

function formatPlayingList(info) {
    $.ajax({
        url: DOMAIN_NAME + '/getVideoInfo/'+info.videoId ,
        type: 'POST',
        dataType: 'json',
        cache: true,
        success: function (data) {
            $.each(data.video.items, function () {
                $c = $('.infoPlayed .contentPlayed .mCSB_container');
                $container = $('<div class="launched" id="'+info.id+'"  />');
                $item = $('<div class="itemLaunched" data-id="' + this.id + '" data-viewcount="' + this.statistics.viewCount + '" data-title="' + this.snippet.title.replace(/"/g, "&quot;") + '" data-channelid="' + this.snippet.title.channelId + '" data-likecount="' + this.statistics.likeCount + '" data-dislikecount="' + this.statistics.dislikeCount + '"/>');
                $nameTitle = $('<div class="titleLaunched"/>');
                $playIcon = $('<div class="buttonPlaying"/>');
                len = this.snippet.title.length;
                if (len > 46) {
                    title = (this.snippet.title.substr(0, 40) + ' ...');
                } else {
                    title = this.snippet.title;
                }
                $nameTitle.html(title);
                $nameChannel = $('<div class="channelLaunched"/>');
                $nameChannel.html('De ' + this.snippet.channelTitle);
                $nameTitle.append($nameChannel);
                $thumb = $('<div class="thumbLaunched"/>');
                $thumb.html('<img src="' + this.snippet.thumbnails.default.url + '" width="64px" />');
                $item.append($thumb);
                $item.append($playIcon);
                $item.append($nameTitle);
                $container.append($item);
                $c.prepend($container);
            });
        }
    });
}

function launched(videoId) {
    if (typeof socket != 'undefined') {
        user.videoId = videoId
        socket.emit('launch', user);
    }
    return false;
}

function forceLoad(url) {
    $('#loading').show();
    $.ajax({
        url: DOMAIN_NAME + url,
        type: 'POST',
        dataType: 'json',
        cache: true,
        success: function (data, textStatus, jqXHR) {
            document.title = data.title;
            $('#content').html(data.content);
            $('#loading').hide();
            setupCustomScrollbar();
            return false;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showError('Oh Mince ! Une erreur est survenue pendant le chargement de la page :\'(');
            return false;
        }
    });
}