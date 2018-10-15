import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { parameters } from '../parameters';

@Injectable()
export class SigninService {

    public user;
    public userConnected = false;

    constructor(
        public http: HttpClient
    ) { }

    public connectUser(user) {
        let body = JSON.stringify(user);
        return this.http.post(`${parameters.apiUrl}/login_check`, body);
    }

    public loadUser() {
        this.http.get(`${parameters.apiUrl}/user`).subscribe((data) => {
            this.user = data;
            this.userConnected = true;
        })
    }

    public disconnectUser() {
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('user');
        this.userConnected = false;
    }
}
