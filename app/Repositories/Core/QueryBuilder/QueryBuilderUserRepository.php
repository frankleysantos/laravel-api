<?php

namespace App\Repositories\Core\QueryBuilder;

use App\Events\EventNovoUsuario;
use App\Events\EventRecuperarUsuario;
use Auth;
use DB;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Core\BaseQueryBuilderRepository;
use Illuminate\Support\Facades\Hash;

class QueryBuilderUserRepository extends BaseQueryBuilderRepository implements UserRepositoryInterface
{
    protected $table = 'users';

    public function login($request)
    {
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
       if ($user['status'] == 0)
            return response()->json([
                'resp' => 'Usuário não está ativo.'
            ], 401);

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
        DB::table($this->table)->insert([
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
        $user = DB::table($this->table)->where('token', $token)->first();
        if ($user) {
            DB::table($this->table)->where('token', $token)->update([
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
        $user = DB::table($this->table)->where('id', $request->user_id)->first();
        if ($user) {
            DB::table($this->table)->where('id', $request->user_id)->update([
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
        $user = DB::table($this->table)->where('email', $email)->first();
        if ($user) {
            event(new EventRecuperarUsuario($user));        
        }
        return response()->json([
            'resp' => "Link para resetar senha encaminado por email"
        ], 201);
    }
}