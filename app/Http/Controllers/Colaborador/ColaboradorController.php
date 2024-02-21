<?php

namespace App\Http\Controllers\Colaborador;

use App\Models\Colaborador\Base;
use App\Models\Colaborador\Cargo;
use App\Models\Colaborador\Empresa;
use App\Models\Colaborador\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Help\CaniveteHelp;

class ColaboradorController extends Controller
{
    /**
     * Instância de Colaborador
     *
     * @var Colaborador
     */
    private $colaborador;

    /**
     * Instância de Base
     *
     * @var Base
     */
    private $bases;

    /**
     * Instância de Empresa
     *
     * @var Empresa
     */
    private $empresas;

    /**
     * Instância de Cargo
     *
     * @var Cargo
     */
    private $cargos;
 
    private $path;

    private $arrayListPermissoesDoModuloDaRota;

    public function __construct(Colaborador $colaborador)
    {
        $this->colaborador = $colaborador;
        $this->bases = Base::orderBy('id', 'desc')->get();
        $this->empresas = Empresa::orderBy('id', 'desc')->get();
        $this->cargos = Cargo::orderBy('id', 'desc')->get();
        $this->path = 'img/colaborador/';

        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index()
    {
        $titulo = "Lista dos Colaboradores";
        $arrayListDeColaboradores = $this->colaborador->with('usuario')->orderBy('id', 'desc')->paginate(10);
        return view('colaborador.index', [
            'titulo' => $titulo,
            'arrayListDeColaboradores' => $arrayListDeColaboradores,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota
        ]);
    }

    public function create()
    {
        if (in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            return view('colaborador.create', [
                'titulo' => "Cadastrar Colaborador",
                'bases' => $this->bases,
                'empresas' => $this->empresas,
                'cargos' => $this->cargos,
            ]);
        } else {
            return redirect()->route('colaborador.index')->with('error', "Você não Tem Permissão de Cadastro.");
        }       
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
        if (in_array('Visualizar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Visualizar Colaborador";
            return view('colaborador.show', [
                'titulo' => $titulo,
                'colaborador' => $this->colaborador->findOrFail($id),
                'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota
            ]);
        } else {
            return redirect()->route('colaborador.index')->with('error', "Você não Tem Permissão de Visualizar.");
        }
    }

    public function edit($id)
    {
        if(in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)){
            return view('colaborador.edit', [
                'titulo' => "Editar Colaborador",
                'colaborador' => $this->colaborador->findOrFail($id),
                'empresas' => $this->empresas,
                'cargos' => $this->cargos,
                'bases' => $this->bases,
            ]);
        }else{
            return redirect()->route('colaborador.index')->with('error', "Você não Tem Permissão de Edição.");
        }
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
        if (in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
            $colaborador = $this->colaborador->with('usuario')->find($id);
            if (!$colaborador) {
                return redirect()->route('colaborador.index')
                ->with('error', "Colaborador não encontrado.");
            }
            if ($colaborador->usuario) {
                return redirect()->route('colaborador.show', $id)->with('warning', "Este colaborador tem Usuário associado, portanto não pode ser excluído.");
            }
            $this->deleteColaborador($colaborador);
            return redirect()->route('colaborador.index')
            ->with('status', "Registro Excluído!");
        } else {
            return redirect()
                ->route('colaborador.index') ->with('error', "Você não Tem Permissão de Excluir.");
        }
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
        if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
            File::delete($destino);
        }
        $colaborador->delete();
    }

    private function preencherAtributosDoObjeto(Request $request, $colaborador)
    {
        $colaborador->nome = $request->nome;
        $colaborador->sobrenome = $request->sobrenome;
        $colaborador->email = $request->email;
        $colaborador->rg = $request->rg;
        $colaborador->cpf = $request->cpf;
        $colaborador->cnpj = $request->cnpj;
        $colaborador->ramal = $request->ramal;
        $colaborador->numero_matricula = $request->numero_matricula;
        $colaborador->base()->associate(Base::findOrFail($request->base_id));
        $colaborador->empresa()->associate(Empresa::findOrFail($request->empresa_id));
        $colaborador->cargo()->associate(Cargo::findOrFail($request->cargo_id));
    
        $CaniveteHelp = new CaniveteHelp();
    
        if ($request->hasFile('foto')) {
            $destino = $this->path . $colaborador->foto;
            if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
                File::delete($destino);
            }
            $colaborador->foto = $CaniveteHelp->upload($request, $this->path);
        }else{
            if ($foto = $CaniveteHelp->upload($request, $this->path)) {
                $colaborador->foto = $foto;
            } else {
                $colaborador->foto = 'dummy-round.png';
            }
        }
        $colaborador->save();
    }
}