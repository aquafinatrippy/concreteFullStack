import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Truck } from '../models/truck';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private url = `${environment.apiUrl}/addTruck`;
  private productsUrl = `${environment.apiUrl}/trucks`;
  private resUrl = `${environment.apiUrl}/newest`;
  constructor(private http: HttpClient) {}

  getProducts(): Observable<Truck[]> {
    const headers = { 'content-type': 'application/json' };
    return this.http.get<Truck[]>(this.productsUrl, { headers: headers });
  }

  addTruck(nr) {
    let objData = {
      max: nr
    };
    console.log(objData);
    return this.http.post<{}>(this.url, objData);
  }

  results(): Observable<Truck[]> {
    return this.http.get<Truck[]>(this.resUrl);
  }
}
