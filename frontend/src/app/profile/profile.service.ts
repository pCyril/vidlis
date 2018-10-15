import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { parameters } from '../parameters';

@Injectable()
export class ProfileService {

  constructor(
    public http: HttpClient
  ) { }

  public getPlaylists() {
    return this.http.get(`${parameters.apiUrl}/user/playlists`);
  }

  public getPlayed() {
      return this.http.get(`${parameters.apiUrl}/user/played`);
  }

}
