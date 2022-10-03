import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PageNotFoundComponent } from './common/page-not-found/page-not-found.component';
import { CustomerCreateComponent } from './customer/customer-create/customer-create.component';
import { CustomerEditComponent } from './customer/customer-edit/customer-edit.component';
import { CustomerListComponent } from './customer/customer-list/customer-list.component';
import { DashboardComponent } from './dashboard/dashboard.component';
import { OrderCreateComponent } from './order/order-create/order-create.component';
import { OrderListComponent } from './order/order-list/order-list.component';
import { OrderViewComponent } from './order/order-view/order-view.component';
import { ProductCreateComponent } from './product/product-create/product-create.component';
import { ProductEditComponent } from './product/product-edit/product-edit.component';
import { ProductListComponent } from './product/product-list/product-list.component';

const routes: Routes = [
  { path: '', redirectTo: '/home', pathMatch: 'full' },
  { path: 'home', component: DashboardComponent },
  { path: 'clientes', component: CustomerListComponent },
  { path: 'cliente/novo', component: CustomerCreateComponent },
  { path: 'cliente/:id', component: CustomerEditComponent },
  { path: 'produtos', component: ProductListComponent },
  { path: 'produto/novo', component: ProductCreateComponent },
  { path: 'produto/:id', component: ProductEditComponent },
  { path: 'pedidos', component: OrderListComponent },
  { path: 'pedido/novo', component: OrderCreateComponent },
  { path: 'pedido/:id', component: OrderViewComponent },
  { path: '**', component: PageNotFoundComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
