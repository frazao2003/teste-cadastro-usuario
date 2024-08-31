import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, ValidatorFn, AbstractControl, ValidationErrors, ReactiveFormsModule, FormsModule } from '@angular/forms';
import {RouterOutlet } from '@angular/router';
import { AlertaService } from '../services/alerta.service';
import { CadastroServiceService } from '../services/cadastro-service.service';
import { UsuarioDto } from '../dto/UsuarioDto';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet,ReactiveFormsModule, FormsModule, CommonModule, HttpClientModule ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss',
  providers: [CadastroServiceService]
})
export class AppComponent implements OnInit {
  
  
  
  clienteForm!: FormGroup;

  
  
  constructor(
    private cadastroService: CadastroServiceService,
    private alertaService: AlertaService,
    ) { }
  
    ngOnInit(): void {
      console.log(`cadastrarComponent initialized`)
    this.clienteForm = new FormGroup({
      nome: new FormControl('', [Validators.required]),
      senha: new FormControl('', [Validators.required, this.onlyNumbersValidator(), this.maiorQue8Validacao()]),
      email: new FormControl('',[ Validators.required, Validators.email]),
    })
  }

  get nome(){
    return this.clienteForm.get('nome')!;
  }
  get email(){
    return this.clienteForm.get('email')!;
  }
  get senha(){
    return this.clienteForm.get('senha')!;
  }




  

  cadastrar(){

    if (this.clienteForm.invalid) {
      this.alertaService.alertaErro('Informações inválidas');
      this.markAllAsTouched();
      return;
    }

    const {nome,senha,email} = this.clienteForm.value;
    const usuarioDto: UsuarioDto = {
      nome,
      senha,
      email
    };
    
    this.cadastroService.cadastrarUsuario(usuarioDto).subscribe(() =>{
      this.alertaService.alertaSucesso('CLIENTE CADASTRADO');
    }, (error) => {
      console.error(error);
      let errorMessage = 'Erro desconhecido';
      
      // Verifica o código de status e ajusta a mensagem de erro
      if (error.status === 400) {
        errorMessage = error.error.error || 'Dados inválidos.';
      }else if (error.status === 409) { // Código de conflito
        errorMessage = error.error.error || 'O e-mail já está cadastrado.';
      }
       else if (error.status === 415) {
        errorMessage = 'Formato de dados não aceito.';
      } else if (error.status === 500) {
        errorMessage = error.error.error || 'Erro interno do servidor.';
      } else {
        errorMessage = error.error.error || 'Ocorreu um erro inesperado.';
      }

      this.alertaService.alertaErro(errorMessage);
    }
    );
  }
  markAllAsTouched() {
    Object.keys(this.clienteForm.controls).forEach(field => {
      const control = this.clienteForm.get(field);
      if (control) {
        control.markAsTouched({ onlySelf: true });
      }
    });
  }
  onlyNumbersValidator(): ValidatorFn {
    return (control: AbstractControl): ValidationErrors | null => {
      if (control.value && !/^\d+$/.test(control.value)) {
        return { 'onlyNumbers': true };
      }
      return null;
    };
  }
  maiorQue8Validacao(): ValidatorFn {
    return (control: AbstractControl): { [key: string]: any  
   } | null => {
      return control.value.length  
   < 8 ? { 'minlength': true } : null;
    };
  }


  title = 'view';
}
