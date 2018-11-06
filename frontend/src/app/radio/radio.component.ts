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

  public data;

  constructor(
      public socketService: SocketService
  ) {}

  public ngOnInit() {
      this.socketService.emit('currents');
      this.socketService.on('currents').subscribe((data) => {
          this.data = data;
          this.getRadios();
      })
  }

  public ngOnDestroy() {
      this.socketService.removeAllListeners('currents');
  }

  public getRadios() {
      this.radios = this.data.filter((row) => {
          return row.isRadio;
      });
  }
}
