import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { FeriadosRoutingModule } from './feriados-routing.module';
import { FeriadosComponent } from './feriados.component';
import { PageHeaderModule } from './../../shared';
import { StatModule } from '../../shared';

@NgModule({
    imports: [CommonModule,
        FeriadosRoutingModule,
        NgbModule,
        FormsModule,
        ReactiveFormsModule,
        PageHeaderModule,
        StatModule],
    declarations: [FeriadosComponent]
})
export class FeriadosModule {}
