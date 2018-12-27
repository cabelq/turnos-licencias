import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

@Component({
    selector: 'app-stat',
    templateUrl: './stat.component.html',
    styleUrls: ['./stat.component.scss']
})
export class StatComponent implements OnInit {
     @Input() bgClass: string;
    @Input() icon: string;
    @Input() count: number;
    @Input() label: string;
    @Input() data: number;
    @Output() event: EventEmitter<any> = new EventEmitter();

    constructor() {}

    ngOnInit() {
        // console.log(this.bgClass);
    }

    getClass() {
        if (this.count < 30) {
            return "bg-success";
        }
        if (this.count >= 30 && this.count < 60) {
            return "bg-warning";
        }
        if (this.count >= 60 ) {
            return "bg-danger";
        }
    }
}
