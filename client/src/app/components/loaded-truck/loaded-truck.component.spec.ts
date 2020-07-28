import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LoadedTruckComponent } from './loaded-truck.component';

describe('LoadedTruckComponent', () => {
  let component: LoadedTruckComponent;
  let fixture: ComponentFixture<LoadedTruckComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LoadedTruckComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LoadedTruckComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
