<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grupo;

class UserController extends Controller
{
    public function index()
    {
        $collections  =  User::with('grupo')->get();
        return view('user.index', ['collections' => $collections]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $grupos = Grupo::orderBy('id', 'desc')->get();

        return view('user.edit', [
            'user' => $user,
            'grupos' => $grupos
        ]);
    }

    public function update(Request $request, $id)
    {
        $usuario = User::with('grupo')->findOrFail($id);
        $this->validarFormulario($request, $usuario);
        echo 'usuario atualizado!';
    }

    public function show($id)
    {
        $user = User::with('grupo', 'colaborador')->findOrFail($id);
        return view('user.show', ['user' => $user]);
    }

    public function destroy($id)
    {
        return redirect()
            ->action('App\Http\Controllers\UserController@index')
            ->with('status', "Inativado com sucesso!");
    }

    private function validarFormulario(Request $request, $usuario)
    {
        $regras =  [
            'ativo' => ['required', 'string'],
            'grupo' => ['required'],
            'name' => ['required', 'string', 'max:255'],
        ];

        if ($usuario->email != $request->email) {
            $regras = array_merge($regras, [
                'email' => ['email', 'max:255', 'unique:users'],
            ]);
        }

        if (!is_null($request->password) || !is_null($request->password_confirmation)) {
            $regras = array_merge($regras, [
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
        }
        $request->validate($regras);
    }
}
