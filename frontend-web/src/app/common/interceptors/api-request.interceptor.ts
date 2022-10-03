import {Injectable} from '@angular/core';
import {HttpEvent, HttpInterceptor, HttpHandler, HttpRequest} from '@angular/common/http';
import {Observable} from 'rxjs';
import { environment } from 'src/environments/environment';

@Injectable()
export class APIRequestInterceptor implements HttpInterceptor {

  private apiUrl: string;

  constructor(){ this.apiUrl = environment.apiUrl;}

  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

    const apiReq = req.clone({ url: `${this.apiUrl}${req.url}` });
    return next.handle(apiReq);
  }
}