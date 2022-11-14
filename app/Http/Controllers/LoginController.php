<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('login.index');
    }

    public function store(Request $request): RedirectResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->back()->withErrors(['E-mail ou senha inválidos']);
        }

        return to_route('series.index');
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();

        return to_route('login');

    }
}
