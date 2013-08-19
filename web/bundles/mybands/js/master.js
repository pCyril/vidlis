var retard;
var current;
var queue = new Array();

function rechercher(){
	clearTimeout(retard);
	var val = $('#input-search').val();
	if(val != '' && val.length > 2){
		$('#rech').show();
		$('#rech').html('<center><img src="./images/load.gif"></center>');
		t = document.getElementById('input-search');
		$('#rech').show();
		$.ajax({
				url: './content/seach/index.php',
				type: 'get',
				data: 'search='+val,
				success: function(data) {
					$('#rech').html(data);
				}

		});
	}else{
		$('#rech').hide();
	}
}
function timer(){
	clearTimeout(retard);
	retard = setTimeout("rechercher()",1000);
}

function getSelectedElement(id){
	return document.getElementById(id).options[document.getElementById(id).selectedIndex].value;
}

function getCheckedElement(id){
	return 'test';
}

function getValue(id){
	return document.getElementById(id).value;
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