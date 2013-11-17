$(document).ready(function() {
	$('.formSearch').live('submit', function() {
        if ($('#search').val()) {
            url = '/fr/search/'+encodeURIComponent($('#search').val());
            loadBox(url);
        } else {
            showError('Oui, mais tu cherches quoi exactement ?');
        }
		return false;
	});
    $('.closeShowPlaylist').live('click', function() {
        $('#playlistContent, .underVideo, .closeShowPlaylist').toggleClass('open', 500);
        if ($('.closeShowPlaylist').hasClass('open')) {
            $('.closeShowPlaylist').html('>');
        } else {
            $('.closeShowPlaylist').html('<');
        }
    });
    $('.formSearchHome').live('submit', function() {
        if ($('#search').val()) {
            url = '/fr/search/'+encodeURIComponent($('#q').val());
            loadBox(url);
        } else {
            showError('Oui, mais tu cherches quoi exactement ?');
        }
        return false;
    });
        setupCustomScrollbar();
        $(".itemSearch ").live("click", function(){
            addToQueue($(this).data('id'));
        });
    $(".rowItem ").live("click", function(){
        addToQueue($(this).data('id'));
    });
        $(".itemPlaylist").live("click", function(){
            launch($(this));
        });
        $(".deleteItemPlaylist").live("click", function(){
            deleteItem($(this));
        });
        $(".btn-repeat").on("click", function(){
            return setRepeat($(this));
        });
        $('#playlistContent').css('height', ($(window).height() - 89) + 'px' );
        $('#playlistContent').mCustomScrollbar(
                {scrollInertia: 0, mouseWheel: true, autoHideScrollbar:true,
                 advanced:{
                    updateOnContentResize: true
                 }}
        );
    $('.loadPlaylist').live('click', function() {
        $('#'+$(this).data('idplaylist')+' .rowItem').each(function() {
            addToQueue($(this).data('id'));
        });
    });
});
$( window ).resize(function() {
    $('#playlistContent').css('height', ($(window).height() - 89) + 'px' );
});
$(".modal .close").live('click', function(){
    $('.modal, .overlay').hide();
});
$(".toModal").live('click', function(){
    element = $(this);
    $.ajax({
        type : 'GET',
        url: this,
        cache: false,
        dataType : 'json',
        beforeSend: function (){
           $(".modal-header h4").html('Chargement en cours');
           $(".modal-body").html('');
           $('.modal, .overlay').show();
        },
        success: function(data){
          if (data.result) {
              if (element.data('callback')) {
                  eval(element.data('callback'));
              } else {
                  $('.modal').show();  
                  $(".modal-header h4").html(data.title);
                  $(".modal-body").html(data.content);
              }
          } else {
              $('.modal').show();  
              $(".modal-header h3").html(data.title);
              $(".modal-body").html(data.content);
           }
        },
        error: function(){
          $(".modal-header h3").html('Oups :\'(');
          $(".modal-body").html('Une erreur c\'est produite');
        }
    }).done(function() {
            sendFormToAjax();
    });
    return false;
    }
);


$(".toModalHTML").live('click', function(){
        element = $(this);
        $.ajax({
            type : 'GET',
            url: this,
            cache: false,
            dataType : 'html',
            beforeSend: function (){
                $(".modal-header h4").html('Chargement en cours');
                $(".modal-body").html('');
                $('.modal, .overlay').show();
            },
            success: function(data){
                $('.modal').show();
                $(".modal-content").html(data);
            },
            error: function(){
                $(".modal-header h3").html('Oups :\'(');
                $(".modal-body").html('Une erreur c\'est produite');
            }
        }).done(function() {
                sendFormToAjax();
            });
        return false;
    }
);

function timer(){
	clearTimeout(retard);
	retard = setTimeout("rechercher()",1000);
}

function getSelectedElement(id){
	return document.getElementById(id).options[document.getElementById(id).selectedIndex].value;
}
function hide(div){$("#"+ div).hide();}
function show(div){$("#"+ div).show();}
function loadBox(url){
    if ($.address.value() != url) {
	    $.address.value(url);
    } else {
        forceLoad(url);
    }
}
function mCustomScrollbars(){
	//$("#list").mCustomScrollbar("horizontal",10,"easeOutCirc",1,"fixed","no","yes",20); 
}

/* function to load new content dynamically */
function LoadNewContent(id,file){
    $("#"+id+" .customScrollBox .content").load(file,function(){
            mCustomScrollbars();
    });
}

function setupCustomScrollbar() 
{
    $(".mCustomScrollbarActiv").each(function() {
            $(this).mCustomScrollbar(
                    {scrollInertia: 0}
            );
    });
}

function sendFormToAjax() {
    $(".form-ajax").unbind();
    $(".form-ajaxHTML").unbind();
    var isLoding = false
	$(".form-ajax").each(function(index, element){
		form = $( element );
        if (!isLoding) {
        $( element ).submit(function() {
        	post = $(element).serialize();
        	$.ajax({
        		type : 'post',
      		  	url: $(element).attr('action'),
      		  	cache: false,
      		  	dataType : 'json',
      		  	data : post,
      		  	beforeSend: function (){
                    isLoding = true;
      		  	},
      		  	success: function(data){
                    idContainer = form.data('container');
                    $('.'+idContainer).html(data.content);
                    sendFormToAjax();
                    isLoding = false;
      		  	},
      		  	error: function(){
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

    $(".form-ajaxHTML").each(function(index, element){
        form = $( element );
        if (!isLoding) {
        $( element ).submit(function() {
            post = $(element).serialize();
            $.ajax({
                type : 'post',
                url: $(element).attr('action'),
                cache: false,
                dataType : 'html',
                data : post,
                beforeSend: function (){
                    isLoding = true;
                },
                success: function(data){
                    idContainer = form.data('container');
                    $('.'+idContainer).html(data);
                    sendFormToAjax();
                    isLoding = false;
                },
                error: function(){
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
  alert("An error occured of type:" + errorCode);
}

// This function is called when the player changes state
function onPlayerStateChange(newState) {
  if (newState == -1 || newState == 0 || newState == 2 || newState == 3) {
    $("#play_b").css('display','none');
    $("#play_p").css('display','block');
  } else {
    $("#play_p").css('display','none');
    $("#play_b").css('display','block');
  }
  if (newState == 0) {
      next();
  }
}

// Display information about the current state of the player
function updatePlayerInfo() {
  // Also check that at least one function exists since when IE unloads the
  // page, it will destroy the SWF before clearing the interval.
  if(ytplayer && ytplayer.getDuration) {
    updateHTML("time", getTime(ytplayer.getCurrentTime()));
    
    duration = ytplayer.getDuration();
    preload = parseInt($('#seekbar').css('width')) * ((Math.floor(ytplayer.getVideoBytesLoaded()*10)/10)/ytplayer.getVideoBytesTotal());
    result = parseInt($('#seekbar').css('width')) * ((Math.floor(ytplayer.getCurrentTime()*10)/10)/duration);
    $("#play").css('width', result);
    $("#preload").css('width', preload);
  }
}

// Allow the user to set the volume from 0-100
function setVideoVolume(volume) {
  if(isNaN(volume) || volume < 0 || volume > 100) {
    alert("Please enter a valid volume between 0 and 100.");
  }
  else if(ytplayer){
    ytplayer.setVolume(volume);
  }
}

function playVideo() {
  if (ytplayer) {
    $("#play_b").css('display','none');
    $("#play_p").css('display','block');
    ytplayer.playVideo();
  }
}

function pauseVideo() {
  if (ytplayer) {
    $("#play_p").css('display','none');
    $("#play_b").css('display','block');
    ytplayer.pauseVideo();
  }
}

function muteVideo() {
  if(ytplayer) {
    ytplayer.mute();
  }
}

function unMuteVideo() {
  if(ytplayer) {
    ytplayer.unMute();
  }
}


// This function is automatically called by the player once it loads
function onYouTubePlayerReady(playerId) {
  $('#play_b').on('click', function(){
      pauseVideo();
  });
  $('#play_p').on('click', function(){
      playVideo();
  });
  $('#next_b').on('click', function(){
      next();
  });
  $('#preview_b').on('click', function(){
      preview();
  });
  $('#seekbar').on('click', function(){
      playVideo();
  });
  $('.btn-trash').on('click', function(){
      clearPlaylist();
  });
  $('#preload,#play').on('click', function(event){
        eLeft = event.pageX - $('#seekbar').offset().left;
        var widthSeek = $('#seekbar').width();
        ytplayer.seekTo(Math.round(ytplayer.getDuration()* (eLeft/widthSeek)));
  });
  $('#preload,#play').on('click', function(event){
        eLeft = event.pageX - $('#seekbar').offset().left;
        var widthSeek = $('#seekbar').width();
        ytplayer.seekTo(Math.round(ytplayer.getDuration()* (eLeft/widthSeek)));
  });
  $('#preload,#play').mousemove(function(event){
        eLeft = event.pageX - $('#seekbar').offset().left;
        var widthSeek = $('#seekbar').width();
        $('#timeSearch').html(getTime(Math.round(ytplayer.getDuration()* (eLeft/widthSeek))));
        $('#timeSearch').css('display', 'block');
        $('#timeSearch').css('left', (event.pageX - ($('#timeSearch').width() / 2)) + 'px');
  });
  $('#preload,#play').mouseout(function(){
        $('#timeSearch').css('display', 'none');
  });
  $('#bar_v,#current_v').on('click', function(event){
        eLeft = event.pageX - $('#bar_v').offset().left;
        var widthSeek = $('#bar_v').width();
        $('#current_v').css('width', (Math.round((eLeft/widthSeek) * $('#bar_v').width()) + 'px'));
        setVideoVolume(Math.round((eLeft/widthSeek) * 100));
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

function addToQueue(id)
{
$.ajax({
    url:  DOMAIN_NAME + '/fr/addToQueue',
    type: 'post',
    dataType: 'json',
    data: { videoid: id},
    beforeSend: function (){
        $('.loadQueue, .successAddedToQueue').show();
        $('.successAddedToQueue').html('Ajout en cours à la playlist');
    },
    success: function (data, textStatus, jqXHR) {
        formatPlaylist(data.video);
    }
});
}

function formatPlaylist(video) {
$.each(video.items, function() {
    $c = $('#playlistContent .mCustomScrollBox .mCSB_container');
    $container = $('<div class="itemContainer" />');
    $item = $('<div class="itemPlaylist" data-id="'+this.id+'" data-viewcount="'+this.statistics.viewCount+'" data-title="'+this.snippet.title+'" data-channelid="'+this.snippet.title.channelId+'" data-likecount="'+this.statistics.likeCount+'" data-dislikecount="'+this.statistics.dislikeCount+'"/>');
    $nameTitle = $('<div class="titlePlaylist"/>');
    $deleteItem = $('<div class="deleteItemPlaylist"/>');

    len=this.snippet.title.length;
    if(len>46)
    {
        title = (this.snippet.title.substr(0,46)+' ...');
    } else {
        title = this.snippet.title
    }
    $nameTitle.html(title);
    $nameChannel = $('<div class="channelPlaylist"/>');
    $nameChannel.html('De ' + this.snippet.channelTitle);
    $nameTitle.append($nameChannel);
    $thumb = $('<div class="thumbPlaylist"/>');
    $thumb.html('<img src="' + this.snippet.thumbnails.default.url + '" width="64px" />');
    $item.append($thumb);
    $item.append($nameTitle);
    $container.append($item);
    $container.append($deleteItem);
    $c.append($container);

    playlistItem = $('#playlistContent .mCustomScrollBox .mCSB_container .itemPlaylist');
    if (playlistItem.size() == 1){
        ytplayer.cueVideoById(this.id);
        $('#title').html(this.snippet.title);
        ytplayer.playVideo();
        $item.addClass('active');
        $('#viewCount span').html(makeSeperator(this.statistics.viewCount, ' '));
        $('#viewCount').css('display', 'block');
        $('#vote').css('display', 'block');
        totLike = parseInt(this.statistics.likeCount) + parseInt(this.statistics.dislikeCount);
        $('#vote .like').css('width', Math.round(parseInt(this.statistics.likeCount) / (totLike) * 100) + '%');
    }
    $('.loadQueue').hide();
    $('.successAddedToQueue').html('Le titre a bien été ajouté à la playlist');
    $('.successAddedToQueue').delay( 800 ).fadeOut();
});
}

function _run() {
  loadPlayer();
}

function launch(element) {
    $('.itemPlaylist.active').removeClass('active');
    ytplayer.cueVideoById(element.data('id'));
    $('#title').html(element.data('title'));
    $('#viewCount span').html(makeSeperator(element.data('viewcount'), ' '));
    $('#vote .like').css('width', Math.round(element.data('likecount') / (element.data('likecount')+element.data('dislikecount')) * 100) + '%');
    ytplayer.playVideo();
    $('#viewCount').css('display', 'block');
    $('#vote').css('display', 'block');
    element.addClass('active');
}

function next() {
    element = $('.itemPlaylist.active').parent().next().children( ".itemPlaylist" )[0];
    if ($(element).hasClass('itemPlaylist')) {
        $('.itemPlaylist.active').removeClass('active');
        ytplayer.cueVideoById($(element).data('id'));
        $('#title').html($(element).data('title'));
        $('#vote .like').css('width', Math.round($(element).data('likecount') / ($(element).data('likecount')+$(element).data('dislikecount')) * 100) + '%');
        $('#viewCount span').html(makeSeperator($(element).data('viewcount'), ' '));
        ytplayer.playVideo();
        $(element).addClass('active');
        return true;
    } else {
        if ($(".btn-repeat").hasClass('active')) {
            element = $('.itemPlaylist').first();
            $('.itemPlaylist.active').removeClass('active');
            ytplayer.cueVideoById(element.data('id'));
            $('#title').html(element.data('title'));
            $('#vote .like').css('width', Math.round(element.data('likecount') / (element.data('likecount')+element.data('dislikecount')) * 100) + '%');
            $('#viewCount span').html(makeSeperator(element.data('viewcount'), ' '));
            ytplayer.playVideo();
            element.addClass('active');
            return true;
        }
    }
    return false;
}

function preview() {
    element = $('.itemPlaylist.active').parent().prev().children( ".itemPlaylist" )[0];
    if ($(element).hasClass('itemPlaylist')) {
        $('.itemPlaylist.active').removeClass('active');
        ytplayer.cueVideoById($(element).data('id'));
        $('#title').html($(element).data('title'));
        $('#vote .like').css('width', Math.round($(element).data('likecount') / ($(element).data('likecount')+$(element).data('dislikecount')) * 100) + '%');
        $('#viewCount span').html(makeSeperator($(element).data('viewcount'), ' '));
        ytplayer.playVideo();
        $(element).addClass('active');
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
    return false;
}
function setRepeat(element) {
    if (element.hasClass('active')) {
        element.removeClass('active');
    } else {
        element.addClass('active');
    }
    return false;
}

function makeSeperator(n, seperator){
    var rx=  /(\d+)(\d{3})/;
    return String(n).replace(/^\d+/, function(w){
        while(rx.test(w)){
            w= w.replace(rx, '$1'+seperator+'$2');
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

function auth(connected) {
    if (connected == 'true') {
        $('.youtubeAuthen').html('Authentifié');
    } else {
        $('.youtubeAuthen').html('Echec de l\'authentification');
    }
}

function showError(message) {
    $('.errorMessage').html(message).show().delay(3000).fadeOut();
}