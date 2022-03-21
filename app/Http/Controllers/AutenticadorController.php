<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\UserRepositoryInterface;

class AutenticadorController extends Controller
{
    protected $user;

    public function __construct(UserRepositoryInterface $usuario)
    {
        $this->user = $usuario;
    }
    public function login(Request $request)
    {
        $response = $this->user->login($request);
        return $response;
    }

    public function registro(Request $request)
    {
        $response = $this->user->registro($request);
        return $response;
    }

    public function logout(Request $request) 
    {
        $request->user()->token()->revoke();
        return response()->json([
            'resp' => 'Deslogado com sucesso'
        ]);
    }

    public function ativar($token)
    {
        $response = $this->user->ativar($token);
        return $response;
    }

    public function recuperarSenha($email)
    {
        $response = $this->user->recuperarSenha($email);
        return $response;
    }

    public function atualizarSenha(Request $request)
    {
        $response = $request->user->atualizarSenha($request);
        return $response;
    }
}
