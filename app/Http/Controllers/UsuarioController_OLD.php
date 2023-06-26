<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Colaborador;
use App\Models\Grupo;

class UsuarioController extends Controller
{




    public function show($id)
    {
        //$usuario = Usuario::findOrFail($id);
        return view('usuario.show');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $collection_grupo = Grupo::all();
        if ($usuario) {
            return view('user.edit', [
                'usuario' => $usuario,
                'collection_grupo' => $collection_grupo,
            ]);
        } else {
            return redirect('usuario/')->with('error', 'Registro não existe!');
        }
    }

    public function update(Request $request, $id)
    {

        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {

            $usuario = Usuario::findOrFail($id);
            $usuario->ativo = $request->ativo;
            $usuario->usuario = $request->usuario;
            $usuario->password = $request->password;
            $usuario->email = $request->email;

            $colaborador = Colaborador::findorFail($request->colaborador_id);
            $usuario->colaborador()->associate($colaborador);

            $grupo = Grupo::findorFail($request->grupo_id);
            $usuario->grupo()->associate($grupo);

            $usuario->update();

            return redirect()
                ->action('App\Http\Controllers\UsuarioController@index')
                ->with('status', "Editdo com sucesso!");
        }
    }

    public function destroy($id)
    {
        // dd($id);
        return redirect()
            ->action('App\Http\Controllers\UsuarioController@index')
            ->with('status', "Inativado com sucesso!");
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'usuario' => 'required|max:190|min:5',
                'password' => [
                    'required',
                    'min:6',
                ],
                'email' => 'required|email|max:190',
                'grupo_id' => 'required|max:4',
                'colaborador_id' => 'required|max:4',
            ],
            [
                'usuario.required' => 'Campo obrigatório.',
                'password.required' => 'Campo obrigatório.',
                'email.required' => 'Digite um e-mail válido',
                'grupo_id.required' => 'Campo obrigatório.',
                'colaborador_id.required' => 'Campo obrigatório.',
            ]
        );
    }
}


/*
[
                'usuario' => 'required|max:190|min:5',
                'password' => [
                    'required',
                    'min:6',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
                ],
                'email' => 'required|email|max:190',
                'grupo_id' => 'required',
                'colaborador_id' => 'required|max:4',
            ],
            [
                'usuario.required' => 'Campo obrigatório.',
                'password.required' => 'Campo obrigatório.',
                'email.required' => 'Digite um e-mail válido',
                'grupo_id.required' => 'Campo obrigatório.',
                'colaborador_id.required' => 'Campo obrigatório.',
            ]
*/