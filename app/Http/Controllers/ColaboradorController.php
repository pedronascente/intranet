<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ColaboradorController extends Controller
{
    public function index()
    {
        $collection = Colaborador::orderBy('id', 'desc')->paginate(10);
        return view('settings.colaborador.index', ['collection' => $collection]);
    }

    public function create()
    {
        $empresas = Empresa::orderBy('id', 'desc')->get();
        $cargos = Cargo::orderBy('id', 'desc')->get();
        return view('settings.colaborador.create', [
            'empresas' => $empresas,
            'cargos' => $cargos,
        ]);
    }

    /**
     * Responsável por salvar o colaborador na base de dados.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {
            $colaborador = new Colaborador();
            $cargo = Cargo::findOrFail($request->cargo_id);
            $empresa = Empresa::findOrFail($request->empresa_id);
            $colaborador->nome = $request->nome;
            $colaborador->sobrenome = $request->sobrenome;
            $colaborador->email = $request->email;
            $colaborador->rg = $request->rg;
            $colaborador->cpf = $request->cpf;
            $colaborador->cnpj = $request->cnpj;
            $colaborador->cargo()->associate($cargo);
            $colaborador->empresa()->associate($empresa);
            if ($foto = $this->upload($request)) {
                $colaborador->foto = $foto;
            } else {
                $colaborador->foto = 'dummy-round.png';
            }
            $colaborador->save();
            return redirect()
                ->action('App\Http\Controllers\ColaboradorController@index')
                ->with('status', "Registrado com sucesso!");
        }
    }

    public function show($id)
    {
        $c = Colaborador::findOrFail($id);
        return view('settings.colaborador.show', ['colaborador' => $c]);
    }

    public function edit($id)
    {
        $colaboraodor = Colaborador::findOrFail($id);
        $empresas = Empresa::orderBy('id', 'desc')->get();
        $cargos = Cargo::orderBy('id', 'desc')->get();
        return view('settings.colaborador.edit', [
            'colaborador' => $colaboraodor,
            'empresas' => $empresas,
            'cargos' => $cargos,
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
        $cargo = Cargo::findOrFail($request->cargo_id);
        $empresa = Empresa::findOrFail($request->empresa_id);
        $colaborador->nome = $request->nome;
        $colaborador->sobrenome = $request->sobrenome;
        $colaborador->email = $request->email;
        $colaborador->rg = $request->rg;
        $colaborador->cpf = $request->cpf;
        $colaborador->cnpj = $request->cnpj;
        $colaborador->cargo()->associate($cargo);
        $colaborador->empresa()->associate($empresa);
        if ($request->hasFile('foto')) {
            $destino = 'img/colaborador/' . $colaborador->foto;
            if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
                File::delete($destino);
            }
            $colaborador->foto = $this->upload($request);
        }
        $colaborador->update();
        return redirect()
            ->action('App\Http\Controllers\ColaboradorController@index')
            ->with('status', "Registro Atualizado!");
    }

    /**
     * Retorna todos os usuarios que não tem colaborador registrado
     *
     * @param [type] $id
     * @return void
     */
    public function createAssociar($id)
    {
        $userList = null;
        $colaboraodor = Colaborador::findOrFail($id);
        $users = User::with('colaborador')->get();
        foreach ($users as $user) {
            if (!$user->colaborador) {
                $userList[] = $user;
            }
        }

        return view('settings.colaborador.associar', [
            'colaborador' => $colaboraodor,
            'users' => $userList,
        ]);
    }

    /**
     * Responsável por associar um usuario 
     *
     * @param Request $request
     * @param [Integer] $id
     * @return void
     */
    public function associarUsuario(Request $request, $id)
    {
        $colaborador = Colaborador::with('user')->findOrFail($id);
        $user = User::findOrFail($request->user_id);
        $colaborador->user()->associate($user);
        $colaborador->update();
        return redirect(route('colaborador.show', $colaborador->id))
            ->with('status', "Usuário Foi associado com sucesso!");
    }

    /**
     * Responsavel por disassociar um usuário
     *
     * @param [type] $id
     * @return void
     */
    public function desassociarUsuario($id)
    {
        $colaborador = Colaborador::with('user')->findOrFail($id);
        $user = User::findOrFail($colaborador->user_id);
        $colaborador->user()->disassociate($user)->save();
        return redirect(route('colaborador.show', $colaborador->id))
            ->with('status', "Usuário Foi desassociado com sucesso!");
    }

    /**
     * Responsável por excluir registro
     *
     * @param Request $request
     * @return void
     */
    public function destroy($id)
    {
        $colaborador = Colaborador::with('user')->findOrFail($id);
        if ($colaborador->user) {
            return redirect()
                ->action('App\Http\Controllers\ColaboradorController@show', $id)
                ->with('warning', "Este colaborador tem Usuário associado, por tanto não pode ser excluida.");
        }
        $destino = 'img/colaborador/' . $colaborador->foto;
        if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
            File::delete($destino);
        }
        $colaborador->delete();
        return redirect()
            ->action('App\Http\Controllers\ColaboradorController@index')
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
    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:191|min:5',
                'sobrenome' => 'required|max:191|min:5',
                'email' => 'required|email',
                'rg' => 'required|max:15',
                'cpf' => 'required|max:14',
                'empresa_id' => 'required',
                'cargo_id' => 'required',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'sobrenome.required' => 'Campo obrigatório.',
                'email.required' => 'Digite um e-mail válido',
                'rg.required' => 'Campo obrigatório.',
                'cpf.required' => 'Campo obrigatório.',
                'empresa_id.required' => 'Campo obrigatório.',
                'cargo_id.required' => 'Campo obrigatório.',
            ]
        );
    }
}
