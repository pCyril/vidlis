import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { parameters } from '../parameters';

@Injectable()
export class SearchService {

  constructor(
    public http: HttpClient
  ) { }

  public getData(query) {
    let params = new HttpParams().set('query', query);

    return this.http.get(`${parameters.apiUrl}/search`, { params });
  }

}
