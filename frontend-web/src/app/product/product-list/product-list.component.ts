import { Component, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { MatSnackBar, MatSnackBarRef, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { ConfirmDialogComponent } from 'src/app/common/confirm-dialog/confirm-dialog.component';
import { Product } from 'src/app/common/model/Product';
import { ProductService } from '../product.service';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.css']
})
export class ProductListComponent implements OnInit {

  private _verticalPosition: MatSnackBarVerticalPosition = 'top';

  public products: Product[] = [];

  public page: number = 1;
  public totalPages: number = 1;

  constructor(
    private _snackBar: MatSnackBar,
    private dialog: MatDialog,
    private productService: ProductService
  ) { }

  ngOnInit(): void {
    this.paginate(1);
  }

  paginate(page: number): void {
    this.page = page;
    this.productService.paginate(this.page).subscribe(
      paginator => {
        this.totalPages = paginator.totalPages;
        this.products = paginator.items;
      }
    );
  }

  delete(id: number): void {

    const product: Product = this.products.find( c => c.id == id) as Product;

    const dialogRef = this.dialog.open(ConfirmDialogComponent, {
      width: '350px',
      data: {
        confirmMessage: `Tem certeza que deseja excluir o Produto ${product.name} (#${product.id})?`,
        confirmLabel: 'Excluir'
      }
    });

    dialogRef.afterClosed().subscribe( result => {
      
      if (!result)
        return;

      this.productService.delete(product).subscribe(
        () => {
          let snackBarRef: MatSnackBarRef<any> = this._snackBar.open('Cliente excluído com sucesso!', 'OK', {
            verticalPosition: this._verticalPosition,
            panelClass: ['success-snackbar']
          });

          this.products.splice( this.products.indexOf(product as Product), 1 );
        }
      );
    });

  }

}
