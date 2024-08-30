<?php

namespace App\Controller;

use App\dto\UsuarioDto;
use App\Exception\EmailInvalidoException;
use App\Exception\EmailJaCadastradoException;
use App\Exception\SenhaInvalidaException;
use App\Service\UsuarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Attribute\Route;


class UsuarioController extends AbstractController
{
    private UsuarioService $usuarioService;
    public function __construct
    (
        UsuarioService $usuarioService
    )
    {
        $this->usuarioService = $usuarioService;
    }

    #[Route('/usuario', name: 'cadastra_usuario', methods:"POST")]
    public function cadastraUsuario(Request $request): Response
    {
        try {
        //transformar o json em array e verficar se o formato do dado está em json
        if($request -> headers->get('Content-Type') == 'application/json'){
            $data = $request->toArray();

        }else{return $this->json(['error' => 'Data format not accepted'], Response::HTTP_UNSUPPORTED_MEDIA_TYPE);}

        // Verificar se todos os campos necessários estão presentes
        if (empty($data['email']) || empty($data['nome']) || empty($data['senha'])) {
            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        //criar novo usuarioDto e setar os dados
        $usuarioDto = new UsuarioDto();
        $usuarioDto->setEmail($data['email']);
        $usuarioDto->setNome($data['nome']);
        $usuarioDto->setSenha($data['senha']);

        // Chamar o serviço para cadastrar o usuário
       
            $this->usuarioService->cadastrarUsuario($usuarioDto);
            return $this->json(['message' => 'User registered successfully'], Response::HTTP_CREATED);
        }catch(EmailJaCadastradoException $e)
        {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_CONFLICT);
        }catch (\Exception $e) {
            // Em caso de erro, retornar uma resposta adequada
            return $this->json(['error' => 'Unable to register user'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        catch(SenhaInvalidaException $e){
            return $this->json(['error' => 'Senha Inválida'], Response::HTTP_BAD_REQUEST);
        }
        catch(EmailInvalidoException $e){
            return $this->json(['error' => 'Email Inválido'], Response::HTTP_BAD_REQUEST);

        }

    }
}
