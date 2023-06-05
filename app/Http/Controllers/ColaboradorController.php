<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colaborador;
use App\Models\Empresa;
use App\Models\Cargo;

class ColaboradorController extends Controller
{
    public function index()
    {
        $collection = Colaborador::orderBy('id', 'desc')->paginate(6);
        return view('colaborador.index', ['collection' => $collection]);
    }

    public function create()
    {
        $empresas = Empresa::orderBy('id', 'desc')->get();
        $cargos = Cargo::orderBy('id', 'desc')->get();
        return view('colaborador.create', [
            'empresas' => $empresas,
            'cargos' => $cargos,
        ]);
    }

    public function store(Request $request)
    {
        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {
            $c = new Colaborador();
            $c->nome = $request->nome;
            $c->sobrenome = $request->sobrenome;
            $c->email = $request->email;
            $c->rg = $request->rg;
            $c->cpf = $request->cpf;
            $c->cnpj = $request->cnpj;
            $c->cargo_id = $request->cargo_id;
            $c->empresa_id = $request->empresa_id;
            $c->save();

            return redirect()
                ->action('App\Http\Controllers\ColaboradorController@index')
                ->with('status', "Registrado com sucesso!");
        }
    }

    public function show($id)
    {
        $c = Colaborador::findOrFail($id);
        return view('colaborador.show', ['colaborador' => $c]);
    }

    public function edit($id)
    {
        $colaboraodor = Colaborador::findOrFail($id);
        $empresas = Empresa::orderBy('id', 'desc')->get();
        $cargos = Cargo::orderBy('id', 'desc')->get();

        return view('colaborador.edit', [
            'colaborador' => $colaboraodor,
            'empresas' => $empresas,
            'cargos' => $cargos,
        ]);
    }

    public function update(Request $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->nome = $request->nome;
        $colaborador->sobrenome = $request->sobrenome;
        $colaborador->email = $request->email;
        $colaborador->rg = $request->rg;
        $colaborador->cpf = $request->cpf;
        $colaborador->cnpj = $request->cnpj;
        $colaborador->cargo_id = $request->cargo_id;
        $colaborador->empresa_id = $request->empresa_id;
        $colaborador->update();
        return redirect('colaborador')->with('status', 'Registro Atualizado!'); //retorna resultado.
    }

    public function destroy($id)
    {
        //
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:191|min:5',
                'sobrenome' => 'required|max:191|min:5',
                'email' => 'required|email',
                'rg' => 'required|max:15',
                'cpf' => 'required|max:14',
                'empresa_id' => 'required',
                'cargo_id' => 'required',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'sobrenome.required' => 'Campo obrigatório.',
                'email.required' => 'Digite um e-mail válido',
                'rg.required' => 'Campo obrigatório.',
                'cpf.required' => 'Campo obrigatório.',
                'empresa_id.required' => 'Campo obrigatório.',
                'cargo_id.required' => 'Campo obrigatório.',
            ]
        );
    }
}
