<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        $empresas = Cargo::orderBy('id', 'desc')->paginate(6);
        return view('cargo.index', ['collection' => $empresas]);
    }

    public function create()
    {
        return view('cargo.create');
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request);
        if ($this->validar_duplicidade($request)) {
            return redirect()
                ->action('App\Http\Controllers\CargoController@index')
                ->with('warning', "já existe um cargo com este nome!");
        }
        $cargo = new Cargo();
        $cargo->nome = $request->nome;
        $cargo->save();

        return redirect()
            ->action('App\Http\Controllers\CargoController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $cargo = Cargo::findOrFail($id);
        if ($cargo) {
            return view('cargo.edit', ['cargo' => $cargo]);
        } else {
            return redirect('cargo/')->with('error', 'Registro não existe!'); //retorna resultado.
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request); //Válidar Formulário.
        $cargo = Cargo::findOrFail($id);
        $cargo->nome = $request->nome;
        $cargo->update();
        return redirect('cargo')->with('status', 'Registro Atualizado!'); //retorna resultado.
    }

    public function destroy($id)
    {
        $c = Cargo::findOrFail($id);
        $colaboradores =  $c->colaboradores->count();
        if ($colaboradores >= 1) {
            return redirect()
                ->action('App\Http\Controllers\CargoController@index')
                ->with('warning', "Este cargo tem colaborador associado, por tanto não pode ser excluida.");
        }

        $c->delete();
        return redirect()
            ->action('App\Http\Controllers\CargoController@index')
            ->with('status', "Registro Excluido!");
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

    private function validar_duplicidade(Request $request)
    {
        $duplicado = Cargo::where('nome', $request->nome)
            ->get()->count();

        return $duplicado;
    }
}
