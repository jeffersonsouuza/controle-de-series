<x-layout title="Temporadas de {!! $series->nome !!}">

    <div class="row">

        <img src="{{ asset('storage/' . $series->cover) }}" alt="Capa da Série" class="img-fluid col-4"
       style="height: 200px">

        <ul class="list-group col-8">
            @foreach ($seasons as $season)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('episodes.index', $season->id) }}">
                        Temporada {{ $season->number }}
                    </a>

                    <span class="badge bg-secondary">
                        {{ $season->numberOfWatchedEpisodes() }} / {{ $season->episodes->count() }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
</x-layout>
