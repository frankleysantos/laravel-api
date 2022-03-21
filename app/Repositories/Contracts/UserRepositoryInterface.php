<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    // public function search();
    public function login($request);

    public function registro($request);

    public function logout($request);

    public function ativar($token);

    public function recuperarSenha($email);

    public function atualizarSenha($request);
}