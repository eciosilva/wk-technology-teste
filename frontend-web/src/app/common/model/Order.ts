import { Customer } from "./Customer";
import { OrderProduct } from "./OrderProduct";

export interface Order {
    id: number,
    createdAt?: any,
    totalValue: number,
    customer: Customer,
    products: OrderProduct[]
}