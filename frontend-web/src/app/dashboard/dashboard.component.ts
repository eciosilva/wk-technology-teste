import { Component, OnInit, ViewChild } from '@angular/core';
import { ApexAxisChartSeries, ApexChart, ChartComponent, ApexDataLabels, ApexXAxis, ApexPlotOptions } from "ng-apexcharts";
import { Customer } from '../common/model/Customer';
import { Order } from '../common/model/Order';
import { CustomerService } from '../customer/customer.service';
import { OrderService } from '../order/order.service';

export type ChartOptions = {
  series: ApexAxisChartSeries;
  chart: ApexChart;
  dataLabels: ApexDataLabels;
  plotOptions: ApexPlotOptions;
  xaxis: ApexXAxis;
};

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
  @ViewChild("chart") chart?: ChartComponent;

  public orders: Order[];
  public customers: Customer[];

  constructor(
    private customerService: CustomerService,
    private orderService: OrderService
  ) {
    this.orders = [];
    this.customers = [];
  }

  ngOnInit(): void {

    this.loadLastOrders(8);
    this.loadLastRegisteredCustomers(5);
  }

  private loadLastOrders(limit: number): void {
    this.orderService.fetchLastRegistered(limit).subscribe(
      orders => this.orders = orders
    );
  }

  private loadLastRegisteredCustomers(limit: number): void {
    this.customerService.fetchLastRegistered(limit).subscribe(
      customers => { this.customers = customers; }
    );
  }

}
