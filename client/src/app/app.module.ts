import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HttpClientModule } from '@angular/common/http';
import { AddTruckComponent } from './components/add-truck/add-truck.component';
import { FormsModule } from '@angular/forms';
import { LoadedTruckComponent } from './components/loaded-truck/loaded-truck.component';

@NgModule({
  declarations: [AppComponent, AddTruckComponent, LoadedTruckComponent],
  imports: [BrowserModule, AppRoutingModule, HttpClientModule, FormsModule],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
