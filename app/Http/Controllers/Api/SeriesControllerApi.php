<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use http\Env\Response;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeriesControllerApi extends Controller
{
    public function __construct(private readonly SeriesRepository $seriesRepository)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $query = Series::query();
        if ($request->has('nome')) {
            $query->where('nome', $request->nome);
        }

        return $query->paginate(5);
    }

    public function store(SeriesFormRequest $request): JsonResponse
    {
        return response()->json($this->seriesRepository->add($request), 201);
    }

    public function show(int $series)
    {
        $seriesModel = Series::with('seasons.episode')->find($series);
        if ($seriesModel === null) {
            return response()->json(['message' => 'Serie not found'], 404);
        }
        return $seriesModel;
    }

    public function update(Series $series, SeriesFormRequest $request): Series
    {
//        Series::where(‘id’, $series)->update($request->all());
        // retorno de uma resposta que não contenha a série, já que não fizemos um `SELECT`
        $series->fill($request->all());
        $series->save();

        return $series;
    }

    public function destroy(int $series): \Illuminate\Http\Response
    {
        Series::destroy($series);
        return response()->noContent();
    }
}
