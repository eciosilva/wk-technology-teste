import { AbstractControl, FormControl, ValidationErrors, ValidatorFn } from '@angular/forms';
import { Customer } from '../model/Customer';

export function instanceOfCustomer(c: FormControl): ValidationErrors | null {
  
    return ( typeof(c.value) == 'object'
            && ('cpf' in c.value && 'email' in c.value)
        ) ? null : { instanceOfCustomer: { valid: false } };
  
}