var current;
var queue = new Array();


$(document).ready(function() {
	$('#formSearch').bind('submit', function() {
		url = '/fr/search/'+encodeURIComponent($('#search').val());
		loadBox(url);
		return false;
	});
        setupCustomScrollbar();
});

function timer(){
	clearTimeout(retard);
	retard = setTimeout("rechercher()",1000);
}

function getSelectedElement(id){
	return document.getElementById(id).options[document.getElementById(id).selectedIndex].value;
}

function connexion(data){
	user = data.user;
}

function display(element){
	$close = $("#" + element.id + " .delete");
	$close.css('display', 'block');
}

function hideClose(element){
$close=$("#"+element.id+" .delete");
$close.css('display', 'none');
}

function deleteFromQueue(id, numQueue){
	if (numQueue == current){
		$("#jquery_jplayer_1").jPlayer("destroy");
		$("#play_b").css('display','none');
		$("#play_p").css('display','block');
		$("#play").css('width', 0);
		$("#icon_play").css('left', -10);
		$("#time").html('--:--');
		next();
	}
	queue[numQueue] = '';
	playlistItem = $('.content .item');
	$('#'+id).remove();
	dragger = $(".customScrollBox .dragger");
	container = $(".customScrollBox .container");
	left = dragger.css('left');
	container.css('width', (playlistItem.size() * 210));
	mCustomScrollbars();
	dragger.css('left', left);
	if(left != 'auto') {
		left = parseFloat(left.substr(0, (left.length - 2))) * 1.4;
		container.css('left', "-"+left+"px");
	}
}

function hide(div){$("#"+ div).hide();}
function show(div){$("#"+ div).show();}

function loadBox(url){
	$.address.value(url);
}
function mCustomScrollbars(){
	//$("#list").mCustomScrollbar("horizontal",10,"easeOutCirc",1,"fixed","no","yes",20); 
}

function addToPlaylist(id){
	$.ajax({
		url:  DOMAIN_NAME + 'contents/getTitle.php',
		type: 'get',
		dataType: 'json',
		data: { idTitle: id},
		success: function (data, textStatus, jqXHR) {
			formatPlaylist(data);
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(textStatus);
		}
	});
}

function addAlbumToPlaylist(id){
	$.ajax({
		url:  DOMAIN_NAME + 'contents/getAlbumList.php',
		type: 'get',
		dataType: 'json',
		data: { idAlbum: id},
		success: function (data, textStatus, jqXHR) {
			$.each(data, function() {
				formatPlaylist(this);
			})
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert(textStatus);
		}
	});
}

function launch(numToLaunch){
	if (numToLaunch != current){
		$item = $("#" + queue[current].id + "_" + current);
		$item.removeClass('active');
		current = numToLaunch;
		$("#jquery_jplayer_1").jPlayer("destroy");
		beforeLoad( queue[current].id, queue[current].duration, current);
	}
}

function next(){
	nextItem = parseInt(current) + 1;
	$item = $("#" + queue[current].id + "_" + current);
	if(queue.length != nextItem){
		current = parseInt(current) + 1;
		if (queue[current] != ''){
			$item.removeClass('active');
			$("#jquery_jplayer_1").jPlayer("destroy");
			beforeLoad( queue[current].id, queue[current].duration, current);
			return true;
		} else {
			$item.removeClass('active');
			next();
		}
	} else {
		return false;
	}
}

function preview(){
	$item = $("#" + queue[current].id + "_" + current);
	previewItem = parseInt(current) - 1;
	if(previewItem != -1){
		$item.removeClass('active');
		current = parseInt(current) - 1;
		if (queue[current] != ''){
			$("#jquery_jplayer_1").jPlayer("destroy");
			beforeLoad(queue[current].id, queue[current].duration, current);
		} else {
			preview();
		}
	}
}

function formatPlaylist(data){

		beforeLoad(data.id, data.duration, length);
		current = parseInt(length);
}

/* function to load new content dynamically */
function LoadNewContent(id,file){
$("#"+id+" .customScrollBox .content").load(file,function(){
	mCustomScrollbars();
});
}
function clearList(){
	queue = new Array();
	$(".customScrollBox .container .content").html('');
	$("#trash").css("display", "none");
	$("#jquery_jplayer_1").jPlayer("destroy");
	$("#play_b").css('display','none');
	$("#play_p").css('display','block');
	$("#play").css('width', 0);
	$("#icon_play").css('left', -10);
	$("#time").html('--:--');
	if($('#list').css('top') != '-48px'){
		upAndDown();
	}
	next();
}

function upAndDown(){
	if($('#list').css('top') != '-48px'){
		$('#list').animate({
			top: '-48'
		}, 500);
		$('#main-lecteur').animate({
			top: '53'
		}, 500);
		$('#arrow').animate({
			top: '53'
		}, 500, function(){
			$('#arrow i').removeClass('icon-arrow-up');
			$('#arrow i').addClass('icon-arrow-down');
		/*$('#wrap_content').animate({
			top: '110'
		}, 500);*/
		});
	} else {
		$('#list').animate({
			top: '52'
		}, 500);
		$('#main-lecteur').animate({
			top: '153'
		}, 500);
		$('#arrow').animate({
			top: '153'
		}, 500, function(){
			$('#arrow i').removeClass('icon-arrow-down');
			$('#arrow i').addClass('icon-arrow-up');
		/*$('#wrap_content').animate({
			top: '210'
		}, 500);*/
		});
	}
}

function beforeLoad(id, dure, numQueue) {
	$.ajax({
		url:  DOMAIN_NAME + 'contents/ajax/secureId.php',
		type: 'post',
		dataType: 'json',
		data: { idTitle: id},
		success: function (data, textStatus, jqXHR) {
				load_musique(id, dure, numQueue);
		}
	});
}


function setupCustomScrollbar() 
{
    $(".mCustomScrollbar").each(function() {
            $(this).mCustomScrollbar(
                    {scrollInertia: 0}
            );
    });
}

function sendFormToAjax() {
	$(".form-ajax").each(function(index, element){
		form = $( element );
        $( element ).submit(function() {
        	post = $(element).serialize();
        	$.ajax({
        		type : 'post',
      		  	url: $(element).attr('action'),
      		  	cache: false,
      		  	dataType : 'json',
      		  	data : post,
      		  	beforeSend: function (){
  		  			html = '<div class="alert alert-info">Envoi en cours.</div>';
  		  			form.find('.callbackDiv').html(html)
      		  	},
      		  	success: function(data){
      		  		if (data.result) {
      		  			html = '<div class="alert alert-success">' + data.message + '<button type="button" class="close closeAlert" data-dismiss="alert">×</button></div>';
      		  			form.find('.callbackDiv').html(html);
      		  			if (data.callback !== 'undifined') {
      		  				eval(data.callback);
      		  			}
      		  		} else {
      		  			html = '<div class="alert alert-error">' + data.message + '<button type="button" class="close closeAlert" data-dismiss="alert">×</button></div>';
      		  			form.find('.callbackDiv').html(html);
      		  		}
      		  	},
      		  	error: function(){
      		  		$(".modal-header h3").html('Oups :\\');
      		  		$(".modal-body").html('Une erreur c\'est produite');
      		  	}
        	});
        	return false;
        });
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
function setVideoVolume() {
  var volume = parseInt(document.getElementById("volumeSetting").value);
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
  $('#seekbar').on('click', function(){
      playVideo();
  });
  ytplayer = document.getElementById("ytPlayer");
  // This causes the updatePlayerInfo function to be called every 250ms to
  // get fresh data from the player
  setInterval(updatePlayerInfo, 250);
  updatePlayerInfo();
  ytplayer.addEventListener("onStateChange", "onPlayerStateChange");
  ytplayer.addEventListener("onError", "onPlayerError");
  //Load an initial video into the player
  ytplayer.cueVideoById("jrdYgY-UiCM");
}

// The "main method" of this sample. Called when someone clicks "Run".
function loadPlayer() {
  // Lets Flash from another domain call JavaScript
  var params = { allowScriptAccess: "always", autostart: true };
  // The element id of the Flash embed
  var atts = { id: "ytPlayer" };
  // All of the magic handled by SWFObject (http://code.google.com/p/swfobject/)
  swfobject.embedSWF("http://www.youtube.com/apiplayer?" +
                     "version=3&enablejsapi=1&playerapiid=player1", 
                     "videoDiv", "480", "295", "9", null, null, params, atts);
}


function _run() {
  loadPlayer();
}