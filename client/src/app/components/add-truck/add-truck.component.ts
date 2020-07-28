import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../services/api.service';
import { Truck } from '../../models/truck';

@Component({
  selector: 'app-add-truck',
  templateUrl: './add-truck.component.html',
  styleUrls: ['./add-truck.component.sass'],
})
export class AddTruckComponent implements OnInit {
  license: string;
  maxload: number;
  obj: {};
  trucks: Truck[];
  show: boolean;

  constructor(private serv: ApiService) {}

  ngOnInit(): void {
    this.getTrucks();
  }

  getTrucks() {
    this.serv.getProducts().subscribe((data) => {
      this.trucks = data;
    });
  }

  Onenter(val1: string, val2: number) {
    this.license = val1;
    this.maxload = val2;
    this.obj = {
      license: this.license,
      maxload: this.maxload,
    };
    this.serv.addTruck(this.obj).subscribe((data) => {
      this.getTrucks();
    });
    this.show = true;
  }
}
