import { Component, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar, MatSnackBarRef, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { ConfirmDialogComponent } from 'src/app/common/confirm-dialog/confirm-dialog.component';
import { Customer } from 'src/app/common/model/Customer';
import { CustomerService } from '../customer.service';

@Component({
  selector: 'app-customer-list',
  templateUrl: './customer-list.component.html',
  styleUrls: ['./customer-list.component.css']
})
export class CustomerListComponent implements OnInit {

  private _verticalPosition: MatSnackBarVerticalPosition = 'top';

  public customers: Customer[];

  public page: number;
  public totalPages: number;

  constructor(
      private _snackBar: MatSnackBar,
      private dialog: MatDialog,
      private customerService: CustomerService
  ){
    this.customers = [];
    this.page = 1;
    this.totalPages = 1;
  }

  ngOnInit(): void {
    this.paginate(this.page);
  }

  paginate(page: number): void {
    this.page = page;
    this.customerService.paginate(this.page).subscribe(
      paginator => {
        this.totalPages = paginator.totalPages;
        this.customers = paginator.items;
      }
    );
  }

  delete(id: number): void {

    const customer: Customer = this.customers.find( c => c.id == id) as Customer;

    const dialogRef = this.dialog.open(ConfirmDialogComponent, {
      width: '350px',
      data: {
        confirmMessage: `Tem certeza que deseja excluir o Cliente ${customer.name} (#${customer.id})?`,
        confirmLabel: 'Excluir'
      }
    });

    dialogRef.afterClosed().subscribe( result => {
      
      if (!result)
        return;

      this.customerService.delete(customer).subscribe(
        () => {
          let snackBarRef: MatSnackBarRef<any> = this._snackBar.open('Cliente excluído com sucesso!', 'OK', {
            verticalPosition: this._verticalPosition,
            panelClass: ['success-snackbar']
          });

          this.customers.splice( this.customers.indexOf(customer as Customer), 1 );
        }
      );
    });

  }

}
