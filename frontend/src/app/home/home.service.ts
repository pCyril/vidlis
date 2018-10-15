import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { parameters } from '../parameters';

@Injectable()
export class HomeService {

  constructor(
    public http: HttpClient
  ) { }

  public getData() {
    return this.http.get(`${parameters.apiUrl}/home`);
  }

}
