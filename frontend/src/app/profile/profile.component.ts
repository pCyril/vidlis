import {
  Component,
  OnInit
} from '@angular/core';

import { PlayerService } from './../player/player.service';
import { ProfileService } from './profile.service';
import { Router } from '@angular/router';
import { SigninService } from "./../signin/signin.service";

@Component({
  selector: 'profile',
  templateUrl: './profile.component.html'
})

export class ProfileComponent implements OnInit {

  public playlists;
  public played;

  constructor(
      public playerService: PlayerService,
      public profileService: ProfileService,
      public signinService: SigninService,
      public router: Router,
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

  public logout() {
      this.signinService.disconnectUser();
      this.router.navigate(['/']);
  }

  public ngOnInit() {
      if (this.signinService.userConnected == false) {
          this.router.navigate(['/']);
      } else {
          this.profileService.getPlaylists().subscribe((data) => {
              this.playlists = data;
          });

          this.profileService.getPlayed().subscribe((data) => {
              this.played = data;
          });
      }
  }
}
