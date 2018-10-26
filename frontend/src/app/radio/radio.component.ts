import {
  Component,
  OnInit,
  OnDestroy
} from '@angular/core';

import { SocketService } from '../socket/socket.service';

@Component({
  selector: 'radio',
  templateUrl: './radio.component.html'
})

export class RadioComponent implements OnInit, OnDestroy {

  public radios = [];

  constructor(
      public socketService: SocketService
  ) {}

  public ngOnInit() {
      this.socketService.emit('currents');
      this.socketService.on('currents').subscribe((data) => {
          this.radios = data;
      })
  }

  public ngOnDestroy() {
      this.socketService.removeAllListeners('currents');
  }
}
