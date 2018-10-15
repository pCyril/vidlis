import {
  Component,
  OnInit
} from '@angular/core';

import { PlayerService } from './../player/player.service';
import { HomeService } from './home.service';

@Component({
  selector: 'home',
  templateUrl: './home.component.html'
})

export class HomeComponent implements OnInit {

  public loaded = false;
  public lastVideosPlayed;

  constructor(
      public playerService: PlayerService,
      public homeService: HomeService
  ) {}

  public addToPlayslist(item) {
      this.playerService.push(item);
  }

  public ngOnInit() {
      this.homeService.getData().subscribe((data) => {
          this.loaded = true;
          this.lastVideosPlayed = data;
      });
  }
}
