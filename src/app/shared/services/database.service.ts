import { Injectable } from '@angular/core';
import { DatePipe } from '@angular/common';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../../../environments/environment';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { Login } from '../models';

@Injectable({
  providedIn: 'root'
})
export class DatabaseService {
  private apiServer = environment.apiServer;
  constructor(private http: HttpClient, private datePipe: DatePipe) {
    this.apiServer = environment.apiServer;
  }

  // Obtengo los turnos exendidos
  getTurnosExtendidos(): Observable<any> {
    // this.sessionActual = Util.obtenerSessionActual();
    const headers = new HttpHeaders();
    // headers = headers.append('Authorization', '1');
    const idToken = localStorage.getItem('token');
    // headers = headers.append('Authorization',
    //                 '1' + idToken);
    // headers = headers.append('sis_codigo', Util.obtenerSistemaActivo().Codigo.toString());
    const opts = {
      headers: headers
    };

    const url = this.apiServer + 'turnosextendidos';
    return this.http.get(url, opts).pipe(
      map(
        res => res // .json()
      )
    );
  }

  // Obtengo los turnos exendidos
  getTurnosAsignados(fecha, dni): Observable<any> {
    // this.sessionActual = Util.obtenerSessionActual();
    const headers = new HttpHeaders();
    const idToken = localStorage.getItem('token');
    /* = headers.append('Authorization',
                     'Bearer ' + idToken);*/

    // headers = headers.append('Token', this.sessionActual.token);

    // headers = headers.append('fecha', fecha);
    const opts = {
      headers: headers
    };
    let url;
    if (dni !== undefined && dni !== '') {
      if (fecha !== undefined && fecha !== '') {
        url = this.apiServer + 'turnosasignados/' + fecha + '/' + dni;
      } else {
        url = this.apiServer + 'turnosasignados/' + dni;
      }
    } else {
      url = this.apiServer + 'turnosasignados/' + fecha;
    }

    return this.http.get(url, opts).pipe(
      map(
        res => res // .json()
      )
    );
  }


  // Obtengo los feriados
  getFeriados(anio): Observable<any> {
    // this.sessionActual = Util.obtenerSessionActual();
    const headers = new HttpHeaders();
    const opts = {
      headers: headers
    };
    let url;
    let lanio = anio;
    if (anio !== undefined ) {
      const dt = new Date();
      lanio = dt.getFullYear();
    }

    url = this.apiServer + 'feriados/' + lanio;

    return this.http.get(url, opts).pipe(
      map(
        res => res // .json()
      )
    );
  }

  // Obtengo los turnos exendidos
  login(login: Login): Observable<any> {
    // this.sessionActual = Util.obtenerSessionActual();
    let headers = new HttpHeaders();
    headers = headers.append('Content-Type', 'application/x-www-form-urlencoded');
    // headers = headers.append('Content-Type', 'application/json');
    // const httpOptions = { headers: new HttpHeaders({ 'Content-Type': 'application/json' })};
    const opts = {
      headers: headers
    };

    const url = this.apiServer + 'login';
    return this.http.post(url, login, opts).pipe(map(res => res)); // .json()
  }
}
