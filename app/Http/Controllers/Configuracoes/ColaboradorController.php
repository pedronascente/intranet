<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Base;
use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

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
 
    /**
     * Construtor da classe.
     *
     * @param  Colaborador  $colaborador
     * @return void
     */
    public function __construct(Colaborador $colaborador)
    {
        $this->colaborador = $colaborador;
        $this->bases       = Base::orderBy('id', 'desc')->get();
        $this->empresas    = Empresa::orderBy('id', 'desc')->get();
        $this->cargos      = Cargo::orderBy('id', 'desc')->get();
    }

    /**
     * Exibe a lista de colaboradores.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('configuracoes.colaborador.index', [
            'titulo' => "Lista dos Colaboradores",
            'collection' => $this->colaborador->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Exibe o formulário de criação de colaborador.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return view('configuracoes.colaborador.create', [
            'titulo'    => "Cadastrar Colaborador",
            'bases'    => $this->bases,
            'empresas' => $this->empresas,
            'cargos'   => $this->cargos,
        ]);
    }

    /**
     * Armazena um novo colaborador no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->colaborador->rules($request), $this->colaborador->feedback());
        $colaborador = $this->colaborador;
        $this->preencheColaborador($request, $colaborador);
        if ($foto = $this->upload($request)) {
            $colaborador->foto = $foto;
        } else {
            $colaborador->foto = 'dummy-round.png';
        }
        $colaborador->save();
        return redirect()->route('colaborador.index')->with('status', "Registrado com sucesso!");
    }

    /**
     * Exibe os detalhes de um colaborador específico.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view('configuracoes.colaborador.show', [
            'titulo'      => "Visualizar Colaborador",
            'colaborador' => $this->colaborador->findOrFail($id)
        ]);
    }

    /**
     * Exibe o formulário de edição de um colaborador.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        return view('configuracoes.colaborador.edit', [
            'titulo'      => "Editar Colaborador",
            'colaborador' => $this->colaborador->findOrFail($id),
            'empresas'    => $this->empresas,
            'cargos'      => $this->cargos,
            'bases'       => $this->bases,
        ]);
    }

    /**
     * Exibe o formulário de edição de perfil de um colaborador.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function editarMeuPerfil($id)
    {
        return view('meu_perfil.edit', [
            'colaborador' => Colaborador::findOrFail($id),
            'empresas'    => $this->empresas,
            'cargos'      => $this->cargos,
            'bases'       => $this->bases,
        ]);
    }

    /**
     * Atualiza as informações de um colaborador no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $colaborador = $this->colaborador->with('cargo', 'empresa')->findOrFail($id);
        $request->validate($this->colaborador->rules($request, $colaborador), $this->colaborador->feedback());
        $this->preencheColaborador($request, $colaborador);
        if ($request->hasFile('foto')) {
            $destino = 'img/colaborador/' . $colaborador->foto;
            if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
                File::delete($destino);
            }
            $colaborador->foto = $this->upload($request);
        }
        $colaborador->update();
        if ($request->editProfile >= 1) {
            return redirect()
                ->route('user.meuPerfil')
                ->with('status', "Registro Atualizado!");
        } else {
            return redirect()->route('colaborador.show', $colaborador->id)
                            ->with('status', "Registro Atualizado!");
        }
    }

    /**
     * Remove um colaborador do banco de dados.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($id)
    {
        $colaborador = $this->colaborador->with('user')->find($id);

        if (!$colaborador) {
            return redirect()->route('colaborador.index')
                             ->with('error', "Colaborador não encontrado.");
        }

        if ($colaborador->user) {
            return redirect()->route('colaborador.show', $id)
                             ->with('warning', "Este colaborador tem Usuário associado, portanto não pode ser excluído.");
        }

        $this->deleteColaborador($colaborador);

        return redirect()->route('colaborador.index')
                        ->with('status', "Registro Excluído!");
    }

    public function createPesquisar()
    {
        return view('configuracoes.colaborador.pesquisar.create',[
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
        
        return view('configuracoes.colaborador.pesquisar.resultado',[
            'titulo'        => "Pesquisar Colaborador",
            'colaboradores' => $colaboradores
        ]);
    }

    private function deleteColaborador($colaborador)
    {
        $destino = 'img/colaborador/' . $colaborador->foto;
        if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
            File::delete($destino);
        }
        $colaborador->delete();
    }

    /**
     * Preenche um objeto Colaborador com os dados do Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Colaborador  $colaborador
     * @return void
     */
    private function preencheColaborador(Request $request, $colaborador)
    {
        $colaborador->base()->associate(Base::findOrFail($request->base_id));
        $colaborador->empresa()->associate(Empresa::findOrFail($request->empresa_id));
        $colaborador->cargo()->associate(Cargo::findOrFail($request->cargo_id));
        $colaborador->nome             = $request->nome;
        $colaborador->sobrenome        = $request->sobrenome;
        $colaborador->email            = $request->email;
        $colaborador->rg               = $request->rg;
        $colaborador->cpf              = $request->cpf;
        $colaborador->cnpj             = $request->cnpj;
        $colaborador->ramal            = $request->ramal;
        $colaborador->numero_matricula = $request->numero_matricula;
    }

    /**
     * Realiza o upload de uma foto.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|false
     */
    private function upload(Request $request)
    {
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $requestImagem  = $request->foto;
            $extension      = $requestImagem->extension();
            $imagemName     = md5($requestImagem->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $requestImagem->move(public_path('img/colaborador'), $imagemName);
            return $imagemName;
        }
        return false;
    }
}