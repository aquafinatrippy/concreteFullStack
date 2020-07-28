import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Truck } from '../models/truck';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  private url = 'http://localhost:8000/addTruck';
  private productsUrl = 'http://localhost:8000/trucks';
  private resUrl = 'http://localhost:8000/newest';
  constructor(private http: HttpClient) {}

  getProducts(): Observable<Truck[]> {
    const headers = { 'content-type': 'application/json' };
    return this.http.get<Truck[]>(this.productsUrl, { headers: headers });
  }

  addTruck(data) {
    let objData = {
      license: data.license,
      max: data.maxload,
    };
    return this.http.post<{}>(this.url, objData);
  }

  results(): Observable<Truck[]> {
    return this.http.get<Truck[]>(this.resUrl);
  }
}
