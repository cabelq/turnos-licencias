import { Injectable } from '@angular/core';
import { HttpInterceptor, HttpRequest, HttpHandler, HttpEvent, HttpResponse, HttpErrorResponse } from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';

import { AutenticacionService } from '../services';


@Injectable()
export class AuthInterceptor implements HttpInterceptor {
    constructor(private autenticacionService: AutenticacionService) { }


    intercept(req: HttpRequest<any>,
              next: HttpHandler): Observable<HttpEvent<any>> {
        const idToken =  localStorage.getItem('token');

        if (idToken) {
            const cloned = req.clone({
                headers: req.headers.append('Authorization',
                     idToken)
            });

            return next.handle(cloned).pipe(catchError(err => {
                if (err.status === 401) {
                    // auto logout if 401 response returned from api
                    this.autenticacionService.logout();
                    location.reload(true);
                }

                const error = err.error.message || err.statusText;
                return throwError(error);
            }));
        } else {
            return next.handle(req).pipe(catchError(err => {

                if (err.status === 401 && !req.url.includes('login')) {
                    // auto logout if 401 response returned from api
                    this.autenticacionService.logout();
                    location.reload(true);
                }

                const error = err.error.message || err.statusText;
                return throwError(error);
            }));
        }
    }
}
