<x-layout title="Séries" :mensagem-sucesso="$mensagemSucesso">
    @auth()
     <a class="btn btn-dark mb-2" href="{{ route('series.create') }}">Adicionar</a>
    @endauth
{{--{{$serie}} /*Faz o echo*/--}}

<ul class="list-group">
    @foreach ($series as $serie)


    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <img src="{{ asset('storage/' . $serie->cover) }}" class="img-thumbnail" alt="Capa da Série" width="100">

            @auth <a href="{{ route('seasons.index', $serie->id) }}" class="mx-5"> @endauth
                {{$serie->nome}}
            @auth </a> @endauth
        </div>
        @auth
            <span class="d-flex">

                <a href="{{route('series.edit', $serie->id)}}" class="btn btn-primary btn-sm me-2">
                    E
                </a>

                <form action="{{ route('series.destroy', $serie->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        X
                    </button>
                </form>
            </span>
        @endauth
    </li>

    @endforeach
</ul>

</x-layout>

{{--/*--}}
{{--Ao ter um link que remova algo, faça logout ou algo do tipo, --}}
{{--robôs que seguem links podem acabar causando um certo estrago em nossa aplicação. --}}
{{--Ações destrutivas devem sempre ser feitas em requisições POST através de formulários.--}}
{{--*/--}}
