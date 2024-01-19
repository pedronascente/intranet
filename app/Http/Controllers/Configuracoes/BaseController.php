<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\PermissaoHelp;

class BaseController extends Controller
{
    /**
     * Instância da Base
     *
     * @var Base
     */
    private $base;
   
    public function __construct(Base $base)
    {
        $this->base = $base; 
    }

    public function index()
    {
        return view('configuracoes.base.index', [
            'collection' => $this->base->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    public function create()
    {
        return view('configuracoes.base.create');
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
        return view('configuracoes.base.edit', [
            'base' => $this->base->findOrFail($id)
        ]);
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
