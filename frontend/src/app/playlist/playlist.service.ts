import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { parameters } from '../parameters';

@Injectable()
export class PlaylistService {

  constructor(
    public http: HttpClient
  ) { }

  public getData(offset =  '0') {
    let params = new HttpParams().set('offset', offset);

    return this.http.get(`${parameters.apiUrl}/playlists`, { params });
  }

}
