<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SeasonsController extends Controller
{
    public function index(Series $series): Factory|View|Application
    {
        $seasons = $series->seasons()->with('episodes')->get();

        return view('seasons.index')->with('seasons', $seasons)->with('series', $series);
    }
}
