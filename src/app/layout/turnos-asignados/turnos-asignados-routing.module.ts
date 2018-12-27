import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { TurnosAsignadosComponent } from './turnos-asignados.component';

const routes: Routes = [
    {
        path: '', component: TurnosAsignadosComponent
    }
];

@NgModule({
    imports: [RouterModule.forChild(routes)],
    exports: [RouterModule]
})
export class TurnosAsignadosRoutingModule {
}
