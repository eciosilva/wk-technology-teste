import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Product } from '../common/model/Product';
import { Paginator } from '../common/paginator/Paginator';

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  private url: string = '/api/product';

  private httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json' })
  };

  constructor(private http: HttpClient) { }

  /**
   * Retrieves a paginated list of Products.
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
   * Fetches a Product data
   * @param id
   */
  public fetch(id: number):Observable<Product> {
    return this.http.get<Product>(`${this.url}/${id}`, this.httpOptions);
  }

  /**
   * Fetches all Products data
   */
   public fetchAll():Observable<Product[]> {
    return this.http.get<Product[]>(`${this.url}s/all`, this.httpOptions);
  }

  /**
   * Creates a Product or edits its data
   * @param product 
   */
  public save(product: Product): Observable<Product> {

    return (product.id) ? this.edit(product) : this.create(product);
  }

  /**
   * Deletes a Product object
   * @param product 
   */
  public delete(product: Product): Observable<Product> {
    return this.http.delete<Product>(`${this.url}/${product.id}`, this.httpOptions);
  }

  /**
   * Creates a new Product object
   * @param product
   */
  private create(product: Product): Observable<Product> {
    return this.http.post<Product>(this.url, product, this.httpOptions);
  }

  /**
   * Edits a Product data
   * @param product
   */
  private edit(product: Product): Observable<Product> {
    return this.http.put<Product>(`${this.url}/${product.id}`, product, this.httpOptions);
  }
}
