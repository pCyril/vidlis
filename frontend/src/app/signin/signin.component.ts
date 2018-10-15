import { Component } from '@angular/core';
import { Router }    from '@angular/router';
import { SigninService }    from './signin.service';

@Component({
    templateUrl: './signin.component.html'
})
export class SigninComponent {


    constructor(
        private router: Router,
        public signinService: SigninService
    ) {}

    connectUser(form) {
        this.signinService.connectUser(form.value).subscribe((response:{token:''}) => {
            window.localStorage.setItem('user', JSON.stringify(form.value));
            window.localStorage.setItem('token', response.token);
            this.signinService.loadUser();
            this.closePopup();
        }, (error) => {});
    }

    closePopup() {
        this.router.navigate([{ outlets: { popup: null }}]);
    }
}