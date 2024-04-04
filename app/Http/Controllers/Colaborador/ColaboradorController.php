<?php

namespace App\Http\Controllers\Colaborador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Colaborador\Colaborador;

class ColaboradorController extends Controller
{
    /**
     * Instância de Colaborador
     *
     * @var Colaborador
     */
    private $colaborador;
 
    private $path;
    
    private $arrayListPermissoesDoModuloDaRota;

    public function __construct(Colaborador $colaborador)
    {
        $this->colaborador = $colaborador;
        $this->path = 'img/colaborador/';
       
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $arrayListDeColaboradores = $this->colaborador->getColaborador($request->filtro);
        return view('colaborador.index', [
            'titulo' => "Listar Colaboradores",
            'arrayListDeColaboradores' => $arrayListDeColaboradores,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota
        ]);
    }

    public function create()
    {
        $this->ValidarPermissoesDoModuloDaRota('Criar');
        return view('colaborador.create', [
            'titulo' => "Cadastrar Colaborador",
            'bases' =>  $this->colaborador->newObjetoBase()->getBaseOrderByIdDesc(),
            'empresas' => $this->colaborador->newObjetoEmpresa()->getEmpresaOrderByIdDesc(),
            'cargos' =>  $this->colaborador->newObjetoCargo()->getCargoOrderByIdDesc(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->colaborador->rules($request), $this->colaborador->feedback());
        $colaborador = $this->colaborador;
        $this->preencherAtributosDoObjeto($request, $colaborador);
        return redirect()->route('colaborador.index')->with('status', "Registrado com sucesso!");
    }

    public function show($id)
    {
        $this->ValidarPermissoesDoModuloDaRota('Visualizar');
        $titulo = "Visualizar Colaborador";
        return view('colaborador.show', [
            'titulo' => $titulo,
            'colaborador' => $this->colaborador->findOrFail($id),
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota
        ]);
    }

    public function edit($id)
    {
        $this->ValidarPermissoesDoModuloDaRota('Editar');
        return view('colaborador.edit', [
            'titulo' => "Editar Colaborador",
            'colaborador' => $this->colaborador->findOrFail($id),
            'empresas' => $this->colaborador->newObjetoEmpresa()->getEmpresaOrderByIdDesc(),
            'cargos' => $this->colaborador->newObjetoCargo()->getCargoOrderByIdDesc(),
            'bases' =>  $this->colaborador->newObjetoBase()->getBaseOrderByIdDesc(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $colaborador = $this->colaborador->with('cargo', 'empresa')->findOrFail($id);
        $request->validate($this->colaborador->rules($request, $colaborador), $this->colaborador->feedback());
        $this->preencherAtributosDoObjeto($request, $colaborador);
        return redirect()->route('colaborador.show', $colaborador->id)->with('status', "Registro Atualizado!");
    }

    public function destroy($id)
    {
        $this->ValidarPermissoesDoModuloDaRota('Excluir');
        $colaborador = $this->colaborador->with('usuario')->find($id);
        if (!$colaborador) {
            return redirect()->route('colaborador.index')
            ->with('error', "Colaborador não encontrado.");
        }
        if ($colaborador->usuario) {
            return redirect()->route('colaborador.show', $id)->with('warning', "Este colaborador tem Usuário associado, portanto não pode ser excluído.");
        }
        $this->deleteColaborador($colaborador);
        return redirect()->route('colaborador.index')->with('status', "Registro Excluído!");
    }

    public function createPesquisar()
    {
        return view('colaborador.pesquisar.create',[
         'titulo' => "Pesquisar Colaborador",
        ]);
    }

    public function showPesquisar(Request $request)
    {
        $filtro = $request->input('filtro');
        if ($filtro) {
            $colaboradores = $this->colaborador->where('nome', 'like', '%' . $filtro . '%')->get();
        }else{
            $colaboradores = $this->colaborador->all();
        }
        return view('colaborador.pesquisar.resultado',[
            'titulo' => "Pesquisar Colaborador",
            'colaboradores' => $colaboradores
        ]);
    }

    private function deleteColaborador($colaborador)
    {
        $destino = $this->path . $colaborador->foto;
        if ($colaborador->foto != 'dummy-round.png' && $this->colaborador->newUploadImagem()->exists($destino)) {
            $this->colaborador->newUploadImagem()->delete($destino);
        }
        $colaborador->delete();
    }

    private function preencherAtributosDoObjeto(Request $request, $colaborador)
    {
        $colaborador->nome = $request->nome;
        $colaborador->email = $request->email;
        $colaborador->rg = $request->rg;
        $colaborador->cpf = $request->cpf;
        $colaborador->cnpj = $request->cnpj;
        $colaborador->ramal = $request->ramal;
        $colaborador->numero_matricula = $request->numero_matricula;
        $colaborador->base()->associate($this->colaborador->newObjetoBase()->findOrFail($request->base_id));
        $colaborador->empresa()->associate($this->colaborador->newObjetoEmpresa()->findOrFail($request->empresa_id));
        $colaborador->cargo()->associate($this->colaborador->newObjetoCargo()->findOrFail($request->cargo_id));
    
        if ($request->hasFile('foto')) {
            $destino = $this->path . $colaborador->foto;
            if ($colaborador->foto != 'dummy-round.png' && $this->colaborador->newUploadImagem()->exists($destino)) {
                $this->colaborador->newUploadImagem()->delete($destino);
            }
            $colaborador->foto = $this->colaborador->newUploadImagem()->upload($request, $this->path);
        }
        $colaborador->save();
    }

    private function ValidarPermissoesDoModuloDaRota($permissao)
    {
        switch ($permissao) {
            case 'Criar':
                if (!in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
                    return redirect()->route('base.index')->with('error', "Você não tem permissão de cadastro.");
                }
                break;
            case 'Visualizar':
                if (!in_array('Visualizar', $this->arrayListPermissoesDoModuloDaRota)) {
                    return redirect()->route('base.index')->with('error', "Você não tem permissão de Visualização.");
                }
            case 'Editar':
                if (!in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
                    return redirect()->route('base.index')->with('error', "Você não tem permissão de edição.");
                }
                break;
            case 'Excluir':
                if (!in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
                    return redirect()->route('base.index')->with('error', "Você não tem permissão de excluir.");
                }
                break;
        }
        return true;
    }
}