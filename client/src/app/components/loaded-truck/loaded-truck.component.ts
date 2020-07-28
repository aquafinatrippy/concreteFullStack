import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../services/api.service';
import { Truck } from '../../models/truck';

@Component({
  selector: 'app-loaded-truck',
  templateUrl: './loaded-truck.component.html',
  styleUrls: ['./loaded-truck.component.sass'],
})
export class LoadedTruckComponent implements OnInit {
  res: any[];

  constructor(private serv: ApiService) {}

  ngOnInit(): void {
    this.getRes();
  }

  getRes() {
    this.serv.results().subscribe((data) => {
      this.res = data;
    });
  }
}
