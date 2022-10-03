import { City } from "./City";
import { Customer } from "./Customer";

export interface Address {
    id: number,
    street: string,
    number: string,
    district: string,
    zip: string,
    complement: string,
    customer: Customer,
    city: City
}