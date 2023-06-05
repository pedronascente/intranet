<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::orderBy('id', 'desc')->paginate(6);
        return view('empresa.index', ['collection' => $empresas]);
    }

    public function create()
    {
        return view('empresa.create');
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request); //Válidar Formulário.
        $empresa = new Empresa(); //Instânciar objeto.
        $empresa->nome = $request->nome;
        $empresa->cnpj = $request->cnpj;
        $empresa->save(); //persistir dados.

        return redirect()
            ->action('App\Http\Controllers\EmpresaController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        $empresa = Empresa::find($id);
        return view('empresa.show', ['empresa' => $empresa]);
    }

    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        if ($empresa) {
            return view('empresa.edit', ['empresa' => $empresa]);
        } else {
            return redirect('empresa/')->with('error', 'Registro não existe!'); //retorna resultado.
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request); //Válidar Formulário.
        $empresa = Empresa::findOrFail($id);
        $empresa->nome = $request->nome;
        $empresa->cnpj = $request->cnpj;
        $empresa->update();
        return redirect('empresa')->with('status', 'Registro Atualizado!'); //retorna resultado.
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return redirect('empresa')->with('status', 'Registro Excluido!'); //retorna resultado.
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:190|min:2',
                'cnpj' => 'required|max:20',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'cnpj.required' => 'Campo obrigatório.'
            ]
        );
    }
}
