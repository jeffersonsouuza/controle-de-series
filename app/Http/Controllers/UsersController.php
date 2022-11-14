<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function create(): Factory|View|Application
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->except(['token']);
        $data['password'] = Hash::make($data['password']);
        $user =  User::create($data);

        Auth::login($user);

        return to_route('series.index');
    }
}
