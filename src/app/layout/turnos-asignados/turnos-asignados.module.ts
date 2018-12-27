import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { TurnosAsignadosRoutingModule } from './turnos-asignados-routing.module';
import { TurnosAsignadosComponent } from './turnos-asignados.component';
import { PageHeaderModule } from './../../shared';
import { StatModule } from '../../shared';

@NgModule({
    imports: [CommonModule,
        TurnosAsignadosRoutingModule,
        NgbModule,
        FormsModule,
        ReactiveFormsModule,
        PageHeaderModule,
        StatModule],
    declarations: [TurnosAsignadosComponent]
})
export class TurnosAsignadosModule {}
