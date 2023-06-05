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
        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {

            $cargo = new Cargo();
            $cargo->nome = $request->nome;
            $cargo->save();

            return redirect()
                ->action('App\Http\Controllers\CargoController@index')
                ->with('status', "Registrado com sucesso!");
        }
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
