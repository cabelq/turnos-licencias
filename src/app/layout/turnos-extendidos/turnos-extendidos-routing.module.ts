import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { TurnosExtendidosComponent } from './turnos-extendidos.component';

const routes: Routes = [
    {
        path: '', component: TurnosExtendidosComponent
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class TurnosExtendidosRoutingModule {
}
