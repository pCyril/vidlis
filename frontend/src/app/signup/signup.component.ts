import { Component } from '@angular/core';
import { Router }                 from '@angular/router';
import {SignupService} from "./signup.service";
import {SigninService} from "../signin/signin.service";

@Component({
    templateUrl: './signup.component.html'
})
export class SignupComponent {
    
    constructor(
        private router: Router,
        private signupService: SignupService,
        private signinService: SigninService,
    ) {}

    submit(form) {
        let user = {
            username: form.value.username,
            email: form.value.email,
            password: form.value.password,
        };

        console.log('user', user);

        this.signupService.registerUser(user).subscribe((data) => {
            this.signinService.connectUser(user).subscribe((response:{token:''}) => {
                window.localStorage.setItem('user', JSON.stringify(user));
                window.localStorage.setItem('token', response.token);
                this.signinService.loadUser();
                this.closePopup();
            });
        }, () => {

        })
    }

    closePopup() {
        this.router.navigate([{ outlets: { popup: null }}]);
    }
}