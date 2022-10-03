import { Address } from "./Address";

export interface Customer {
    id: number,
    name: string,
    email: string,
    cpf: string,
    birthdate?: any,
    adresses: Address[]
}