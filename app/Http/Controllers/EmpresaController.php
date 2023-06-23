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
        $this->validarFormulario($request);
        if ($this->validar_duplicidade($request)) {
            return redirect()
                ->action('App\Http\Controllers\EmpresaController@index')
                ->with('warning', "já existe uma empresa com este nome, ou cnpj!");
        }
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
        if ($this->validar_duplicidade($request)) {
            return redirect()
                ->action('App\Http\Controllers\EmpresaController@index')
                ->with('warning', "já existe uma empresa com este nome, ou cnpj!");
        }
        $empresa = Empresa::findOrFail($id);
        $empresa->nome = $request->nome;
        $empresa->cnpj = $request->cnpj;
        $empresa->update();
        return redirect('empresa')->with('status', 'Registro Atualizado!'); //retorna resultado.
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $colaboradores =  $empresa->colaboradores->count();
        if ($colaboradores >= 1) {
            return redirect()
                ->action('App\Http\Controllers\EmpresaController@index')
                ->with('warning', "Esta empresa tem colaborador associado, por tanto não pode ser excluida.");
        }

        $empresa->delete();
        return redirect()
            ->action('App\Http\Controllers\EmpresaController@index')
            ->with('status', "Registro Excluido!");
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

    private function validar_duplicidade(Request $request)
    {
        $duplicado = Empresa::where('nome', $request->nome)
            ->orWhere('cnpj', $request->cnpj)
            ->get()->count();

        return $duplicado;
    }
}
