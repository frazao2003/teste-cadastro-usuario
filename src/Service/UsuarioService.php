<?php

namespace App\Service;

use App\dto\UsuarioDto;
use App\Entity\Usuario;
use App\Exception\EmailInvalidoException;
use App\Exception\EmailJaCadastradoException;
use App\Exception\SenhaInvalidaException;
use App\Repository\UsuarioRepository;

class UsuarioService{

    private UsuarioRepository $usuarioRepository;

    public function __construct
    (
        UsuarioRepository $usuarioRepository
    )
    {
        $this->usuarioRepository = $usuarioRepository;
    }


    public function cadastrarUsuario(UsuarioDto $usuarioDTO){
        //verifica se o email já nao foi cadastrado
        if ($this->usuarioRepository->findOneByEmail($usuarioDTO->getEmail()))
        {
            throw new EmailJaCadastradoException("Email já cadastrado");
        }

        if(strlen($usuarioDTO->getSenha() < 8))
        {
            throw new SenhaInvalidaException("Senha Inválida");
        }
        if (filter_var($usuarioDTO->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new EmailInvalidoException("Email inválido");
        }
        
        //cria novo usuario e chama e o persiste
        $usuario = new Usuario;
        $usuario->setEmail($usuarioDTO->getEmail());
        $usuario->setNome($usuarioDTO->getNome());
        $usuario->setSenha($this->hashSenha($usuarioDTO->getSenha()));
        $usuario->setDataCriacao(new \DateTimeImmutable("now"));
        $this->usuarioRepository->cadastrarUsuario($usuario);

    }
    //codifica a senha para salvar ela codificada no banco de dados
    private function hashSenha(string $senha): string
    {
        return password_hash($senha, PASSWORD_BCRYPT);
    }
}