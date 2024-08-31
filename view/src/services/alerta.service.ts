import { Injectable } from '@angular/core';
import Swal from 'sweetalert2';

@Injectable({
  providedIn: 'root'
})
export class AlertaService {

  constructor() { }
  alertaSucesso(mensagem: string) {
    Swal.fire({
      title: 'PARABENS',
      text: mensagem,
      icon: 'success'
    });
  }

  alertaErro(mensagem: string) {
    Swal.fire({
      title: 'ERROR',
      text: mensagem,
      icon: 'error'
    });
  }
} 
