import { Component, OnInit, AfterViewInit } from '@angular/core';
import { DatabaseService } from '../../shared/services/database.service';
import { routerTransition } from '../../router.animations';

@Component({
  selector: 'app-turnos-extendidos',
  templateUrl: './turnos-extendidos.component.html',
  styleUrls: ['./turnos-extendidos.component.scss'],
  animations: [routerTransition()]
})
export class TurnosExtendidosComponent implements AfterViewInit {
  private turnos = [];
  private turnosExtendidos = [];
  private showTurnos = false;


  constructor(private databaseService: DatabaseService) { }
  
  ngAfterViewInit() {
    this.databaseService.getTurnosExtendidos().subscribe(
      data => {
        this.turnos = data.turnosextendidos;
      },
      error => console.log(error),
      () => {       
        this.turnosExtendidos  = this.turnos;
        this.showTurnos = true;
      }
    );
  }

}
