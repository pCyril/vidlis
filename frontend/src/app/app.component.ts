
import { Component, OnInit, ViewEncapsulation } from '@angular/core';
import { Router } from '@angular/router';
import { SigninService } from "./signin/signin.service";
import { PlayerService } from './player/player.service';

@Component({
  selector: 'app',
  encapsulation: ViewEncapsulation.None,
  templateUrl: './app.component.html'
})
export class AppComponent implements OnInit {

  public constructor(
      public router: Router,
      public signinService: SigninService,
      public playerService: PlayerService
  ) {}

  public ngOnInit() {
    if (window.localStorage.getItem('user')) {
      let user = JSON.parse(window.localStorage.getItem('user'));
      this.signinService.connectUser(user).subscribe((response:{token:''}) => {
        window.localStorage.setItem('token', response.token);
        this.signinService.loadUser();
      }, () => {
        window.localStorage.removeItem('user');
      })
    }
  }

  public search(form) {
      this.router.navigate(['/search', form.value.query]);
  }

  public searchMobile(form) {
      this.router.navigate(['/search', form.value.query_mobile]);
  }

}
