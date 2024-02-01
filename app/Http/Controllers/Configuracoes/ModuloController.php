<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Modulo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Models\ModuloCategoria;
use App\Models\ModuloPosicao;

class ModuloController extends Controller
{
    /**
     * Instância da Modulo
     *
     * @var Modulo
     */
    private $modulo;

    public function __construct(Modulo $modulo)
    {
        $this->modulo = $modulo;
    }

    public function index()
    {
        return view('configuracoes.modulo.index', [
            'collection' => $this->modulo->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    public function create()
    {
        $ModuloPosicao   = ModuloPosicao::all();    
        $ModuloCategoria = ModuloCategoria::all();    
        return view('configuracoes.modulo.create',[
            'titulo'            => 'Cadastrar Módulo',
            'modulo_posicoes'   => $ModuloPosicao,
            'modulo_categorias' => $ModuloCategoria
        ]);
    }

    public function store(Request $request)
    {        
        $request->validate($this->modulo->rules(), $this->modulo->feedback());
        $modulo = $this->modulo;
        $this->preencheModulo($modulo, $request);
        $modulo->save();
        return redirect()
            ->route('modulo.index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $Modulo          = Modulo::with('categoria','posicao')->findOrFail($id);
        $ModuloPosicao   = ModuloPosicao::all();
        $ModuloCategoria = ModuloCategoria::all();   
       
        return view('configuracoes.modulo.edit', [
            'titulo'            => 'Editar Módulo',
            'modulo'            => $Modulo,
            'modulo_posicoes'   => $ModuloPosicao,
            'modulo_categorias' => $ModuloCategoria
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->modulo->rules(), $this->modulo->feedback());
        $modulo = $this->modulo->findOrFail($id);
        $this->preencheModulo($modulo, $request);
        $modulo->update();
        return redirect()
            ->route('modulo.index')
            ->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        $modulo = $this->modulo->with('perfis')->findOrFail($id);
        if ($modulo->perfis->count() >= 1) {
            return redirect()
                ->route('modulo.index')
                ->with('warning', "Este Módulo está relacionada a um perfil, Não pode ser excluida.");
        } else {
            $modulo->delete();
            return redirect()
                ->route('modulo.index')
                ->with('status', "Registro Excluido!");
        }
    }

    public function show($id)
    {
        return redirect()
            ->route('modulo.index');
    }

    private function preencheModulo($modulo,$request){
        $modulo->nome                = $request->nome;
        $modulo->modulo_categoria_id = $request->modulo_categoria_id;
        $modulo->modulo_posicao_id   = $request->modulo_posicao_id;
        $modulo->rota                = $request->rota;
        $modulo->slug                = CaniveteHelp::generateSlug($request->nome);
        $modulo->descricao           = $request->descricao;
    }
}
