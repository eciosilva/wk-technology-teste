import { Component, OnInit, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-error-dialog',
  templateUrl: './error-dialog.component.html',
  styleUrls: ['./error-dialog.component.css']
})
export class ErrorDialogComponent implements OnInit {

  title = 'Angular-Interceptor';
  constructor(@Inject(MAT_DIALOG_DATA) public data: {message: string, status: string}, public dialogRef: MatDialogRef<ErrorDialogComponent>) {}

  ngOnInit(): void {
  }

  closeDialog(): void {
    this.dialogRef.close();
  }

}
