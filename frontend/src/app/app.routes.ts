import { Routes } from '@angular/router';
import { HomeComponent } from './home';
import { ProfileComponent } from './profile';
import { ArtistComponent } from './artist';
import { ArtistDetailComponent } from './artist-detail';
import { PlaylistComponent } from './playlist';
import { SearchComponent } from './search';
import { SigninComponent } from './signin';
import { SignupComponent } from './signup';
import { NoContentComponent } from './no-content';

export const ROUTES: Routes = [
  { path: '',      component: HomeComponent },
  { path: 'home',  component: HomeComponent },
  { path: 'playlists',  component: PlaylistComponent },
  { path: 'profile',  component: ProfileComponent },
  { path: 'artists',  component: ArtistComponent },
  { path: 'artists/g/:genre',  component: ArtistComponent },
  { path: 'artists/q/:query',  component: ArtistComponent },
  { path: 'search/:q', component: SearchComponent },
    {
        path: 'signin',
        component: SigninComponent,
        outlet: 'popup'
    },
    {
        path: 'signup',
        component: SignupComponent,
        outlet: 'popup'
    },
    {
        path: 'artist-detail/:id',
        component: ArtistDetailComponent,
        outlet: 'popup'
    },
  { path: '**',    component: NoContentComponent },

];
