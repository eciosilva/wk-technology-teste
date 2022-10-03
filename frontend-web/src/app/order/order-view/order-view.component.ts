import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Order } from 'src/app/common/model/Order';
import { OrderProduct } from 'src/app/common/model/OrderProduct';
import { Product } from 'src/app/common/model/Product';
import { OrderService } from '../order.service';

@Component({
  selector: 'app-order-view',
  templateUrl: './order-view.component.html',
  styleUrls: ['./order-view.component.css']
})
export class OrderViewComponent implements OnInit {

  public order?: Order;
  public products?: OrderProduct[];

  constructor(
    private route: ActivatedRoute,
    private orderService: OrderService
  ) { }

  ngOnInit(): void {
    const id = parseInt(String(this.route.snapshot.paramMap.get('id')));
    
    this.orderService.fetch(id).subscribe(obj => {
      this.order = obj;
    });

    this.orderService.products(id).subscribe(data => {
      this.products = data;
    })
  }

}
