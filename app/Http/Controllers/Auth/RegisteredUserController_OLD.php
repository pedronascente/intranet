<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Grupo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{

    public function create()
    {
        $grupos = Grupo::all();
        return view('auth.register', ['grupos' => $grupos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ativo' => ['required', 'string'],
            'grupo' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password_confirmation' => ['required'],
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:6',              // deve ter pelo menos 6 caracteres
                'regex:/[a-z]/',      // deve conter pelo menos uma letra minúscula
                'regex:/[A-Z]/',      // deve conter pelo menos uma letra maiúscula
                'regex:/[0-9]/',      // deve conter pelo menos um dígito
                'regex:/[@$!%*#?&]/', // deve conter um caractere especial
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'ativo' => $request->ativo,
            'grupo_id' => $request->grupo,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        Auth::login($user);
        return redirect()
            ->action('App\Http\Controllers\UserController@index')
            ->with('status', "Registrado com sucesso!");
    }
}
