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

    private $arrayListPermissoesDoModuloDaRota;

    public function __construct(Modulo $modulo)
    {
        $this->modulo = $modulo;
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index()
    {  
        $titulo ="Listar Módulos";
        $arrayListModulo = $this->modulo->orderBy('id', 'desc')->paginate(10); 
        return view('modulo.index', [
            'titulo' => $titulo,
            'arrayListModulo' => $arrayListModulo,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create()
    {
        if (in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Cadastrar Módulo";
            $ModuloPosicao = ModuloPosicao::all();
            $ModuloCategoria = ModuloCategoria::all();
            return view('modulo.create', [
                'titulo' => $titulo,
                'modulo_posicoes' => $ModuloPosicao,
                'modulo_categorias' => $ModuloCategoria
            ]);
        } else {
            return redirect()->route('modulo.index')->with('error', "Você não Tem Permissão de Cadastro.");
        } 
    }

    public function store(Request $request)
    {        
        $request->validate($this->modulo->rules(), $this->modulo->feedback());
        $modulo = $this->modulo;
        $this->preencheModulo($modulo, $request);
        $modulo->save();
        return redirect()->route('modulo.index')->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Editar Módulo";
            $Modulo = Modulo::with('categoria', 'posicao')->findOrFail($id);
            $ModuloPosicao = ModuloPosicao::all();
            $ModuloCategoria = ModuloCategoria::all();
            return view('modulo.edit', [
                'titulo' => $titulo,
                'modulo' => $Modulo,
                'modulo_posicoes' => $ModuloPosicao,
                'modulo_categorias' => $ModuloCategoria
            ]);
        } else {
            return redirect()->route('modulo.index')->with('error', "Você não Tem Permissão de Edição.");
        }    
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->modulo->rules(), $this->modulo->feedback());
        $modulo = $this->modulo->findOrFail($id);
        $this->preencheModulo($modulo, $request);
        $modulo->update();
        return redirect()->route('modulo.index')->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        if (in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
            $modulo = $this->modulo->with('perfis')->findOrFail($id);
            if ($modulo->perfis->count() >= 1) {
                return redirect()->route('modulo.index')->with('warning', "Este Módulo está relacionada a um perfil, Não pode ser excluida.");
            } else {
                $modulo->delete();
                return redirect()->route('modulo.index')->with('status', "Registro Excluido!");
            }
        } else {
            return redirect()->route('modulo.index')->with('error', "Você não Tem Permissão de Excluir.");
        }    
    }

    public function show($id)
    {
        return redirect()->route('modulo.index');
    }

    private function preencheModulo($modulo,$request){
        $modulo->nome = $request->nome;
        $modulo->modulo_categoria_id = $request->modulo_categoria_id;
        $modulo->modulo_posicao_id = $request->modulo_posicao_id;
        $modulo->rota = $request->rota;
        $modulo->slug = CaniveteHelp::generateSlug($request->nome);
        $modulo->descricao = $request->descricao;
    }
}
