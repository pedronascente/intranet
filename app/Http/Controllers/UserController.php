<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $collections  =  User::with('grupo')->get();
        return view('usuario.index', ['collections' => $collections]);
    }

    public function destroy($id)
    {
        return redirect()
            ->action('App\Http\Controllers\UsuarioController@index')
            ->with('status', "Inativado com sucesso!");
    }
}
