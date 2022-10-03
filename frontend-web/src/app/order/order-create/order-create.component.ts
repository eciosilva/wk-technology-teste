import { _isNumberValue } from '@angular/cdk/coercion';
import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarRef, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { Router } from '@angular/router';
import { ErrorDialogService } from 'src/app/common/error-dialog/error-dialog.service';
import { Customer } from 'src/app/common/model/Customer';
import { Order } from 'src/app/common/model/Order';
import { Product } from 'src/app/common/model/Product';
import { instanceOfCustomer } from 'src/app/common/validators/instaceOfCustomer';
import { CustomerService } from 'src/app/customer/customer.service';
import { OrderService } from 'src/app/order/order.service';
import { ProductService } from 'src/app/product/product.service';

@Component({
  selector: 'app-order-create',
  templateUrl: './order-create.component.html',
  styleUrls: ['./order-create.component.css']
})
export class OrderCreateComponent implements OnInit {

  private _verticalPosition: MatSnackBarVerticalPosition = 'bottom';

  public formSubmited: boolean = false;

  public customers?: Customer[];
  public products?: Product[];

  public orderForm: FormGroup = this.fb.group({
    customer: ['', [Validators.required, instanceOfCustomer]],
    orderProducts: this.fb.array([])
  });

  constructor(
    private _snackBar: MatSnackBar,
    private router: Router,
    private fb: FormBuilder,
    private orderService: OrderService,
    private errorDialogService: ErrorDialogService,
    private customerService: CustomerService,
    private productService: ProductService
  ) { }

  ngOnInit(): void {
    this.loadCustomers();
    this.loadProducts();
  }

  get orderProducts(): FormArray {
    return this.orderForm.controls['orderProducts'] as FormArray;
  }
  
  public save(): void {
    this.formSubmited = true;

    if (!this.orderForm.valid) {
      this.errorDialogService.openDialog({ message: 'Formulário inválido!'});
      return;
    }

    /**
     * At least one Product should have been added to the Order
     */
    let itemsCount: number = 0;
    (this.orderForm.value.orderProducts as Array<any>).forEach((element, i) => {
      if (null != element.amount && undefined != element.amount && _isNumberValue(element.amount)) {
        itemsCount += parseInt(element.amount);
        /*if (0 == element.amount) { // This piece of code removes the item with 0 from screen...
          (this.orderForm.controls['orderProducts'] as FormArray).removeAt(i);
        }*/
      }
    });

    if (0 == itemsCount) {
      this.errorDialogService.openDialog({ message: 'Ao menos um Produto deve ser adicionado ao Pedido!'});
      return;
    }

    this.orderService.save(this.orderForm.value as Order).subscribe(
      order => {
        //this.orderForm.reset();
        this.router.navigate(['/pedidos']);

        let snackBarRef: MatSnackBarRef<any> = this._snackBar.open('Pedido cadastrado com sucesso!', 'OK', {
          verticalPosition: this._verticalPosition,
          panelClass: ['success-snackbar']
        });
      }
    );
  }

  public displayFn(obj: Customer|Product): string {
    return obj && obj.name ? obj.name : '';
  }

  private loadCustomers(): void {
    this.customerService.fetchAll().subscribe(data => this.customers = data);
  }

  private loadProducts(): void {
    this.productService.fetchAll().subscribe(
      data => {
        for(const product of data) {
          let control: FormGroup = this.fb.group({
            product: [product],
            amount: ['0', Validators.required]
          });
          this.orderProducts.push(control);
        }
      }
    );
  }

}
