<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function index()
    {
        $empresas = Tipo::orderBy('id', 'desc')->paginate(6);
        return view('cargo.index', ['collection' => $empresas]);
    }

    public function create()
    {
        return view('cargo.create');
    }

    public function store(Request $request)
    {
        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {

            $tipo = new Tipo();
            $tipo->nome = $request->nome;
            $tipo->save();

            return redirect()
                ->action('App\Http\Controllers\TipoController@index')
                ->with('status', "Registrado com sucesso!");
        }
    }

    public function edit($id)
    {
        $cargo = Tipo::findOrFail($id);
        if ($cargo) {
            return view('cargo.edit', ['cargo' => $cargo]);
        } else {
            return redirect('cargo/')->with('error', 'Registro não existe!'); //retorna resultado.
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request); //Válidar Formulário.
        $cargo = Tipo::findOrFail($id);
        $cargo->nome = $request->nome;
        $cargo->update();
        return redirect('cargo')->with('status', 'Registro Atualizado!'); //retorna resultado.
    }

    public function destroy($id)
    {
        dd($id);
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
            ]
        );
    }
}
