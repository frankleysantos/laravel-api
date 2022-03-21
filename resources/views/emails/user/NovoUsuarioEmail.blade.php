@component('mail::message')
#Olá, 
Foi criado o seu usuário com os seguintes dados:

@component('mail::table')
|Nome               | Usuário               | E-mail                        |
|:------------------|:---------------------:| -----------------------------:|
|{{$user['name']}}  | {{$user['username']}} | {{$user['email']}}            |
@endcomponent

[Clique aqui]({{url("api/auth/ativacao/{$user['token']}")}}) para ativar o seu acesso.

@component('mail::table')

@endcomponent


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
