import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { parameters } from '../parameters';

@Injectable()
export class ArtistService {

  constructor(
    public http: HttpClient
  ) { }

  public getAllArtists(offset =  '0', gender = null) {
      let params = new HttpParams().set('offset', offset).set('gender', gender);

      return this.http.get(`${parameters.apiUrl}/artists`, { params });
  }

  public findArtists(offset =  '0', query = null) {
      let params = new HttpParams().set('offset', offset).set('query', query);

      return this.http.get(`${parameters.apiUrl}/artists/search`, { params });
  }

  public getArtistDetail(id) {
      return this.http.get(`${parameters.apiUrl}/artists/${id}`);
  }
}
