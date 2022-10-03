import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'nl2pbr'
})
export class Nl2pbrPipe implements PipeTransform {

  transform(value: any, args?: any): any {
    // return value.replace(/\n/g, '<br />');
    value = value.replace(/(?:\r\n\r\n|\r\r|\n\n)/g, '</p><p>');
    return '<p>' + value.replace(/(?:\r\n|\r|\n)/g, '<br>') + '</p>';
  }

/****************************
 * example useage
 * <div [innerHTML]="'testi\n\nng \n t/n/nest\n\b\ning' | translate | nl2pbr"></div>
 ****************************/

}