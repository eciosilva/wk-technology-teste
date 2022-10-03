import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Customer } from '../common/model/Customer';
import { Paginator } from '../common/paginator/Paginator';

@Injectable({
  providedIn: 'root'
})
export class CustomerService {

  private url: string = '/api/customer';

  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor(private http: HttpClient) { }

  /**
   * Retrieves a paginated list of Customers.
   * If searchTerm is given, it will be appended to the query string
   * @param page
   * @param searchTerm
   * @returns
   */
  public paginate(page: number, searchTerm?: string): Observable<Paginator> {
    
    let __url = `${this.url}s/${page}`;
    if (searchTerm) {
      __url += `?q=${searchTerm}`;
    }

    return this.http.get<Paginator>(__url, this.httpOptions);
  }

  /**
   * Fetches a Customer data
   * @param id
   */
  public fetch(id: number):Observable<Customer> {
    return this.http.get<Customer>(`${this.url}/${id}`, this.httpOptions);
  }

  /**
   * Creates a Customer or edits its data
   * @param customer 
   */
  public save(customer: Customer): Observable<Customer> {

    return (customer.id) ? this.edit(customer) : this.create(customer);
  }

  /**
   * Deletes a Customer object
   * @param customer 
   */
  public delete(customer: Customer): Observable<Customer> {
    return this.http.delete<Customer>(`${this.url}/${customer.id}`, this.httpOptions);
  }

  /**
   * Fetches a list with the last registered Customers
   * @param limit 
   * @returns 
   */
  public fetchLastRegistered(limit: number): Observable<Customer[]> {
    return this.http.get<Customer[]>(`${this.url}s/last-registered/${limit}`, this.httpOptions);
  }

  /**
   * Search for Customers by a miscelaneous term
   * @param term 
   * @param limit 
   * @returns 
   */
  public searchByTerm(term: string, limit: number = 10): Observable<Customer[]> {
    return this.http.get<Customer[]>(`${this.url}s/search-by-term/${limit}`, this.httpOptions);
  }

  /**
   * Fetches all Customers objects
   * @returns 
   */
  public fetchAll(): Observable<Customer[]> {
    return this.http.get<Customer[]>(`${this.url}s/all`, this.httpOptions);
  }

  /**
   * Creates a new Customer object
   * @param customer
   */
  private create(customer: Customer): Observable<Customer> {
    return this.http.post<Customer>(this.url, customer, this.httpOptions);
  }

  /**
   * Edits a Customer data
   * @param customer
   */
  private edit(customer: Customer): Observable<Customer> {
    return this.http.put<Customer>(`${this.url}/${customer.id}`, customer, this.httpOptions);
  }
}
