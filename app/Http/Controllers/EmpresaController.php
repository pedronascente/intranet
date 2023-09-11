<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
    public function index()
    {
        return view(
            'settings.empresa.index',
            [
                'collection' => Empresa::orderBy('id', 'desc')->paginate(6),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    public function create()
    {
        if ($this->verificarPermissao('Criar')) {
            return view('settings.empresa.create');
        } else {
            return redirect()
                ->action('App\Http\Controllers\EmpresaController@index');
        }
    }

    public function store(Request $request)
    {
        $this->validarFormulario($request, 'store');
        if ($this->verificarDuplicidade($request)) {
            return redirect()
                ->action('App\Http\Controllers\EmpresaController@index')
                ->with('warning', "já existe uma empresa com este nome, ou cnpj!");
        }
        $empresa = new Empresa();
        $empresa->nome = $request->nome;
        $empresa->cnpj = $request->cnpj;
        $empresa->save();
        return redirect()
            ->action('App\Http\Controllers\EmpresaController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        $empresa = Empresa::find($id);
        return view('settings.empresa.show', ['empresa' => $empresa]);
    }

    public function edit($id)
    {
        if ($this->verificarPermissao('Editar')) {
            return view(
                'settings.empresa.edit',
                [
                    'empresa' => Empresa::findOrFail($id)
                ]
            );
        } else {
            return redirect()
                ->action('App\Http\Controllers\EmpresaController@index');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request, 'update');
        $empresa = Empresa::findOrFail($id);
        $empresa->nome = $request->nome;
        $empresa->cnpj = $request->cnpj;
        $empresa->update();
        return redirect()
            ->action('App\Http\Controllers\EmpresaController@index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy(Request $request, $id)
    {
        $empresa = Empresa::with('colaboradores')->findOrFail($request->id);
        if ($empresa->colaboradores->count() >= 1) {
            return redirect()
                ->action('App\Http\Controllers\EmpresaController@index')
                ->with('warning', "Esta empresa tem colaborador associado, por tanto não pode ser excluida.");
        }
        $empresa->delete();
        return redirect()
            ->action('App\Http\Controllers\EmpresaController@index')
            ->with('status', "Registro Excluido!");
    }

    private function validarFormulario(Request $request, $method)
    {
        switch ($method) {
            case 'update':
                $nome = 'required|max:190|min:5';
                $cnpj = 'required|max:20|min:5';
                break;
            case 'store':
                $nome = 'required|max:190|min:5|unique:empresas,nome';
                $cnpj = 'required|max:20|unique:empresas,cnpj';
                break;
        }
        $request->validate(
            [
                'nome' => $nome,
                'cnpj' => $cnpj,
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'cnpj.required' => 'Campo obrigatório.',
                'nome.unique' => 'Esta empresa já está sendo utilizado.',
                'cnpj.unique' => 'Esta cnpj já está sendo utilizado.',
            ]
        );
    }

    private function verificarDuplicidade(Request $request)
    {
        $duplicado = Empresa::where('nome', $request->nome)
            ->orWhere('cnpj', $request->cnpj)
            ->get()->count();
        return $duplicado;
    }

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][3]) ? session()->get('perfil')['permissoes'][3]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }

    private function verificarPermissao($permissao)
    {
        $modulo = 3;
        $ArrayLystPermissoes = [];
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'] as $item) {
                foreach ($item as  $value) {
                    if ($value->modulo_id == $modulo) {
                        $ArrayLystPermissoes[] = $value->nome;
                    };
                }
            }
        }
        if (in_array($permissao, $ArrayLystPermissoes)) {
            return true;
        } else {
            return false;
        }
    }
}
