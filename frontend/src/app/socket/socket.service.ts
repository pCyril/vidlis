import { Injectable } from '@angular/core';
import * as io from "socket.io-client";
import { Observable } from 'rxjs/Observable';
import { parameters } from '../parameters';


@Injectable()
export class SocketService {

  public socket = null;

  public me = null;

  constructor(
  ) { }

  public initSocket(){
      this.socket = io.connect(parameters.socket, {
          path: '/socket',
          timeout: 2000,
      });

      this.on('me').subscribe((data) => {
          console.log('data', data);
          this.me = data;
      });
  }

  public emit(eventName, data = {}){
      if (this.socket == null) {
          return;
      }

      this.socket.emit(eventName, Object.assign(data, this.me));
  }

  public on(eventName) {
      let observable = new Observable(observer => {
          this.socket.on(eventName, (data) => {
              observer.next(data);
          });
      });

      return observable;
  }

  public removeAllListeners(name) {
    if (!this.socket) {
        return;
    }

    this.socket.removeAllListeners(name);
  }
}
