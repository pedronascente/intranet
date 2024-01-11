<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class BaseController extends Controller
{
    private $modulo_id; //id do modulo
    private $base;
   
    public function __construct(Base $base)
    {
        $this->base      = $base; 
        $this->modulo_id = 9; 
    }

    public function index()
    {
        return view('configuracoes.base.index', [
            'collection' => $this->base->orderBy('id', 'desc')->paginate(10),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo_id),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao([
                'permissao' => 'Criar', 
                'modulo' => $this->modulo_id
            ])){
            return view('configuracoes.base.create');
        } else {
            return redirect()->route('base.index');
        }
    }

    public function store(Request $request)
    {
        $request->validate($this->base->rules('store'), $this->base->feedback());
        $base       = $this->base;
        $base->nome = $request->nome;
        $base->save();
        return redirect()
            ->route('base.index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao([
            'permissao' => 'Editar', 
            'modulo'    => $this->modulo_id
        ])) {
            return view('configuracoes.base.edit', [
                'base' => $this->base->findOrFail($id)
            ]);
        } else {
            return redirect()
                ->route('base.index');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->base->rules('update'), $this->base->feedback());

        $base       = $this->base->findOrFail($id);
        $base->nome = $request->nome;
        $base->update();
        
        return redirect()
            ->route('base.index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        $base = $this->base->with('colaboradores')->findOrFail($id);
        if ($base) {
            if ($base->colaboradores->count() >= 1) {
                return redirect()
                    ->route('base.index')
                    ->with('warning', "Esta Base está sendo utilizada, por tanto não pode ser excluida.");
            }
            $base->delete();
            
            return redirect()
                ->route('base.index')
                ->with('status', "Registro Excluido!");
        } else {
            return redirect()
                ->route('base.index')
                ->with('warning', "Registro não encontrado.");
        }
    }
}
