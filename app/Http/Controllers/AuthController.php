<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function register(): Response
    {
        return Inertia::render("Auth/Signup");
    }


    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        User::create($validated);
        Auth::attempt($validated);
        $request->session()->regenerate();

        return redirect()->intended('/collections');
    }


    public function login(): Response {
        return Inertia::render('Auth/Login');
    }


    public function authenticate(LoginRequest $request): RedirectResponse {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect()->intended("/records");
        }

        return back()->withInput(['email'])->withErrors([
            'email' => 'Неправильные адрес почты или пароль.',
            'password' => 'Неправильные адрес почты или пароль.',
        ]);
    }
}
