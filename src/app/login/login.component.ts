import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';

import { TranslateService } from '@ngx-translate/core';
import { routerTransition } from '../router.animations';
import { DatabaseService, AutenticacionService } from '../shared/services';
import { ToasterService } from 'angular2-toaster';

import { Login} from '../shared/models/login';

@Component({
    selector: 'app-login',
    templateUrl: './login.component.html',
    styleUrls: ['./login.component.scss'],
    animations: [routerTransition()]
})
export class LoginComponent implements OnInit {

    private usuario;
    private password;
    private oUsuario;
    public formLogin: FormGroup;

    constructor(
        private translate: TranslateService,
        private autenticacionService: AutenticacionService,
        private toasterService: ToasterService,
        public router: Router
    ) {
        this.translate.addLangs(['en', 'fr', 'ur', 'es', 'it', 'fa', 'de', 'zh-CHS']);
        this.translate.setDefaultLang('en');
        const browserLang = this.translate.getBrowserLang();
        this.translate.use(browserLang.match(/en|fr|ur|es|it|fa|de|zh-CHS/) ? browserLang : 'en');
    }

    ngOnInit() {

        this.formLogin = new FormGroup({
            usuario: new FormControl('', [
                Validators.required
            ]),
            password: new FormControl('', [
                Validators.required
            ])
        });
    }

    onLoggedin() {
        localStorage.setItem('isLoggedin', 'false');
        if (this.formLogin.invalid) {
            this.getFormValidationErrors();
            this.toasterService.pop('success', 'Info!', 'Revise el formulario');
        } else {
            this.autenticacionService.login(new Login(this.formLogin.value));
        }
    }

    getFormValidationErrors() {
        let nombreControl = '';
        Object.keys(this.formLogin.controls).forEach(key => {
          switch (key) {
            case 'usuario': {
              nombreControl = 'Usuario';
              break;
            }
            case 'password': {
              nombreControl = 'Contraseña';
              break;
            }
          }
          const controlErrors = this.formLogin.get(key).errors;
          if (controlErrors != null) {
            Object.keys(controlErrors).forEach(keyError => {
              switch (keyError) {
                case 'required': {
                  this.toasterService.pop('success', 'Info!', nombreControl + ' es requerido ');
                  break;
                }
                /*case 'email': {
                  this.toasterService.pop('error', 'Error!', 'El Email no tiene un formato válido ');
                  break;
                }*/

              }

              // console.log('Key control: ' + key + ', keyError: ' + keyError + ', err value: ', controlErrors[keyError]);
            });
          }
        });
      }
}
