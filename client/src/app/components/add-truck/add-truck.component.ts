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
  products: any[];
  show: boolean;
  tranPrice: number;

  constructor(private serv: ApiService) {}

  ngOnInit(): void {}

  getTrucks(id) {
    this.serv.results(id).subscribe((data) => {
      this.products = data.data;
      console.log(data);
    });
  }
  back(){
    this.show = false;
  }

  Onenter(val1) {
    this.serv.addTruck(parseInt(val1)).subscribe((data) => {
      console.log(data);
      this.getTrucks(data.truckId);
      this.tranPrice = data.transportTotal;
    });
    this.show = true;
  }
}
