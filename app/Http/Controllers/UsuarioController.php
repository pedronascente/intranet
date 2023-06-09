<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Colaborador;
use App\Models\Grupo;

class UsuarioController extends Controller
{
    public function index()
    {
        $collections  =  Usuario::with(['colaborador'])->get();

        return view('usuario.index', ['collections' => $collections]);
    }

    public function create()
    {
        return view('usuario.create');
    }

    public function store(Request $request)
    {
        /*
         * a) Validar.
         * b) Instanciar Objeto.
         * c) Salvar na base.
         * d) Criar mensagens de status.
         * e) Redirecionar para pagina de listagem de usuário.
        */

        //dd($request->all());
        #a:
        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {
            #b: 
            $usuario = new Usuario();
            $usuario->ativo = $request->ativo;
            $usuario->usuario = $request->usuario;
            $usuario->password = $request->password;
            $usuario->email = $request->email;
            $usuario->colaborador_id = $request->colaborador_id;
            $usuario->grupo_id = $request->grupo_id;

            $usuario->save();
            # d: and e:
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
        $usuario = Usuario::findOrFail($id);
        $collection_grupo = Grupo::all();
        if ($usuario) {
            return view('usuario.edit', [
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