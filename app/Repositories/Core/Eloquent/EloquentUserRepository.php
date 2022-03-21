<?php

namespace App\Repositories\Core\Eloquent;

use App\Events\EventNovoUsuario;
use App\Events\EventRecuperarUsuario;
use App\User;
use Auth;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Core\BaseEloquentRepository;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository extends BaseEloquentRepository implements UserRepositoryInterface
{
    public function entity()
    {
        return User::class;
    }

    public function login($request)
    {
        dd('eloquent');
        $request->validate([
            'username'  => 'required',
            'password'  => 'required',
        ]);

        $credenciais = [
            'username'     => $request->username,
            'password'  => $request->password
        ];

        if (!Auth::attempt($credenciais))
            return response()->json([
                'resp' => 'Acesso negado.'
            ], 401);

        $user = $request->user();

        $token = $user->createToken('Password Grant Client')->accessToken;

        return response()->json([
            'token' => $token
        ], 200);
    }

    public function registro($request)
    {
        $request->request->add(['token'=> str_random(100)]);

        $request->validate([
            'permissao_id' => 'required',
            'name'          => 'required',
            'username'      => 'required',
            'password'      => 'required',
        ]);
        User::create([
            'permissao_id' => $request->permissao_id,
            'name'          => $request->name,
            'email'         => $request->email,
            'username'      => $request->username,
            'password'      => Hash::make($request->password),
            'token'         => $request->token,
        ]);

        event(new EventNovoUsuario($request->all()));

        return response()->json([
            'resp' => "Usuário criado com sucesso"
        ], 201);
    }

    public function logout($request)
    {
        
    }

    public function ativar($token)
    {
        $user = User::where('token', $token)->first();
        if ($user) {
            User::where('token', $token)->update([
                'status' => true
            ]);
            return response()->json([
                'resp' => "Usuário ativado com sucesso"
            ], 201);
        }
        return response()->json([
            'resp' => "Token inválido"
        ], 201);
    }

    public function atualizarSenha($request)
    {
        $user = User::where('id', $request->user_id)->first();
        if ($user) {
            User::where('id', $request->user_id)->update([
                'password' => Hash::make($request->password),
            ]);
            return response()->json([
                'resp' => "Senha atualizada com sucesso"
            ], 201);
        }
        return response()->json([
            'resp' => "Usuário inválido"
        ], 201);
    }

    public function recuperarSenha($email)
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            event(new EventRecuperarUsuario($user));        
        }
        return response()->json([
            'resp' => "Link para resetar senha encaminado por email"
        ], 201);
    }
}