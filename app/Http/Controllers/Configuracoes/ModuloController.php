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

    /**
     * Instância da ModuloPosicao
     *
     * @var ModuloPosicao
     */
    private $posicao;
    
    /**
     * Instância da ModuloPosicao
     *
     * @var ModuloCategoria
     */
    private $categoria;

    public function __construct(Modulo $modulo)
    {
        $this->modulo = $modulo;
    }

    public function index(Request $request)
    {  
        return view('modulo.index', [
            'titulo' => "Listar Módulos",
            'arrayListModulo' => $this->modulo->getModulo($request->filtro),
        ]);
    }

    public function create()
    {
        if (!$this->validarpermissao('Criar')) {
            return redirect()->back();
        }
        return view('modulo.create', [
            'titulo' => "Cadastrar Módulo",
            'modulo_posicoes' => $this->getPosicao(),
            'modulo_categorias' => $this->getCategoria()
        ]);
    }

    public function store(Request $request)
    {
        $this->modulo->validarFormulario($request);
        $modulo = $this->modulo;
        $this->preencheModulo($modulo, $request);
        $modulo->save();
        return redirect()->route('modulo.index')->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (!$this->validarpermissao('Editar')) {
            return redirect()->back();
        }
        return view('modulo.edit', [
            'titulo' => "Editar Módulo",
            'modulo' => $this->modulo->with('categoria', 'posicao')->findOrFail($id),
            'modulo_posicoes' => $this->getPosicao(),
            'modulo_categorias' => $this->getCategoria()
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->modulo->validarFormulario($request);
        $modulo = $this->modulo->findOrFail($id);
        $this->preencheModulo($modulo, $request);
        $modulo->update();
        return redirect()->route('modulo.index')->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        if (!$this->validarpermissao('Excluir')) {
            return redirect()->back();
        }
        $modulo = $this->modulo->with('perfis')->findOrFail($id);
        if ($modulo->perfis->count() >= 1) {
            return redirect()->route('modulo.index')->with('warning', "Este Módulo está relacionada a um perfil, Não pode ser excluida.");
        } else {
            $modulo->delete();
            return redirect()->route('modulo.index')->with('status', "Registro Excluido!");
        }
    }

    public function show($id)
    {
        return redirect()->route('modulo.index');
    }

    private function preencheModulo($modulo,$request)
    {
        if($request->nova_categoria){
            $categoria_id = $this->cadastrarCategoria(new ModuloCategoria(), $request); 
        }else{
            $categoria_id = $request->modulo_categoria_id;
        }
        $modulo->nome = $request->nome;
        $modulo->modulo_categoria_id = $categoria_id;
        $modulo->modulo_posicao_id = $request->modulo_posicao_id;
        $modulo->rota = $request->rota;
        $modulo->slug = $this->gerarSlug($request->nome);
        $modulo->descricao = $request->descricao;
    }

    private function gerarSlug($parmetro)
    {
         return  CaniveteHelp::generateSlug($parmetro);
    }

    private function getPosicao()
    {
        return $this->posicao = ModuloPosicao::all();
    }

    private function getCategoria()
    {
        return $this->categoria =  ModuloCategoria::all();
    }

    private function  cadastrarCategoria($categoria,$request){
        $inser_categoria = $categoria;
        $inser_categoria->nome = $request->nova_categoria;
        $inser_categoria->save();
        return  $inser_categoria->id;
    }
}