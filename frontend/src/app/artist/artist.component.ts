import {
  Component,
  OnInit
} from '@angular/core';

import { ArtistService } from './artist.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'artist',
  templateUrl: './artist.component.html'
})

export class ArtistComponent implements OnInit {

  public loaded = false;

  public loadedMore = false;

  public artists = [];

  public offset = 0;

  public query = null;

  public gender = null;

  public genders = [
      'all',
      'alternative',
      'blues',
      'dance',
      'electro',
      'hip hop',
      'jazz',
      'pop',
      'rap',
      'reggae',
      'rock',
  ];

  constructor(
      public artistService: ArtistService,
      public router: Router,
      public route: ActivatedRoute,
  ) {}

  public search(form) {
      this.router.navigate(['artists/q', form.value.query]);
  }

  public showDetail(artist) {
      this.router.navigate([{ outlets: { popup: ['artist-detail', artist.id] }}]);
  }

  public ngOnInit() {
      this.route.params
          .subscribe((data) => {
              this.artists = [];
              this.offset = 0;
              this.loaded = false;
              this.query = data.query? data.query : null;
              this.gender = data.genre? data.genre : null;
              this.loadArtists();
          });
  }

  public loadArtists() {
      this.loadedMore = false;
      this.loaded = false;
      let sub;

      if (this.query) {
          sub = this.artistService.findArtists(this.offset.toString(), this.query);
      } else {
          sub = this.artistService.getAllArtists(this.offset.toString(), this.gender);
      }

      sub.subscribe((data:Object[]) => {
          this.loaded = true;
          if (data.length == 12) {
              this.loadedMore = true;
          }
          this.offset += 12;
          this.artists = this.artists .concat(data);
      });
  }
}
