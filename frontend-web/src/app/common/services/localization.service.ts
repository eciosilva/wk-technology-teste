import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { MessageService } from '../messages/message.service';
import { City } from '../model/City';
import { State } from '../model/State';

@Injectable({
  providedIn: 'root'
})
export class LocalizationService {

  private url: string = '/api/';

  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor(private http: HttpClient, private messageService: MessageService) { }

  listUfs(): Observable<State[]> {
    return this.http.get<State[]>(this.url+'ufs', this.httpOptions);
  }

  listCitiesByUf(ufId:number): Observable<City[]> {
    return this.http.get<City[]>(`${this.url}cities/${ufId}`, this.httpOptions);
  }
}
