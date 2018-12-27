import { Component, OnInit } from '@angular/core';
import { ToasterConfig } from 'angular2-toaster';
@Component({
    selector: 'app-root',
    templateUrl: './app.component.html',
    styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
    public config: ToasterConfig =
    new ToasterConfig({positionClass: 'toast-bottom-left'});
    constructor() {
    }

    ngOnInit() {
    }
}
