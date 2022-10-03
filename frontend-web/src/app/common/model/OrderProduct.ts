import { Order } from "./Order";
import { Product } from "./Product";

export interface OrderProduct {
    order: Order,
    product: Product,
    amount: number,
    unitValue: number,
    totalValue: number
}