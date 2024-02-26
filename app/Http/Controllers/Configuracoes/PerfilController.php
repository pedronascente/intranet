<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Modulo;

use App\Models\Perfil;
use App\Models\Permissao;
use App\Models\ModuloPerfil;
use Illuminate\Http\Request;
use App\Models\ModuloCategoria;
use App\Models\ModuloPermissao;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    private $perfil;
    private $arrayListPermissoesDoModuloDaRota;
    
    public function __construct(Perfil $perfil)
    {
        $this->perfil = $perfil;
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index()
    {
        $titulo = 'Perfil';
        $arrayListPerfil = $this->perfil->orderBy('id', 'desc')->paginate(10);
        return view('perfil.index', [
            'titulo' => $titulo,
            'arrayListPerfil' => $arrayListPerfil,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create()
    {
        if (in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo =  "Cadastrar Perfil";
            $ModuloCategoria = ModuloCategoria::with('modulos')->get();
            $Permissao = Permissao::all();
            return view('perfil.create', [
                'titulo' => $titulo,
                'listarCategoriasEseusModulos' => $ModuloCategoria,
                'listarPermissoes' => $Permissao
            ]);
        } else {
            return redirect()->route('perfil.index')->with('error', "Você não Tem Permissão de Cadastro.");
        }         
    }

    public function store(Request $request)
    {
        $this->validarRequisitos($request);
        $perfil = $this->perfil->create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);
        // Associando os módulos selecionados ao perfil
        if ($request->ArrayListModulos) {
            foreach ($request->ArrayListModulos as $moduloId) {
                $modulo = Modulo::find($moduloId);
                if ($modulo) {
                    // Criando a relação entre o módulo e o perfil.
                    ModuloPerfil::create([
                        'perfil_id' => $perfil->id,
                        'modulo_id' => $moduloId,
                    ]);
                    // Associando as permissões selecionadas à relação entre módulo e perfil
                    if ($request->ArrayListPermissoes && isset($request->ArrayListPermissoes[$moduloId])) {
                        $permissoes = Permissao::find($request->ArrayListPermissoes[$moduloId]);
                        if ($permissoes) {
                            foreach ($permissoes as $permissaoId) {
                                // Criando a relação entre permissão e a relação entre módulo e perfil
                                ModuloPermissao::create([
                                    'perfil_id' => $perfil->id,
                                    'modulo_id' => $moduloId,
                                    'permissao_id' => $permissaoId->id,
                                ]);
                            }
                        }
                    }        
                }
            }
        }
        return redirect()->route('perfil.index')->with('status', "Perfil registrado com sucesso.");
    }

    public function edit($id)
    {
        if (!in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
            return redirect()->route('perfil.index')->with('error', "Você não Tem Permissão de Edição.");
        }

        //1 Definir titulo da pagina.
        $titulo = "Editar Perfil";
        $perfil = Perfil::with('modulos')->findOrFail($id);
        $arraylistCategoriasEseusModulos = ModuloCategoria::with('modulos')->get();
        $arrayListModulosAssociados = $perfil->modulos->pluck('id')->toArray();
        $arrayListPermissoes = Permissao::all();

        $debug = false;
        if($debug){
            foreach ($arraylistCategoriasEseusModulos as $categoria) {
                echo  "<B>" . $categoria->nome . '</B> (Categoria)<br><br>';
                foreach ($categoria->modulos as $modulo) {
                    echo  "<br><b>" . $modulo->nome . '</b> (Modulo)<br><br>';
                    foreach ($arrayListPermissoes as $permissao) {
                        $permissoesDoModulo = $perfil->getPermissao($modulo->id, $perfil->id)->pluck('id')->toArray();  
                        echo    '<input type="checkbox" name="ArrayListPermissoes[$modulo->id][]" class="custom-control-input"';
                        if (in_array($permissao->id, $permissoesDoModulo)) {
                            echo 'checked';
                        }
                        echo '>  - ' . $permissao->nome  . '<br>';
                    }
                }
                echo '<hr>';
            }
            var_dump([
                '$permissoesDoModulo'=> $permissoesDoModulo
            ]);
        }else{
            return view('perfil.edit', [
                'titulo' => $titulo,
                'perfil' => $perfil,
                'arraylistCategoriasEseusModulos' => $arraylistCategoriasEseusModulos,
                'arrayListModulosAssociados' => $arrayListModulosAssociados,
                'arrayListPermissoes' => $arrayListPermissoes,
            ]);
        }
    }

    public function update(Request $request, $id)
    {

       // dd($request->all(), $id);
        // Validar os dados da requisição
        $request->validate([
            'nome' => 'required|max:190',
            'descricao' => 'required|max:255',
        ]);
        // Buscar o perfil pelo ID
        $perfil = $this->perfil->findOrFail($id);
        // Atualizar os dados do perfil
        $perfil->update(['nome' => $request->nome,'descricao' => $request->descricao,]);
        // Remover as associações existentes de módulos e permissões
        $perfil->modulos()->detach();
        $perfil->permissoes()->detach();
        // Associar os módulos selecionados ao perfil
        if ($request->ArrayListModulos) {
            $perfil->modulos()->attach($request->ArrayListModulos);
        }
        // Associar as permissões selecionadas aos módulos associados ao perfil
        if ($request->ArrayListModulos && $request->ArrayListPermissoes) {
            foreach ($request->ArrayListPermissoes as $moduloId => $permissoes) {
                if(in_array($moduloId, $request->ArrayListModulos)){
                    $perfil->permissoes()->attach($permissoes, ['modulo_id' => $moduloId]);
                }
            }
        }
        return redirect()->back()->with('status', "Registro atualizado com sucesso!");
    }

    public function destroy($id)
    {
        if (in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
            $perfil = $this->perfil->with('user')->findOrFail($id);
            if ($perfil->user) {
                return redirect()->route('perfil.index')->with('warning', "Este Perfil tem usuario(s) associado(s), por tanto não pode ser excluida.");
            } else {
                $perfil->delete();
                return redirect()->route('perfil.index')->with('status', "Registro Excluido!");
            }
        } else {
            return redirect()->route('perfil.index')->with('error', "Você não Tem Permissão de Excluir.");
        }       
    }

    private function validarRequisitos($request){
        $request->validate($this->perfil->rules(), $this->perfil->feedback());
        if ($this->perfil->validarPerfilDuplicado($request->nome)) {
            return redirect()->back()->with('warning', "Já existe um Perfil com este nome");
        }
        if (!$request->ArrayListModulos) {
            return redirect()->back()->with('error', "Selecione pelo menos um modulo, e uma permissão para continuar.");
        }
    }

    public function show($id)
    {
        return redirect()->route('perfil.index');
    }
}