import { Component, AfterViewInit } from '@angular/core';
import { DatabaseService } from 'src/app/shared';
import { DatePipe } from '@angular/common';
import { routerTransition } from '../../router.animations';
import * as moment from 'moment';

@Component({
  selector: 'app-feriados',
  templateUrl: './feriados.component.html',
  styleUrls: ['./feriados.component.scss'],
  animations: [routerTransition()]
})
export class FeriadosComponent implements AfterViewInit {

  public feriados = [];
  private showTurnos = false;
  public fecha: any;
  public dni: any;

  constructor(private databaseService: DatabaseService, private datePipe: DatePipe) {
    const dfecha = new Date();
    this.fecha = { year: dfecha.getFullYear(), month: dfecha.getMonth() + 1, day: dfecha.getDate() };
    moment.locale('es');
  }

  ngAfterViewInit() {
    const dfecha = new Date();
    const ffecha = this.datePipe.transform(dfecha, 'dd/MM/yyyy');
    // this.fecha = {year: dfecha.getFullYear(), month: dfecha.getMonth() + 1, day: dfecha.getDate()};

    this.databaseService.getFeriados(dfecha.getFullYear()).subscribe(
      data => {
        this.feriados = data.feriados;
      },
      error => console.log(error),
      () => {
        this.showTurnos = true;
      }
    );
  }

  getDiaSemana(fecha) {
    return moment(fecha).format('dddd');
  }
  filtrar() {
    if (this.fecha !== null) {
      this.databaseService.getFeriados(this.fecha.year).subscribe(
        data => {
          this.feriados = data.feriados;
        },
        error => console.log(error),
        () => {
          this.showTurnos = true;
        }
      );
    } else {
      this.databaseService.getFeriados(undefined).subscribe(
        data => {
          this.feriados = data.feriados;
        },
        error => console.log(error),
        () => {
          this.showTurnos = true;
        }
      );
    }

  }
}
