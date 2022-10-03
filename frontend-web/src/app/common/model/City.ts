import { State } from "./State";

export interface City {
    id: number,
    name: string,
    slug: string,
    lat: number,
    lng: number,
    cod?: string,
    state: State
}