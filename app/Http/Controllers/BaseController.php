<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;

class BaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'settings.base.index',
            [
                'collection' => Base::orderBy('id', 'desc')->paginate(10),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'][9] as $item) {
                if ($item->nome == 'Criar') {
                    return view('settings.base.create');
                    break;
                }
            }
        }
        return redirect()
            ->action('App\Http\Controllers\CargoController@index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validarFormulario($request);
        $base = new Base();
        $base->nome = $request->nome;
        $base->save();
        return redirect()
            ->action('App\Http\Controllers\BaseController@index')
            ->with('status', "Registrado com sucesso!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'][9] as $item) {
                if ($item->nome == 'Editar') {
                    $base = Base::findOrFail($id);
                    if ($base) {
                        return view(
                            'settings.base.edit',
                            [
                                'base' => $base
                            ]
                        );
                    } else {
                        return redirect('base/')->with('error', 'Registro não existe!'); //retorna resultado.
                    }
                    break;
                }
            }
        }
        return redirect()
            ->action('App\Http\Controllers\BaseController@index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validarFormulario($request);
        $base = Base::findOrFail($id);
        $base->nome = $request->nome;
        $base->update();
        return redirect()
            ->action('App\Http\Controllers\BaseController@index')
            ->with('status', "Registro Atualizado!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $base = Base::with('colaboradores')->findOrFail($request->id);
        if ($base) {
            if ($base->colaboradores->count() >= 1) {
                return redirect()
                    ->action('App\Http\Controllers\BaseController@index')
                    ->with('warning', "Esta Base está sendo utilizada, por tanto não pode ser excluida.");
            }
            $base->delete();
            return redirect()
                ->action('App\Http\Controllers\BaseController@index')
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
                'nome' => 'required|max:190|min:2|unique:bases,nome',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'nome.unique' => 'Este nome já está sendo utilizado.',
            ]
        );
    }

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][9]) ? session()->get('perfil')['permissoes'][1]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }
}
