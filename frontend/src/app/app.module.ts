import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { RouterModule, PreloadAllModules } from '@angular/router';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { PerfectScrollbarModule } from 'ngx-perfect-scrollbar';
import { PERFECT_SCROLLBAR_CONFIG } from 'ngx-perfect-scrollbar';
import { PerfectScrollbarConfigInterface } from 'ngx-perfect-scrollbar';

const DEFAULT_PERFECT_SCROLLBAR_CONFIG: PerfectScrollbarConfigInterface = {
    suppressScrollX: false,
    suppressScrollY: true
};

/*
 * Platform and Environment providers/directives/pipes
 */
import { ROUTES } from './app.routes';
// App is our top level component
import { AppComponent } from './app.component';
import { APP_RESOLVER_PROVIDERS } from './app.resolver';
import { HomeComponent } from './home';
import { HomeService } from './home/home.service';
import { PlayerComponent } from "./player";
import { PlayerService } from './player/player.service';
import { PlaylistComponent } from './playlist';
import { PlaylistService } from './playlist/playlist.service';
import { SearchComponent } from './search';
import { SigninComponent } from './signin';
import { SigninService } from './signin/signin.service';
import { SignupComponent } from './signup';
import { SignupService } from './signup/signup.service';
import { ProfileComponent } from './profile';
import { ProfileService } from './profile/profile.service';
import { ArtistComponent } from './artist';
import { ArtistDetailComponent } from './artist-detail';
import { ArtistService } from './artist/artist.service';
import { SearchService } from './search/search.service';
import { NoContentComponent } from './no-content';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { TokenInterceptor } from './auth/token.interceptor';
import { SocketService } from './socket/socket.service';

import '../styles/styles.scss';
import '../styles/headings.css';

// Application wide providers
const APP_PROVIDERS = [
  ...APP_RESOLVER_PROVIDERS,
    PlayerService,
    PlaylistService,
    SearchService,
    SigninService,
    SignupService,
    HomeService,
    ArtistService,
    ProfileService,
    SocketService,
];

type StoreType = {
  restoreInputValues: () => void,
  disposeOldHosts: () => void
};

/**
 * `AppModule` is the main entry point into Angular2's bootstraping process
 */
@NgModule({
  bootstrap: [ AppComponent ],
  declarations: [
    AppComponent,
    HomeComponent,
    PlayerComponent,
    PlaylistComponent,
    SigninComponent,
    SignupComponent,
    SearchComponent,
    ProfileComponent,
    ArtistComponent,
    ArtistDetailComponent,
    NoContentComponent,
  ],
  /**
   * Import Angular's modules.
   */
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    FormsModule,
    HttpClientModule,
    PerfectScrollbarModule,
    RouterModule.forRoot(ROUTES, {
      useHash: Boolean(history.pushState) === false,
      preloadingStrategy: PreloadAllModules
    })
  ],
  /**
   * Expose our Services and Providers into Angular's dependency injection.
   */
  providers: [
    APP_PROVIDERS,
    {
        provide: HTTP_INTERCEPTORS,
        useClass: TokenInterceptor,
        multi: true
    },
    {
        provide: PERFECT_SCROLLBAR_CONFIG,
        useValue: DEFAULT_PERFECT_SCROLLBAR_CONFIG
    }
  ]
})
export class AppModule {}
