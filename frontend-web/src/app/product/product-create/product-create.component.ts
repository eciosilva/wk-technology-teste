import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarRef, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { Router } from '@angular/router';
import { ErrorDialogService } from 'src/app/common/error-dialog/error-dialog.service';
import { City } from 'src/app/common/model/City';
import { Product } from 'src/app/common/model/Product';
import { State } from 'src/app/common/model/State';
import { ProductService } from '../product.service';

@Component({
  selector: 'app-product-create',
  templateUrl: './product-create.component.html',
  styleUrls: ['./product-create.component.css']
})
export class ProductCreateComponent implements OnInit {

  private _verticalPosition: MatSnackBarVerticalPosition = 'bottom';

  public formSubmited: boolean = false;

  public productForm: FormGroup = this.fb.group({
    name: ['', [Validators.required, Validators.minLength(3)]],
    price: ['', Validators.required],
  });

  constructor(
    private _snackBar: MatSnackBar,
    private router: Router,
    private fb: FormBuilder,
    private productService: ProductService,
    private errorDialogService: ErrorDialogService
  ) { }

  ngOnInit(): void {
    
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

        let snackBarRef: MatSnackBarRef<any> = this._snackBar.open('Produto cadastrado com sucesso!', 'OK', {
          verticalPosition: this._verticalPosition,
          panelClass: ['success-snackbar']
        });
      }
    );
  }

}
