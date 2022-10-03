import { LOCALE_ID, NgModule } from '@angular/core';
import { HashLocationStrategy, LocationStrategy, registerLocaleData } from '@angular/common';
import { BrowserModule } from '@angular/platform-browser';

import localePt from '@angular/common/locales/pt';
registerLocaleData(localePt);

/** Components */
import { MessagesComponent } from './common/messages/messages.component';
import { PageNotFoundComponent } from './common/page-not-found/page-not-found.component';
import { ErrorDialogComponent } from './common/error-dialog/error-dialog.component';
import { LoaderComponent } from './common/loader/loader.component';
import { ConfirmDialogComponent } from './common/confirm-dialog/confirm-dialog.component';
import { AppComponent } from './app.component';
import { DashboardComponent } from './dashboard/dashboard.component';

/** Pipes */
import { KeepHtmlPipe } from './common/pipes/keep-html.pipe';
import { Nl2pbrPipe } from './common/pipes/nl2pbr.pipe';
import { AbbrExpandPipe } from './common/pipes/abbr-expand.pipe';

/** Modules */
import { AppRoutingModule } from './app-routing.module';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

/** Common Services */
import { ErrorDialogService } from './common/error-dialog/error-dialog.service';
import { LoaderService } from './common/loader/loader.service';

/** Interceptors */
import { HttpErrorInterceptor } from './common/interceptors/http-error.interceptor';
import { LoaderInterceptor } from './common/interceptors/loader.interceptor';
import { AuthInterceptor } from './common/interceptors/auth.interceptor';

/** Angular Material */
import { MAT_DIALOG_DEFAULT_OPTIONS } from '@angular/material/dialog';
import { MatDialogModule } from '@angular/material/dialog';
import { MatProgressSpinnerModule } from '@angular/material/progress-spinner';
import { MatRadioModule } from '@angular/material/radio';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatAutocompleteModule } from '@angular/material/autocomplete';

/** 3rd Libs */
import { DataTablesModule } from 'angular-datatables';
import { NgxMaskModule } from 'ngx-mask';
import { NgApexchartsModule } from 'ng-apexcharts';
import { CustomerListComponent } from './customer/customer-list/customer-list.component';
import { CustomerCreateComponent } from './customer/customer-create/customer-create.component';
import { CustomerEditComponent } from './customer/customer-edit/customer-edit.component';
import { ProductListComponent } from './product/product-list/product-list.component';
import { ProductCreateComponent } from './product/product-create/product-create.component';
import { ProductEditComponent } from './product/product-edit/product-edit.component';
import { OrderListComponent } from './order/order-list/order-list.component';
import { OrderCreateComponent } from './order/order-create/order-create.component';
import { OrderViewComponent } from './order/order-view/order-view.component';

@NgModule({
  declarations: [
    MessagesComponent,
    PageNotFoundComponent,
    ErrorDialogComponent,
    LoaderComponent,
    ConfirmDialogComponent,
    KeepHtmlPipe,
    Nl2pbrPipe,
    AbbrExpandPipe,
    AppComponent,
    DashboardComponent,
    CustomerListComponent,
    CustomerCreateComponent,
    CustomerEditComponent,
    ProductListComponent,
    ProductCreateComponent,
    ProductEditComponent,
    OrderListComponent,
    OrderCreateComponent,
    OrderViewComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule,
    BrowserAnimationsModule,
    MatDialogModule,
    MatProgressSpinnerModule,
    MatRadioModule,
    MatSnackBarModule,
    MatPaginatorModule,
    MatAutocompleteModule,
    NgxMaskModule.forRoot(),
    DataTablesModule,
    NgApexchartsModule
  ],
  providers: [
    ErrorDialogService,
    LoaderService,
    { provide: LOCALE_ID, useValue: 'pt-BR' },
    //{ provide: HTTP_INTERCEPTORS, useClass: APIRequestInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: HttpErrorInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: LoaderInterceptor, multi: true },
    { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptor, multi: true },
    { provide: MAT_DIALOG_DEFAULT_OPTIONS, useValue: {hasBackdrop: true} },
    { provide: LocationStrategy, useClass: HashLocationStrategy}
  ],
  entryComponents: [ErrorDialogComponent],
  bootstrap: [AppComponent]
})
export class AppModule { }
