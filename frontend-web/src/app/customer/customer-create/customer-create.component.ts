import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarRef, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { Router } from '@angular/router';
import { ErrorDialogService } from 'src/app/common/error-dialog/error-dialog.service';
import { City } from 'src/app/common/model/City';
import { Customer } from 'src/app/common/model/Customer';
import { State } from 'src/app/common/model/State';
import { LocalizationService } from 'src/app/common/services/localization.service';
import { CustomerService } from '../customer.service';

@Component({
  selector: 'app-customer-create',
  templateUrl: './customer-create.component.html',
  styleUrls: ['./customer-create.component.css']
})
export class CustomerCreateComponent implements OnInit {

  private _verticalPosition: MatSnackBarVerticalPosition = 'bottom';

  public formSubmited: boolean = false;

  public ufs: State[] = [];
  public cities: City[] = [];

  public customerForm: FormGroup = this.fb.group({
    name: ['', [Validators.required, Validators.minLength(3)]],
    email: ['', [Validators.required, Validators.email]],
    cpf: ['', Validators.required],
    birthdate: [''],
    address: this.fb.array([])
  });

  public addressForm: FormGroup = this.fb.group({
    street: ['', Validators.required],
    complement: ['', Validators.required],
    number: ['', Validators.required],
    district: ['', Validators.required],
    zip: ['', Validators.required],
    city: ['', Validators.required]
  });

  constructor(
    private _snackBar: MatSnackBar,
    private router: Router,
    private fb: FormBuilder,
    private localizationService: LocalizationService,
    private customerService: CustomerService,
    private errorDialogService: ErrorDialogService
  ) { }

  ngOnInit(): void {
    const addressControl = <FormArray>this.customerForm.controls['address'];
    addressControl.push(this.addressForm);
    this.loadUfs();
  }

  public save(): void {
    this.formSubmited = true;
    if (!this.customerForm.valid) {
      this.errorDialogService.openDialog({ message: 'Formulário inválido!'});
      return;
    }

    this.customerService.save(this.customerForm.value as Customer).subscribe(
      customer => {
        this.customerForm.reset();
        this.router.navigate(['/clientes']);

        let snackBarRef: MatSnackBarRef<any> = this._snackBar.open('Cliente cadastrado com sucesso!', 'OK', {
          verticalPosition: this._verticalPosition,
          panelClass: ['success-snackbar']
        });
      }
    );
  }

  public loadCities(ufId:string): void {
    
    if ("0" == ufId || "" == ufId) {
      this.cities = [];
      return;
    }

    this.localizationService.listCitiesByUf(parseInt(ufId)).subscribe(
      cities => { this.cities = cities; }
    );
  }

  private loadUfs(): void {
    this.localizationService.listUfs().subscribe(
      ufs => { this.ufs = ufs; }
    );
  }

}
