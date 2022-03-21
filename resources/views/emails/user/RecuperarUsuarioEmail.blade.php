@component('mail::message')
# Olá,

@component('mail::table')
|Nome               | Usuário               | E-mail                        |
|:------------------|:---------------------:| -----------------------------:|
|{{$user['name']}}  | {{$user['username']}} | {{$user['email']}}            |
@endcomponent

[Clique aqui]({{url("api/auth/atualizar/senha/{$user['token']}")}}) para resetar sua senha de acesso.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
