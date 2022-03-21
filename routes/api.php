<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function() {
    Route::post('registro', 'AutenticadorController@registro');
    Route::post('login', 'AutenticadorController@login');
    Route::get('ativacao/{token}', 'AutenticadorController@ativar');
    Route::get('recuperar/senha/{email}', 'AutenticadorController@recuperarSenha');
    Route::post('atualizar/senha', 'AutenticadorController@atualizarSenha');
    Route::post('logout', 'AutenticadorController@logout')->middleware('auth');
});