<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
        $empresas = Empresa::paginate(6);
        return view('empresa.index', ['collection' => $empresas]);
    }

    public function create()
    {
        return view('empresa.create');
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);

        $empresa = new Empresa();
        $empresa->nome = $request->nome;
        $empresa->save();

        return redirect('empresa/create')->with('status', 'Registro Salvo!');
    }

    public function show($id)
    {
        $empresa = Empresa::find($id);
        return view('empresa.show', ['empresa' => $empresa]);
    }

    public function edit($id)
    {
        $empresa = Empresa::find($id);
        return view('empresa.edit', ['empresa' => $empresa]);
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $empresa = Empresa::findOrFail($id);
        $empresa->nome = $request->nome;
        $empresa->update();
        return redirect('empresa')->with('status', 'Registro Atualizado!');
    }

    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
        return redirect('empresa')->with('status', 'Registro Excluido!');
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:200|min:5',
            ],
            [
                'nome.required' => 'Campo obrigatório.'
            ]
        );
    }
}
