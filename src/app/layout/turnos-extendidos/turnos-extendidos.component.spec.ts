import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TurnosExtendidosComponent } from './turnos-extendidos.component';

describe('TurnosExtendidosComponent', () => {
  let component: TurnosExtendidosComponent;
  let fixture: ComponentFixture<TurnosExtendidosComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TurnosExtendidosComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TurnosExtendidosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
