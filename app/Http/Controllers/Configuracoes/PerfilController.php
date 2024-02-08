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
    
    public function __construct(Perfil $perfil)
    {
        $this->perfil = $perfil;
    }

    public function index()
    {
        return view('configuracoes.perfil.index', [
            'listarPerfis' => $this->perfil->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    public function create()
    {
        $ModuloCategoria = ModuloCategoria::with('modulos')->get();
        $Permissao       = Permissao::all();
        return view('configuracoes.perfil.create', [
            'listarCategoriasEseusModulos' => $ModuloCategoria, 
            'listarPermissoes'             => $Permissao
        ]);
    }

    public function store(Request $request)
    {
        $this->validarRequisitos($request);

        // Criando o perfil
        $perfil = $this->perfil->create([
            'nome'       => $request->nome,
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
                                    'perfil_id'    => $perfil->id,
                                    'modulo_id'    => $moduloId,
                                    'permissao_id' => $permissaoId->id,
                                ]);
                            }
                        }
                    }        
                }
            }
        }

        return redirect()
        ->route('perfil.index')
        ->with('status', "Perfil registrado com sucesso.");
    }

    public function edit($id)
    {
        // Obter o perfil com seus módulos associados e suas permissões específicas
        $perfil = Perfil::with(['modulos.permissoes' => function ($query) use ($id) {
            $query->whereHas('modulos_associados', function ($q) use ($id) {
                $q->where('perfil_id', $id);
            });
        }])->findOrFail($id);

        $listarModulosAssociados = $perfil->modulos->pluck('id')->toArray();
        // Obter todas as categorias de módulos com seus módulos associados
        $moduloCategorias = ModuloCategoria::with('modulos')->get();
        $Permissao = Permissao::all();

        // Retorna a view com os dados necessários
        return view('configuracoes.perfil.edit', [
            'perfil'                       => $perfil,
            'listarCategoriasEseusModulos' => $moduloCategorias,
            'listarPermissoes'             => $Permissao,
            'listarModulosAssociados'      => $listarModulosAssociados,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validar os dados da requisição
        $request->validate([
            'nome' => 'required|max:190',
            'descricao' => 'required|max:255',
        ]);

        // Buscar o perfil pelo ID
        $perfil = $this->perfil->findOrFail($id);

        // Atualizar os dados do perfil
        $perfil->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
        ]);
        // Remover as associações existentes de módulos e permissões
        $perfil->modulos()->detach();
        $perfil->permissoes()->detach();

        // Associar os módulos selecionados ao perfil
        if ($request->ArrayListModulos) {
           
            $perfil->modulos()->attach($request->ArrayListModulos);
        }

        // Associar as permissões selecionadas aos módulos associados ao perfil
        if ($request->ArrayListModulos && $request->ArrayListPermissoes) {
           //    dd($request->ArrayListPermissoes);
            foreach ($request->ArrayListPermissoes as $moduloId => $permissoes) {
                if(in_array($moduloId, $request->ArrayListModulos)){
                    $perfil->permissoes()->attach($permissoes, ['modulo_id' => $moduloId]);
                }
                
            }
        }

        // Redirecionar de volta para a página de edição com uma mensagem de sucesso
        return redirect()
            ->route('perfil.edit', $id)
            ->with('status', "Registro atualizado com sucesso!");
    }


    public function destroy($id)
    {
        $perfil = $this->perfil->with('user')->findOrFail($id);
        if ($perfil->user) {
            return redirect()
                ->route('perfil.index')
                ->with('warning', "Este Perfil tem usuario(s) associado(s), por tanto não pode ser excluida.");
        } else {
            $perfil->delete();
            return redirect()
                ->route('perfil.index')
                ->with('status', "Registro Excluido!");
        }
    }

    public function show($id)
    {
        return redirect()
            ->route('perfil.index');
    }

    private function validarRequisitos($request){
        $request->validate($this->perfil->rules(), $this->perfil->feedback());
        
        if ($this->perfil->validarPerfilDuplicado($request->nome)) {
            return redirect()
                ->back()
                ->with('warning', "Já existe um Perfil com este nome");
        }
        if (!$request->ArrayListModulos) {
            return redirect()
                ->back()
                ->with('error', "Selecione pelo menos um modulo, e uma permissão para continuar.");
        }
    }
}