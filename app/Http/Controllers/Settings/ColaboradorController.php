<?php

namespace App\Http\Controllers\Settings;

use App\Models\Base;
use App\Models\User;
use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Help\PermissaoHelp;

class ColaboradorController extends Controller
{
    private $modulo; //id do modulo
    private $paginate;
    private $actionIndex;
    private $actionShow;
    private $actionUserProfile;
    private $bases;
    private $empresas;
    private $cargos;

    public function __construct()
    {
        $this->modulo = 2;
        $this->paginate = 10;
        $this->actionIndex = 'App\Http\Controllers\Settings\ColaboradorController@index';
        $this->actionShow = 'App\Http\Controllers\Settings\ColaboradorController@show';
        $this->actionUserProfile = 'App\Http\Controllers\UserController@profile';
        $this->bases = Base::orderBy('id', 'desc')->get();
        $this->empresas = Empresa::orderBy('id', 'desc')->get();
        $this->cargos = Cargo::orderBy('id', 'desc')->get();
    }

    public function index()
    {
        return view('settings.colaborador.index', [
            'collection' => Colaborador::orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('settings.colaborador.create', [
                'bases' => $this->bases,
                'empresas' => $this->empresas,
                'cargos' => $this->cargos,
                'usuarios' => $this->getUsuariosSemColaborador(),
            ]);
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    /**
     * Responsável por salvar o colaborador na base de dados.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $colaborador = new Colaborador();
        $usuario = User::find($request->user_id);
        if (!$usuario) {
            return redirect()
                ->back()
                ->withInput($request->all())
                ->with('warning', "Informe um ID de usuário válido");
        }
        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {
            $colaborador->nome = $request->nome;
            $colaborador->sobrenome = $request->sobrenome;
            $colaborador->email = $request->email;
            $colaborador->rg = $request->rg;
            $colaborador->cpf = $request->cpf;
            $colaborador->cnpj = $request->cnpj;
            $colaborador->base()->associate(Base::findOrFail($request->base_id));
            $colaborador->empresa()->associate(Empresa::findOrFail($request->empresa_id));
            $colaborador->cargo()->associate(Cargo::findOrFail($request->cargo_id));
            $colaborador->user()->associate($usuario);
            $colaborador->ramal = $request->ramal;
            if ($foto = $this->upload($request)) {
                $colaborador->foto = $foto;
            } else {
                $colaborador->foto = 'dummy-round.png';
            }
            $colaborador->save();
            return redirect()
                ->action($this->actionIndex)
                ->with('status', "Registrado com sucesso!");
        }
    }

    public function show($id)
    {
        return view('settings.colaborador.show', ['colaborador' => Colaborador::findOrFail($id)]);
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
            return view('settings.colaborador.edit', [
                'colaborador' => Colaborador::findOrFail($id),
                'empresas' => $this->empresas,
                'cargos' => $this->cargos,
                'bases' => $this->bases,
                'usuarios' => $this->getUsuariosSemColaborador(),
            ]);
        } else {
            return redirect()
                ->action($this->actionIndex);
        }
    }

    public function editProfile($id)
    {
        return view('profile.edit', [
            'colaborador' => Colaborador::findOrFail($id),
            'empresas' => $this->empresas,
            'cargos' => $this->cargos,
            'bases' => $this->bases,
            'usuarios' => $this->getUsuariosSemColaborador(),
        ]);
    }

    /**
     * Responsável por atualizar os dados do colaborador
     *
     * @param Request $request
     * @param [Integer] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $colaborador = Colaborador::with('cargo', 'empresa')->findOrFail($id);
        if ($this->validarFormulario($request, $colaborador)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {
            $colaborador->nome = $request->nome;
            $colaborador->sobrenome = $request->sobrenome;
            $colaborador->email = $request->email;
            $colaborador->rg = $request->rg;
            $colaborador->cpf = $request->cpf;
            $colaborador->cnpj = $request->cnpj;
            $colaborador->base()->associate(Base::findOrFail($request->base_id));
            $colaborador->empresa()->associate(Empresa::findOrFail($request->empresa_id));
            $colaborador->cargo()->associate(Cargo::findOrFail($request->cargo_id));
            $colaborador->ramal = $request->ramal;
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
                    ->action($this->actionUserProfile)
                    ->with('status', "Registro Atualizado!");
            } else {
                return redirect()
                    ->action($this->actionShow, $colaborador->id)
                    ->with('status', "Registro Atualizado!");
            }
        }
    }

    /**
     * Responsável por excluir registro
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        $colaborador = Colaborador::with('user')->findOrFail($request->id);
        if ($colaborador->user) {
            return redirect()
                ->action($this->actionShow, $request->id)
                ->with('warning', "Este colaborador tem Usuário associado, por tanto não pode ser excluida.");
        }
        $destino = 'img/colaborador/' . $colaborador->foto;
        if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
            File::delete($destino);
        }
        $colaborador->delete();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro Excluido!");
    }

    /**
     * Responsável por fazer upload da Imagem do colabortador
     *
     * @param Request $request
     * @return void
     */
    private function upload(Request $request)
    {
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $requestImagem = $request->foto;
            $extension = $requestImagem->extension();
            $imagemName = md5($requestImagem->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $requestImagem->move(public_path('img/colaborador'), $imagemName);
            return $imagemName;
        }
        return false;
    }

    /**
     * Responsável por validar formulário
     *
     * @param Request $request
     * @return void
     */
    private function validarFormulario(Request $request, $colaborador = null)
    {
        if ($colaborador) {
            if ($request->email != $colaborador->email) {
                $validar['email'] = 'required|email|unique:colaboradores,email';
            }
            if ($request->cpf != $colaborador->cpf) {
                $validar['cpf'] = 'required|max:14|unique:colaboradores,cpf';
            }
        } else {

            $validar['email'] = 'required|email|unique:colaboradores,email';
            $validar['cpf'] = 'required|max:14|unique:colaboradores,cpf';
        }
        $validar['user_id'] = 'required|max:4|unique:colaboradores,user_id';
        $validar['nome'] = 'required|max:191|min:5';
        $validar['ramal'] = 'required|max:4|min:2';
        $validar['sobrenome'] = 'required|max:191|min:5';
        $validar['rg'] = 'required|max:15';
        $validar['base_id'] = 'required';
        $validar['empresa_id'] = 'required';
        $validar['cargo_id'] = 'required';
        $validar['foto'] = [
            'nullable',
            'image',
            'max:1024'
        ];
        $request->validate(
            $validar,
            [
                'user_id.required' => 'Digite um id de usuário válido',
                'ramal.required' => 'Campo obrigatório.',
                'nome.required' => 'Campo obrigatório.',
                'sobrenome.required' => 'Campo obrigatório.',
                'email.required' => 'Digite um e-mail válido',
                'rg.required' => 'Campo obrigatório.',
                'cpf.required' => 'Campo obrigatório.',
                'base_id.required' => 'Campo obrigatório.',
                'empresa_id.required' => 'Campo obrigatório.',
                'cargo_id.required' => 'Campo obrigatório.',
            ]
        );
    }
}
