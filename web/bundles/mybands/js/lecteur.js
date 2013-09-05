var duration;
var volumeVar = 1;
function load_musique(id, dure, numQueue){
duration = dure;
urlMusique = DOMAIN_NAME + 'includes/download.php';
	$("#jquery_jplayer_1").jPlayer({
		solution:"flash, html",
		ready: function () {
		$(this).jPlayer("setMedia", {
			mp3: urlMusique,		
		});
		$("#jquery_jplayer_1").jPlayer("load");
		$("#jquery_jplayer_1").jPlayer("play");
		$("#play_b").css('display','block');
		$("#play_p").css('display','none');
		$("#" + id + '_' + numQueue).addClass('active');
		$(this).bind($.jPlayer.event.timeupdate, function(event) {
			preload = 500 * ((Math.floor($(this).data("jPlayer").status.duration*10)/10)/duration);
			result = 500 * ((Math.floor($(this).data("jPlayer").status.currentTime*10)/10)/duration);
			$("#time").html(getTime(Math.floor($(this).data("jPlayer").status.currentTime)));
			if (!isNaN(parseInt(result))) {
				$("#play").css('width', result);
				$("#preload").css('width', preload);
				$("#icon_play").css('left', result - 10);
				if ($(this).data("jPlayer").status.currentTime >= duration) {
					if(next()){
						$("#play_b").css('display','none');
						$("#play_p").css('display','block');
						$(this).unbind($.jPlayer.event.timeupdate);
					} else {
						$("#play_b").css('display','none');
						$("#play_p").css('display','block');
					}
				}
			} else {
				$("#play").css('width', 0);
				$("#icon_play").css('left',  -10);
			}		
		});
		$(this).bind($.jPlayer.event.progress, function(event) {
		});
		// Gestion de lecture
		$("#play_b").click(function(){
			$("#play_b").css('display','none');
			$("#play_p").css('display','block');
			$("#jquery_jplayer_1").jPlayer("pause");
		});			
		$("#play_p").click(function(){
			$("#play_p").css('display','none');
			$("#play_b").css('display','block');
			$("#jquery_jplayer_1").jPlayer("play");
		});		
		// Gestion du volume
		$("#bar_v").click(function(e){
			largVolume = e.pageX - ds_getleft(document.getElementById('bar_v'));
			$("#current_v").css("width", largVolume + "px");	
			$("#cursor_v").css("left", largVolume-6 + "px");
			volumeVar = largVolume / 61;	
			$("#jquery_jplayer_1").jPlayer("volume", volumeVar);		
		});		
		// Gestion du mute
		$("#icon_v").click(function(){
			if($("#jquery_jplayer_1").data("jPlayer").status.muted == true){
				$("#jquery_jplayer_1").jPlayer("unmute");
			}else{
				$("#jquery_jplayer_1").jPlayer("mute");
			}		
		});		
		// Gestion de lecture
		$("#preload").click(function(e){
			largPlay = e.pageX - ds_getleft(document.getElementById('preload'));
			$("#play").css("width", largPlay + "px");
			$("#icon_play").css('left', largPlay - 10);
			time = (largPlay / 500) * duration;
			$("#play_p").css('display','none');
			$("#play_b").css('display','block');
			$("#jquery_jplayer_1").jPlayer("play", time);
		});
		$("#play").click(function(e){
			largPlay = e.pageX - ds_getleft(document.getElementById('play'));
			$("#play").css("width", largPlay + "px");
			$("#icon_play").css('left', largPlay - 10);	
			time = (largPlay / 500) * $("#jquery_jplayer_1").data("jPlayer").status.duration;	
			$("#play_p").css('display','none');	
			$("#play_b").css('display','block');
			$("#jquery_jplayer_1").jPlayer("play", time);		
		});		
		}, 
		swfPath: DOMAIN_NAME + "/js/jPlayer",
		supplied: "mp3",
		volume: volumeVar	
		});
}
function getTime(current){
        current = parseInt(current);
	if (current % 60 != current){
		secondes = current % 60;
		minutes = (current - secondes) / 60;
		return (formatNumber(minutes) + ':' + formatNumber(secondes));
	} else {
		return ('00:' + formatNumber(current));
	}
}
function formatNumber(nb){
	if (nb < 10) {
		return ('0' + nb);	
	} else {
		return (nb);	
	}
}

function ds_getleft(el){
	var tmp=el.offsetLeft;
	el = el.offsetParent;
	while(el){
		tmp += el.offsetLeft;el=el.offsetParent;
	}
return tmp;
}