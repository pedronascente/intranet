<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        return view(
            'settings.cargo.index',
            [
                'collection' => Cargo::orderBy('id', 'desc')->paginate(10),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    public function create()
    {
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'][1] as $item) {
                if ($item->nome == 'Criar') {
                    return view('settings.cargo.create');
                    break;
                }
            }
        }
        return redirect()
            ->action('App\Http\Controllers\CargoController@index');
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
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'][1] as $item) {
                if ($item->nome == 'Editar') {
                    $cargo = Cargo::findOrFail($id);
                    if ($cargo) {
                        return view('settings.cargo.edit', ['cargo' => $cargo]);
                    } else {
                        return redirect('cargo/')->with('error', 'Registro não existe!'); //retorna resultado.
                    }
                    break;
                }
            }
        }
        return redirect()
            ->action('App\Http\Controllers\CargoController@index');
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request); //Válidar Formulário.
        $cargo = Cargo::findOrFail($id);
        $cargo->nome = $request->nome;
        $cargo->update();
        return redirect()
            ->action('App\Http\Controllers\CargoController@index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $c = Cargo::findOrFail($request->id);

        if ($c) {
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
        } else {
            return redirect()
                ->action('App\Http\Controllers\CargoController@index')
                ->with('warning', "Registro não encontrado.");
        }
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

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][1]) ? session()->get('perfil')['permissoes'][1]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }
}
