declare var YT: any;

import {
  Component,
  OnInit
} from '@angular/core';
import { PlayerService } from './player.service';
import { SigninService } from './../signin/signin.service'

@Component({
  selector: 'player',
  styleUrls: [ './player.component.css' ],
  templateUrl: './player.component.html'
})

export class PlayerComponent implements OnInit {

  public YTPlayer;
  public state = -1;
  public ready = false;
  public latestVideoAdded = {};
  public suggests = {'items': []};
  public showPopup = false;
  public showSuggests = false;
  public modeAuto = false;
  public suggestsLoading = false;
  public savePlaylist = false;
  public autoLoading = false;
  public playlistCreated = false;
  public popupTimeout;

  constructor(
      public playerService: PlayerService,
      public signinService: SigninService
  ) {
      this.playerService.subject.subscribe(
          value => {
              this.latestVideoAdded = value[this.playerService._videos.length - 1];
              this.showPopup = true;
              if (this.ready && this.playerService._videos.length == 1) {
                  this.YTPlayer.cueVideoById(value[this.playerService._videos.length - 1].id);
                  this.playerService._currentIndex = this.playerService._videos.length - 1;
                  this.play(true);
              }
              
              if (this.popupTimeout) {
                  clearTimeout(this.popupTimeout);
              }

              this.popupTimeout = setTimeout(() => {
                  this.showPopup = false;
              }, 5000)
          }
      );
  }

  public ngOnInit() {
      this.YTPlayer = new YT.Player('youtube-player', {
          height: '250',
          width: '250',
          playerVars: {
              controls: 0
          },
          events: {
              onReady: this.onYTPlayerReady.bind(this),
              onStateChange: this.onYTPlayerStateChange.bind(this),
              onError: this.onYTPlayerError.bind(this)
          }
      });
  }

  public onYTPlayerReady() {
    this.ready = true;
    setTimeout(this.styleLoading.bind(this), 100);
    setTimeout(this.stylePlayed.bind(this), 100);
  }

  public onYTPlayerStateChange(data) {
    this.state = data.data;
    if (data.data === 0) {
        this.forward();
    }
  }

  public toggleScreenMode() {
      this.playerService._fullScreenMode = !this.playerService._fullScreenMode;
      if (this.playerService._fullScreenMode) {
          this.YTPlayer.setSize(window.innerWidth, window.innerHeight - 160);
      } else {
          this.YTPlayer.setSize(250, 250);
      }
  }

  public getPlayerStyle() {
      if (this.playerService._fullScreenMode) {
          document.getElementById('youtube-player').style.top = ((window.innerHeight - 60) * -1) + "px";
          return {top: window.innerHeight - 160};
      } else {
          document.getElementById('youtube-player').style.top = "-250px";
      }

      return {};
  }

  public removeTrack(index) {
      this.playerService._videos.splice(index, 1);
      if (this.playerService._currentIndex > index) {
          this.playerService._currentIndex -= 1;
      }
      if (this.playerService._currentIndex === index) {
          this.playerService._currentIndex -= 1;
          this.forward();
      }
  }

  public onYTPlayerError(data) {
    console.log('error', data);
  }

  public styleLoading() {
    if (this.ready == false) {
      return {};
    }

    let width = this.YTPlayer.getVideoLoadedFraction() * 100;
    return {width: `${width}%`};
  }

  public stylePlayed() {
      if (this.ready == false) {
          return {};
      }

      let width = (this.YTPlayer.getCurrentTime() / this.YTPlayer.getDuration()) * 100;
      return {width: `${width}%`};
  }

  public getCurrentTime() {
      if (this.ready == false) {
          return '';
      }

      let time = this.YTPlayer.getCurrentTime();
      let seconds = Math.floor(time % 60);
      let secondsString = '';
      if (seconds < 10) {
          secondsString = '0' + seconds.toString();
      } else {
          secondsString = seconds.toString();
      }
      let minutes = Math.floor(time % 3600 / 60);

      return `${minutes}:${secondsString}`;
  }

  public getTotalDuration() {
      if (this.ready == false) {
          return '';
      }

      let time = this.YTPlayer.getDuration();
      let seconds = Math.floor(time % 60);
      let secondsString = '';
      if (seconds < 10) {
          secondsString = '0' + seconds.toString();
      } else {
          secondsString = seconds.toString();
      }
      let minutes = Math.floor(time % 3600 / 60);

      return `${minutes}:${secondsString}`;
  }

  public goToTime($event) {
    let eLeft = $event.pageX;
    let windowWidth = window.innerWidth;
      this.YTPlayer.seekTo(Math.round(this.YTPlayer.getDuration() * (eLeft / windowWidth)));
  }

  public toggleSuggest() {
      if (this.suggestsLoading) {
          return;
      }
      this.showSuggests = !this.showSuggests;
      this.suggests = {'items': []};
      if (this.showSuggests) {
          this.suggestsLoading = true;
          let item = this.playerService._videos[this.playerService._currentIndex];
          let id = (typeof item.id === 'object') ? item.id.videoId : item.id;
          this.playerService.getSuggests(id).subscribe((data:{'items': Object[]}) => {
              this.suggestsLoading = false;
              this.suggests = data;
          });
      }
  }

  public addSuggestToPlaylist(item) {
      this.playerService.push(item);
      this.showSuggests = false;
  }

  public toggleAuto() {
      this.modeAuto = !this.modeAuto;
  }

  public toggleSavePlaylist() {
      this.savePlaylist = !this.savePlaylist;
  }

  public pause() {
      this.YTPlayer.pauseVideo();
  }

  public play(save = false) {
      this.YTPlayer.playVideo();

      if (save) {
          let videoId = this.playerService._videos[this.playerService._currentIndex].id;
          console.log('videoId', videoId);
          let id = (typeof videoId === 'object') ? videoId.videoId : videoId;

          this.playerService.savePlayed(id).subscribe(() => {
              // saved
          })
      }
  }

  public changeTrack(index) {
      this.playerService._currentIndex = index;
      this.YTPlayer.cueVideoById(this.playerService._videos[this.playerService._currentIndex].id);
      this.play(true);
  }

  public forward() {
      if (this.playerService._videos.length > this.playerService._currentIndex + 1) {
          let item = this.playerService._videos[this.playerService._currentIndex + 1];
          let id = (typeof item.id === 'object') ? item.id.videoId : item.id;
          this.YTPlayer.cueVideoById(id);
          this.playerService._currentIndex = this.playerService._currentIndex + 1;
          this.play(true);

          return;
      }

      if (this.modeAuto && this.autoLoading == false) {
          this.autoLoading = true;
          let item = this.playerService._videos[this.playerService._currentIndex];
          let id = (typeof item.id === 'object') ? item.id.videoId : item.id;
          this.playerService.getNextAuto(id).subscribe((item:{'id': null}) => {
              this.autoLoading = false;
              if (item && item.id != null) {
                  this.playerService._videos.push(item);
                  this.forward();
              }
          });
      } else {
          this.state = -1;
          this.YTPlayer.cueVideoById('');
      }
  }

  public save(form) {
      if (form.value.name == '') {
          return;
      }

      this.playerService.savePlaylist(form.value.name).subscribe((data) => {
          this.savePlaylist = false;
          this.playlistCreated = true;

          setTimeout(() => {
              this.playlistCreated = false;
          }, 5000)
      })
  }

  public backward() {
      if (this.playerService._currentIndex - 1 >= 0) {
          let item = this.playerService._videos[this.playerService._currentIndex - 1];
          let id = (typeof item.id === 'object') ? item.id.videoId : item.id;
          this.YTPlayer.cueVideoById(id);
          this.playerService._currentIndex = this.playerService._currentIndex - 1;
          this.play(true);

          return;
      }
  }

}
