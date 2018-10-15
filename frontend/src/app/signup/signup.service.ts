import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { parameters } from '../parameters';

@Injectable()
export class SignupService {

    constructor(
        public http: HttpClient
    ) { }

    public registerUser(user) {
        console.log('user', user);
        let body = JSON.stringify(user);
        return this.http.post(`${parameters.apiUrl}/registration`, body);
    }
}
