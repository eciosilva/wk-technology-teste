import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Order } from '../common/model/Order';
import { OrderProduct } from '../common/model/OrderProduct';
import { Paginator } from '../common/paginator/Paginator';

@Injectable({
  providedIn: 'root'
})
export class OrderService {

  private url: string = '/api/order';

  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor(private http: HttpClient) { }

  /**
   * Retrieves a paginated list of Orders.
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
   * Fetches a Order data
   * @param id
   */
  public fetch(id: number):Observable<Order> {
    return this.http.get<Order>(`${this.url}/${id}`, this.httpOptions);
  }

  /**
   * Fetches the Products from an Order
   * @param id
   */
   public products(id: number):Observable<OrderProduct[]> {
    return this.http.get<OrderProduct[]>(`${this.url}/${id}/products`, this.httpOptions);
  }

  /**
   * Creates a Order or edits its data
   * @param order 
   */
  public save(order: Order): Observable<Order> {

    return (order.id) ? this.edit(order) : this.create(order);
  }

  /**
   * Deletes a Order object
   * @param order 
   */
  public delete(order: Order): Observable<Order> {
    return this.http.delete<Order>(`${this.url}/${order.id}`, this.httpOptions);
  }

  /**
   * Fetches a list with the last registered Orders
   * @param limit 
   * @returns 
   */
  public fetchLastRegistered(limit: number): Observable<Order[]> {
    return this.http.get<Order[]>(`${this.url}s/last-registered/${limit}`, this.httpOptions);
  }

  /**
   * Creates a new Order object
   * @param order
   */
  private create(order: Order): Observable<Order> {
    return this.http.post<Order>(this.url, order, this.httpOptions);
  }

  /**
   * Edits a Order data
   * @param order
   */
  private edit(order: Order): Observable<Order> {
    return this.http.put<Order>(`${this.url}/${order.id}`, order, this.httpOptions);
  }
}
