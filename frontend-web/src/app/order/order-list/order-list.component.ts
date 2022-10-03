import { Component, OnInit } from '@angular/core';
import { Order } from 'src/app/common/model/Order';
import { OrderService } from '../order.service';

@Component({
  selector: 'app-order-list',
  templateUrl: './order-list.component.html',
  styleUrls: ['./order-list.component.css']
})
export class OrderListComponent implements OnInit {

  public orders: Order[] = [];

  public page: number = 1;
  public totalPages: number = 1;

  constructor(
    private orderService: OrderService
  ) { }

  ngOnInit(): void {
    this.paginate(1);
  }

  paginate(page: number): void {
    this.page = page;
    this.orderService.paginate(this.page).subscribe(
      paginator => {
        this.totalPages = paginator.totalPages;
        this.orders = paginator.items;
      }
    );
  }

}
