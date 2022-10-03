import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
    name: 'abbrExpand'
})
export class AbbrExpandPipe implements PipeTransform {
  
    private abbrs: any = {
        'default': {},
        'status': {
            'a': 'Desc1',
            'b': 'Desc2'
        }
    };

  transform(abbr: string, context: string = 'default'): string {
    return this.abbrs[context][abbr] || false;
  }
}
