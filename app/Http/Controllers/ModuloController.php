<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;

class ModuloController extends Controller
{
    public function index()
    {
        $modulos = Modulo::orderBy('id', 'desc')->paginate(6);
        return view('modulo.index', ['collection' => $modulos]);
    }

    public function create()
    {
        return view('modulo.create');
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request); //Válidar Formulario.
        $modulo = new Modulo; //Instânciar objeto.
        $modulo->nome = $request->nome;
        $modulo->descricao = $request->descricao;
        $modulo->save(); //persistir dados.
        return redirect()
            ->action('App\Http\Controllers\ModuloController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        $modulo = Modulo::find($id);
        return view('modulo.show', ['modulo' => $modulo]);
    }

    public function edit($id)
    {
        $modelo = Modulo::findOrFail($id); //retornar modulo na base mysql.
        if ($modelo) {
            return view('modulo.edit', ['modulo' => $modelo]);
        } else {
            return redirect('modulo/')->with('error', 'Registro não existe!'); //retorna resultado.
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request); //Válidar Formulário.
        $modulo = Modulo::findOrFail($id); //Recuperar modulo da base de dados.
        $modulo->nome = $request->nome;
        $modulo->descricao = $request->descricao;
        $modulo->update();
        return redirect('/modulo')->with('status', 'Registro Atualizado!'); //retorna resultado.
    }

    public function destroy($id)
    {
        $modulo = Modulo::findOrFail($id);
        $modulo->delete();
        return redirect('modulo')->with('status', 'Registro Excluido!'); //retorna resultado.
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|min:2',
                'descricao' => 'required|max:190|min:5',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'descricao.required' => 'Campo obrigatório.',
            ]
        );
    }
}
