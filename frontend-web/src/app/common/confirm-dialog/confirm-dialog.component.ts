import { Component, OnInit, Inject } from '@angular/core';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';

@Component({
  selector: 'app-confirm-dialog',
  templateUrl: './confirm-dialog.component.html',
  styleUrls: ['./confirm-dialog.component.css']
})
export class ConfirmDialogComponent implements OnInit {

  private _defaults = {
    'cancelLabel': 'Cancelar',
    'confirmLabel': 'Confirmar',
    'confirmMessage': 'Tem certeza que deseja prosseguir?'
  }

  constructor(
    @Inject(MAT_DIALOG_DATA) public data: {
      confirmMessage: string, 
      confirmLabel: string, 
      cancelLabel: string
    }, 
    public dialogRef: MatDialogRef<ConfirmDialogComponent>
  )
  {
    // Apply default values if some of them is not defined
    if (this.data.cancelLabel == undefined) this.data.cancelLabel = this._defaults.cancelLabel;
    if (this.data.confirmLabel == undefined) this.data.confirmLabel = this._defaults.confirmLabel;
    if (this.data.confirmMessage == undefined) this.data.confirmMessage = this._defaults.confirmMessage;
  }

  ngOnInit(): void {
  }

}
