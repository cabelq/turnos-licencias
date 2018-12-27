import { Injectable } from '@angular/core';
import { CanActivate } from '@angular/router';
import { Router } from '@angular/router';
import { AutenticacionService } from '../services';

@Injectable()
export class AuthGuard implements CanActivate {
    constructor(private router: Router,
        private autenticacionService: AutenticacionService) {}

    canActivate() {
        if (this.autenticacionService.isLoggedIn()) {
            return true;
        }

        this.router.navigate(['/login']);
        return false;
    }
}
