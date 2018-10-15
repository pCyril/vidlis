import {
  Component,
  OnInit
} from '@angular/core';

import { PlayerService } from './../player/player.service';
import { SearchService } from './search.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'search',
  templateUrl: './search.component.html'
})

export class SearchComponent implements OnInit {

  public searchResult = {items: []};
  public searchValue;

  constructor(
      public playerService: PlayerService,
      public router: Router,
      public route: ActivatedRoute,
      public searchService: SearchService
  ) {}

  public addToPlayslist(item) {
      this.playerService.push(item);
  }

  ngOnInit() {
      this.route.params
      .subscribe((data) => {
        this.searchResult = {items: []};
        this.searchValue = data.q;
        this.searchService.getData(this.searchValue).subscribe((result:{items:Object[]}) => {
          this.searchResult = result;
        })
      });
    }
}
