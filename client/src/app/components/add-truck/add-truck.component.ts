import { Component, OnInit } from '@angular/core';
import { ApiService } from '../../services/api.service';

@Component({
  selector: 'app-add-truck',
  templateUrl: './add-truck.component.html',
  styleUrls: ['./add-truck.component.sass'],
})
export class AddTruckComponent implements OnInit {
  obj: {};
  products: Array<any>;
  show: boolean;
  tranPrice: Array<any>;
  error: string;

  constructor(private serv: ApiService) {}

  ngOnInit(): void {}

  getTrucks(id) {
    this.serv.results(id).subscribe((data) => {
      this.products = data.data;
      console.log(data);
    });
  }
  back() {
    this.products = [];
    this.tranPrice = [];
    this.show = false;
  }

  Onenter(val1) {
    if (parseInt(val1) < 1000) {
      this.error = 'Enter higher number, starts from 1000';
    } else if (parseInt(val1) > 8000) {
      this.error = 'Enter lower number, maximum is 8000';
    } else {
      this.error = null;
      this.serv.addTruck(parseInt(val1)).subscribe((data) => {
        console.log(data);
        this.getTrucks(data.truckId);
        this.tranPrice = data.transportTotal;
      });
      this.show = true;
    }
  }
}
