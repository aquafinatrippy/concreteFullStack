import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
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
      max: nr,
    };
    console.log(objData);
    return this.http.post<any>(this.url, objData);
  }

  results(id) {
    return this.http.get<any>(this.resUrl + id);
  }
}
