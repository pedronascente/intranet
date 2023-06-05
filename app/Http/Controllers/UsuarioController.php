<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Usuario;


class UsuarioController extends Controller
{
    public function index()
    {
        return view('usuario.index');
    }

    public function create()
    {
        return view('usuario.create');
    }

    public function store(Request $request)
    {
        // Validar.
        // Upload da foto.
        // Salvar na base.
        // Criar mensagens de status.
        // Redirecionar para pagina de listagem de usuário.

        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {
            return redirect()
                ->action('App\Http\Controllers\UsuarioController@index')
                ->with('status', "Registrado com sucesso!");
        }
    }

    public function show($id)
    {
        //$usuario = Usuario::findOrFail($id);
        return view('usuario.show');
    }

    public function edit($id)
    {
        return view('usuario.edit');
    }

    public function update(Request $request, $id)
    {
        //dd($request, $id);
        return redirect()
            ->action('App\Http\Controllers\UsuarioController@index')
            ->with('status', "Editdo com sucesso!");
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
                'name' => 'required|max:200|min:5',
                'usuario' => 'required|max:200|min:5',
                'email' => 'required|email',
                'password' => [
                    'required',
                    'min:6',
                    'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
                ],
                'grupo' => 'required',
                'colaborador_id' => 'required|max:4',
            ],
            [
                'name.required' => 'Campo obrigatório.',
                'usuario.required' => 'Campo obrigatório.',
                'email.required' => 'Digite um e-mail válido',
                'password.required' => 'Campo obrigatório.',
                'grupo.required' => 'Campo obrigatório.',
                'colaborador_id.required' => 'Campo obrigatório.',
            ]
        );
    }
}
