<?php

namespace App\dto;

class UsuarioDto
{
    private ?string $nome;
    private ?string $email;
    private ?string $senha;

    public function __construct(?string $nome = null, ?string $email = null, ?string $senha = null) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

        // Getter para o atributo nome
        public function getNome(): string {
            return $this->nome;
        }
    
        // Setter para o atributo nome
        public function setNome(string $nome): void {
            $this->nome = $nome;
        }
    
        // Getter para o atributo email
        public function getEmail(): string {
            return $this->email;
        }
    
        // Setter para o atributo email
        public function setEmail(string $email): void {
            $this->email = $email;
        }
    
        // Getter para o atributo senha
        public function getSenha(): string {
            return $this->senha;
        }
    
        // Setter para o atributo senha
        public function setSenha(string $senha): void {
            $this->senha = $senha;
        }
    
}