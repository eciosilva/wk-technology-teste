import { Injectable } from '@angular/core';
import {
    HttpEvent,
    HttpInterceptor,
    HttpHandler,
    HttpRequest,
    HttpResponse,
    HttpErrorResponse
} from '@angular/common/http';
import { Observable, throwError } from 'rxjs';
import { map, retry, catchError } from 'rxjs/operators';

import { ErrorDialogService } from '../error-dialog/error-dialog.service';
import { Router } from '@angular/router';

@Injectable()
export class HttpErrorInterceptor implements HttpInterceptor {

    constructor(public errorDialogService: ErrorDialogService, private router: Router) { }

    intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

        return next.handle(request)
        .pipe(
            map((event: HttpEvent<any>) => {
                if (event instanceof HttpResponse) {
                    console.log('event--->>>', event);
                }
                return event;
            }),
            catchError((error: HttpErrorResponse) => {

                let consoleErrorMsg = '';
                let data = { message: '', status: error.status };

                if (error.error instanceof ErrorEvent) {
                    // client-side error
                    consoleErrorMsg = `Error: ${error.error.message}`;
                    data.message = consoleErrorMsg;
                } else {

                    consoleErrorMsg = `\nCode: ${error.status}\nMessage: ${error.message}`;

                    if ( error && error.error && error.error.detail ){
                        consoleErrorMsg += `\nDetail: ${error.error.detail}`;
                    }

                    //data.message = consoleErrorMsg;
                    switch (error.status) {
                        case 400: // BAD REQUEST
                            if (error && error.error && error.error.violations && (typeof(error.error.violations == 'array'))) {
                                error.error.violations.forEach(function(item: any){
                                    data.message += `${item.propertyPath}: ${item.title}\n`;
                                });
                            } else {
                                data.message = 'O Servidor não pôde processar a requisição!';
                            }
                            break;
                        
                        case 403: // FORBIDDEN
                            data.message = 'Acesso negado!';
                            break;

                        case 404: // URL Not Found
                        case 405: // Method Not Allowed
                            data.message = '404: Página não encontrada!';
                            break;
                        
                        case 409: // CONFLICT
                            if (error && error.error) {
                                data.message = error.error;
                            }
                            break;

                        case 500: // Internal Server Error
                        default:
                            data.message = 'Erro desconhecido!';
                    }
                }
                
                this.errorDialogService.openDialog(data);
                return throwError(() => new Error(consoleErrorMsg));
            })
        ); // pipe()
    }
}