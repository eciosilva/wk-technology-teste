import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarRef, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { ActivatedRoute, Router } from '@angular/router';
import { ErrorDialogService } from 'src/app/common/error-dialog/error-dialog.service';
import { Product } from 'src/app/common/model/Product';
import { ProductService } from '../product.service';

@Component({
  selector: 'app-product-edit',
  templateUrl: './product-edit.component.html',
  styleUrls: ['./product-edit.component.css']
})
export class ProductEditComponent implements OnInit {

  private _verticalPosition: MatSnackBarVerticalPosition = 'bottom';

  public formSubmited: boolean = false;

  public product?: Product;

  public productForm: FormGroup = this.fb.group({
    id: [''],
    name: ['', [Validators.required, Validators.minLength(3)]],
    price: ['', Validators.required],
  });

  constructor(
    private _snackBar: MatSnackBar,
    private router: Router,
    private route: ActivatedRoute,
    private fb: FormBuilder,
    private productService: ProductService,
    private errorDialogService: ErrorDialogService
  ) { }

  ngOnInit(): void {
    const id = parseInt(String(this.route.snapshot.paramMap.get('id')));
    
    this.productService.fetch(id).subscribe(obj => {
      this.product = obj;
      this.productForm.patchValue(this.product);
    })
  }

  public save(): void {
    this.formSubmited = true;
    if (!this.productForm.valid) {
      this.errorDialogService.openDialog({ message: 'Formulário inválido!'});
      return;
    }

    this.productService.save(this.productForm.value as Product).subscribe(
      product => {
        this.productForm.reset();
        this.router.navigate(['/produtos']);

        let snackBarRef: MatSnackBarRef<any> = this._snackBar.open('Produto editado com sucesso!', 'OK', {
          verticalPosition: this._verticalPosition,
          panelClass: ['success-snackbar']
        });
      }
    );
  }

}
