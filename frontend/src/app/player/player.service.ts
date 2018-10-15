import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { HttpClient, HttpParams } from '@angular/common/http';
import { parameters } from '../parameters';

@Injectable()
export class PlayerService {

    public _videos = [];
    public _currentIndex = -1;
    public subject: BehaviorSubject<any> = new BehaviorSubject<any>({});

    constructor(
        public http: HttpClient
    ) { }

    public push(video) {
        this._videos.push(video);
        this.subject.next(this._videos);
    }

    public next() {
        return {};
    }

    public prev() {
        return {};
    }

    public clear() {
        this._videos = [];
        this._currentIndex = -1;
    }

    public getVideo(youtubeId) {
        return this.http.get(`${parameters.apiUrl}/video/${youtubeId}`);
    }

    public getSuggests(youtubeId) {
        return this.http.get(`${parameters.apiUrl}/video/suggests/${youtubeId}`);
    }

    public getNextAuto(youtubeId) {
        let params = new HttpParams();

        this._videos.forEach((video) => {
            params = params.append('ids[]', video.id);
        });

        return this.http.get(`${parameters.apiUrl}/video/next/auto/${youtubeId}`, { params });
    }

    public savePlayed(youtubeId) {
        let body = JSON.stringify({});
        return this.http.post(`${parameters.apiUrl}/played/${youtubeId}`, body);
    }

    public savePlaylist(name) {
        let ids = [];

        this._videos.forEach((video) => {
            let id = (typeof video.id === 'object') ? video.id.videoId : video.id;
            ids.push(id);
        });

        let body = JSON.stringify({name, ids});
        return this.http.post(`${parameters.apiUrl}/api/playlists`, body);
    }
}
