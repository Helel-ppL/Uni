import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'iCar Plus';

  constructor(){this.print()}
  print(){
    console.log(new Date().toUTCString())
  }

}
