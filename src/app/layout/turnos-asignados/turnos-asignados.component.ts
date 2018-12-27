import { Component, AfterViewInit} from '@angular/core';
import { DatePipe } from '@angular/common';
import { DatabaseService } from '../../shared/services/database.service';
import { routerTransition } from '../../router.animations';

@Component({
  selector: 'app-turnos-asignados',
  templateUrl: './turnos-asignados.component.html',
  styleUrls: ['./turnos-asignados.component.scss'],
  animations: [routerTransition()]
})
export class TurnosAsignadosComponent implements AfterViewInit {
  public turnos = [];
  private showTurnos = false;
  public fecha: any;
  public dni: any;

  constructor(private databaseService: DatabaseService, private datePipe: DatePipe) {
    const dfecha = new Date();
    this.fecha = { year: dfecha.getFullYear(), month: dfecha.getMonth() + 1, day: dfecha.getDate() };
  }

  ngAfterViewInit() {
    const dfecha = new Date();
    const ffecha = this.datePipe.transform(dfecha, 'dd/MM/yyyy');
    // this.fecha = {year: dfecha.getFullYear(), month: dfecha.getMonth() + 1, day: dfecha.getDate()};

    this.databaseService.getTurnosAsignados(ffecha, undefined).subscribe(
      data => {
        this.turnos = data.turnosasignados;
      },
      error => console.log(error),
      () => {
        this.showTurnos = true;
      }
    );
  }

  filtrar() {
    if (this.fecha !== null) {
      this.databaseService.getTurnosAsignados(this.fecha.day + '/' + this.fecha.month + '/' + this.fecha.year, this.dni).subscribe(
        data => {
          this.turnos = data.turnosasignados;
        },
        error => console.log(error),
        () => {
          this.showTurnos = true;
        }
      );
    } else {
      this.databaseService.getTurnosAsignados(undefined, this.dni).subscribe(
        data => {
          this.turnos = data.turnosasignados;
        },
        error => console.log(error),
        () => {
          this.showTurnos = true;
        }
      );
    }
    
  }
}
