import {
  Component,
  OnInit
} from '@angular/core';

import { PlayerService } from './../player/player.service';
import { PlaylistService } from './playlist.service';

@Component({
  selector: 'playlist',
  templateUrl: './playlist.component.html'
})

export class PlaylistComponent implements OnInit {

  public loaded = false;

  public loadedMore = false;

  public playlists = [];

  public offset = 0;

  constructor(
      public playerService: PlayerService,
      public playlistService: PlaylistService
  ) {}

  public addToPlaylist(item) {
      this.playerService.getVideo(item.id_video).subscribe((data:{id: ''}) => {
          if (data != null && data.id != '') {
              this.playerService.push(data);
          } else {
              // TODO add error service
          }
      });
  }

  public ngOnInit() {
      this.loadPlaylists()
  }

  public loadPlaylists() {
      this.loadedMore = false;
      this.playlistService.getData(this.offset.toString()).subscribe((data:Object[]) => {
          this.loaded = true;
          if (data.length == 12) {
              this.loadedMore = true;
          }
          this.offset += 12;
          this.playlists = this.playlists.concat(data);
      });
  }
}
