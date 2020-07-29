import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../services/api.service';
import { Truck } from '../../models/truck';

@Component({
  selector: 'app-add-truck',
  templateUrl: './add-truck.component.html',
  styleUrls: ['./add-truck.component.sass'],
})
export class AddTruckComponent implements OnInit {
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

  Onenter(val1) {
    this.serv.addTruck(parseInt(val1)).subscribe((data) => {
      console.log(data);
      this.getTrucks();
    });
    this.show = true;
  }
}
