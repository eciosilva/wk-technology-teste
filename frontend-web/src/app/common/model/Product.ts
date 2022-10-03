import { OrderProduct } from "./OrderProduct";

export interface Product {
    id: number,
    name: string,
    price: number,
    orders: OrderProduct
}