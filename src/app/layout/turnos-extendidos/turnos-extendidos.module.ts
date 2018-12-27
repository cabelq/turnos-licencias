import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';


import { TurnosExtendidosRoutingModule } from './turnos-extendidos-routing.module';
import { TurnosExtendidosComponent } from './turnos-extendidos.component';
import { PageHeaderModule } from './../../shared';
import { StatModule } from '../../shared';

@NgModule({
    imports: [CommonModule, TurnosExtendidosRoutingModule, PageHeaderModule, StatModule],
    declarations: [TurnosExtendidosComponent]
    
})
export class TurnosExtendidosModule {}
