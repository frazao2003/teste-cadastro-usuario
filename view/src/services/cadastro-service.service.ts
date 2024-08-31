import { Injectable } from '@angular/core';
import { environment } from '../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { UsuarioDto } from '../dto/UsuarioDto';

@Injectable({
  providedIn: 'root'
})
export class CadastroServiceService {

  endpoint = '/usuario'
  api = environment.api;

  constructor(private http: HttpClient) { }

  cadastrarUsuario(usuarioDto: UsuarioDto)
  {
    return this.http.post(`${this.api}${this.endpoint}`, usuarioDto);
  }
}
