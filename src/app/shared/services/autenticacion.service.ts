import { Injectable } from '@angular/core';
import * as moment from 'moment';
import { DatabaseService } from './database.service';
import { Login } from '../models';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';
import { ToasterService } from 'angular2-toaster';

@Injectable({
  providedIn: 'root'
})
export class AutenticacionService {

  constructor(private databaseService: DatabaseService,
    private toasterService: ToasterService,
    private router: Router) {}

  login(login: Login) {

    this.databaseService.login(login).subscribe(
      data => {
        this.setSession(data);
        this.router.navigate(['/dashboard']);
      },
      error => {
        console.log(error);

        this.toasterService.pop('error', 'Info!', 'Usuario o clave incorrecta');
      });
    }

  private setSession(authResult) {
    const expiresAt = moment().add(authResult.expiraEn, 'second');

    localStorage.setItem('token', authResult.token);
    localStorage.setItem('expira_en', JSON.stringify(expiresAt.valueOf()));
    localStorage.setItem('usuario', authResult.usuario);
  }

  logout() {
    localStorage.removeItem('token');
    localStorage.removeItem('expira_en');
    localStorage.removeItem('usuario');
    this.router.navigate(['/login']);
  }
  public isLoggedIn() {
    return moment().isBefore(this.getExpiracion());
  }

  isLoggedOut() {
    return !this.isLoggedIn();
  }

  getExpiracion() {
    const expiration = localStorage.getItem('expira_en');
    const expiresAt = JSON.parse(expiration);
    return moment(expiresAt);
  }
}
