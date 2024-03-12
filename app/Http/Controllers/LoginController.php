<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'O campo e-mail é obrigatório',
            'email.email' => 'O campo e-mail deve ser um e-mail válido',
            'password.required' => 'O campo senha é obrigatório',
        ]);

        $credenciais = $request->only('email', 'password');
        $autentica = Auth::attempt($credenciais);

        if (!$autentica) {
            return redirect()->route('login.index')->withErrors(['error' => 'E-mail ou senha incorretos']);
        } else {
            return redirect()->route('site.principal')->withErrors(['success' => 'Login efetuado com sucesso']);
        }
    }

    public function destroy(): RedirectResponse
    {
        // Faz o logout do usuário
        Auth::logout();
        return redirect()->route('login');
    }
}
