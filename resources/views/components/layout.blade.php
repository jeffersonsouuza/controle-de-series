<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}} - Controle de Séries</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('series.index') }}">Séries</a>
            @auth
                <a class="navbar-brand" href="{{ route('logout') }}">Sair</a>
            @endauth

            @guest
                <a class="navbar-brand" href="{{ route('login') }}">Entrar</a>
            @endguest

        </div>
    </nav>

    <h1 class="">{{$title}}</h1>

    @isset($mensagemSucesso)
        <div class="alert alert-success">
            {{ $mensagemSucesso }}
        </div>
    @endisset

    {{--    erros gerados automaticamente pelo laravel--}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{$slot}}

{{--@{{nome}} envia para do jeito que está aparecendo e não faz o parse.--}}

</div>
</body>
</html>
