<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Autenticador;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;
use App\Repositories\SeriesRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{

    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware(Autenticador::class)->except('index');
    }

    /* existe um padrão para nomear as actions */
    public function index(Request $request): Factory|View|Application
    {
        $series = Series::all();

        $mensagemSucesso = $request->session()->get('mensagem.sucesso');

        return view('series.index')->with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create(): Factory|View|Application
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request): RedirectResponse
    {
        $coverPath = $request->hasFile('cover')
            ? $request->file('cover')->store('series_cover', 'public')
            : null;
        $request->coverPath = $coverPath;

        $serie = $this->repository->add($request);

        $userList = User::all();
        foreach ($userList as $index => $user) {
            $email = new SeriesCreated(
                $serie->nome,
                $serie->id,
                $request->seasonsQty,
                $request->episodesPerSeason,
            );
            //sleep(2);
            $when = now()->addSeconds($index * 2);
            Mail::to($user)->later($when, $email);
        }

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");

    }


    public function destroy(Series $series): RedirectResponse
    {
        $series->delete();
        \App\Jobs\DeleteSeriesCover::dispatch($series->cover);
        return to_route('series.index')
            ->with('mensagem.sucesso', "Série {$series->nome} removida com sucesso");
    }

    public function edit(Series $series): View|Factory|Application
    {
        return \view('series.edit')->with('serie', $series);
    }

    public function update(Series $series, SeriesFormRequest $request): RedirectResponse
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada com sucesso");
    }
}
