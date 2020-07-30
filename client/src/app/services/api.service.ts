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
  private resUrl = `${environment.apiUrl}/truck/`;
  constructor(private http: HttpClient) {}


  addTruck(nr) {
    let objData = {
      max: nr
    };
    console.log(objData);
    return this.http.post<{}>(this.url, objData);
  }


  results(id): Observable<Truck[]> {
    return this.http.get<Truck[]>(this.resUrl+id);
  }
}
