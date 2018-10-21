import {
    Component,
    OnInit
} from '@angular/core';

import {PlayerService} from './../player/player.service';
import {ArtistService} from './../artist/artist.service';
import {ActivatedRoute, Router} from '@angular/router';

@Component({
    selector: 'artist-detail',
    templateUrl: './artist-detail.component.html'
})

export class ArtistDetailComponent implements OnInit {

    public loaded = false;

    public artist;

    constructor(public playerService: PlayerService,
                public artistService: ArtistService,
                public router: Router,
                public route: ActivatedRoute,) {
    }

    public hasYoutubeId(track) {
        return (track.youtube_id != undefined)
    }

    public closeDetail() {
        this.router.navigate([{outlets: {popup: null}}]);
    }

    public getTime(track) {
        let seconds = track.duration % 60;
        let secondsString = '';
        if (seconds < 10) {
            secondsString = '0' + seconds.toString();
        } else {
            secondsString = seconds.toString();
        }
        let minutes = Math.floor(track.duration % 3600 / 60);

        return `${minutes}:${secondsString}`;
    }

    public getTags(tags) {
        return tags.split(', ');
    }

    public addToPlaylist(track) {
        this.playerService.getVideo(track.youtube_id).subscribe((data: { id: '' }) => {
            if (data != null && data.id != '') {
                this.playerService.push(data);
            } else {
                // TODO add error service
            }
        });
    }

    public ngOnInit() {
        this.route.params
            .subscribe((data) => {
                this.artistService.getArtistDetail(data.id).subscribe((data) => {
                    this.loaded = true;
                    this.artist = data;
                });
            });
    }
}
