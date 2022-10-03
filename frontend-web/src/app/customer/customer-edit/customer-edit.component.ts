import { Component, OnInit } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar, MatSnackBarRef, MatSnackBarVerticalPosition } from '@angular/material/snack-bar';
import { ActivatedRoute, Router } from '@angular/router';
import * as moment from 'moment';
import { ErrorDialogService } from 'src/app/common/error-dialog/error-dialog.service';
import { City } from 'src/app/common/model/City';
import { Customer } from 'src/app/common/model/Customer';
import { State } from 'src/app/common/model/State';
import { LocalizationService } from 'src/app/common/services/localization.service';
import { CustomerService } from '../customer.service';

@Component({
  selector: 'app-customer-edit',
  templateUrl: './customer-edit.component.html',
  styleUrls: ['./customer-edit.component.css']
})
export class CustomerEditComponent implements OnInit {

  private _verticalPosition: MatSnackBarVerticalPosition = 'bottom';

  public formSubmited: boolean = false;

  public customer?: Customer;
  public ufs: State[] = [];
  public cities: City[] = [];
  public ufId?: number;

  public customerForm: FormGroup = this.fb.group({
    id: [''],
    name: ['', [Validators.required, Validators.minLength(3)]],
    email: ['', [Validators.required, Validators.email]],
    cpf: ['', Validators.required],
    birthdate: [''],
    address: this.fb.array([])
  });

  public addressForm: FormGroup = this.fb.group({
    id: [''],
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
    private route: ActivatedRoute,
    private fb: FormBuilder,
    private localizationService: LocalizationService,
    private customerService: CustomerService,
    private errorDialogService: ErrorDialogService
  ) { }

  ngOnInit(): void {
    
    const id = parseInt(String(this.route.snapshot.paramMap.get('id')));

    this.customerService.fetch(id).subscribe(obj => {
      this.customer = obj;
      this.loadUfs();

      if (this.customer.birthdate) {
        let birthdate: Date = new Date(this.customer.birthdate);
        this.customer.birthdate = moment(birthdate).utcOffset('+0300').format("DD/MM/YYYY");
      }
      
      if (null != this.customer.adresses) {
        
        this.loadCities(String(this.customer.adresses[0].city.state.id));
        this.ufId = this.customer.adresses[0].city.state.id;
        this.addressForm.patchValue(this.customer.adresses[0]);
        this.addressForm.get('city')?.setValue(this.customer.adresses[0].city.id);
      }

      this.customerForm.patchValue(this.customer);

      const addressControl = <FormArray>this.customerForm.controls['address'];
      addressControl.push(this.addressForm);
    })
  }

  public save(): void {
    this.formSubmited = true;
    if (!this.customerForm.valid) {
      this.errorDialogService.openDialog({ message: 'Formulário inválido!'});
      return;
    }

    //console.log(this.customerForm.value);return;

    this.customerService.save(this.customerForm.value as Customer).subscribe(
      customer => {
        this.customerForm.reset();
        this.router.navigate(['/clientes']);

        let snackBarRef: MatSnackBarRef<any> = this._snackBar.open('Dados atualizados com sucesso!', 'OK', {
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