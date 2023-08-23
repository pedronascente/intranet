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
        return view(
            'settings.colaborador.index',
            [
                'collection' => Colaborador::orderBy('id', 'desc')->paginate(10),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    public function create()
    {
        return view('settings.colaborador.create', [
            'empresas' => Empresa::orderBy('id', 'desc')->get(),
            'cargos' => Cargo::orderBy('id', 'desc')->get(),
            'usuarios' => $this->getUsuariosSemColaborador(),
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
        $colaborador = new Colaborador();

        $cargo = Cargo::findOrFail($request->cargo_id);
        $empresa = Empresa::findOrFail($request->empresa_id);
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
            $colaborador->cargo()->associate($cargo);
            $colaborador->empresa()->associate($empresa);
            $colaborador->user()->associate($usuario);
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
        return view(
            'settings.colaborador.show',
            [
                'colaborador' => Colaborador::findOrFail($id)
            ]
        );
    }

    public function edit($id)
    {
        return view('settings.colaborador.edit', [
            'colaborador' => Colaborador::findOrFail($id),
            'empresas' => Empresa::orderBy('id', 'desc')->get(),
            'cargos' => Cargo::orderBy('id', 'desc')->get(),
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
        $cargo = Cargo::findOrFail($request->cargo_id);
        $empresa = Empresa::findOrFail($request->empresa_id);
        $usuario = User::find($request->user_id);

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
            $colaborador->cargo()->associate($cargo);
            $colaborador->empresa()->associate($empresa);

            if ($usuario) {
                $colaborador->user()->associate($usuario);
            }

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
    }

    /**
     * Retorna todos os usuarios que não tem colaborador registrado
     *
     * @param [type] $id
     * @return void
     */

    /**
 public function createAssociar($id)
    {
        return view('settings.colaborador.associar', [
            'colaborador' => Colaborador::findOrFail($id),
            'users' => $this->getUsuariosSemColaborador(),
        ]);
    }
 
     */


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
    public function destroy(Request $request, $id)
    {
        $colaborador = Colaborador::with('user')->findOrFail($request->id);
        if ($colaborador->user) {
            return redirect()
                ->action('App\Http\Controllers\ColaboradorController@show', $request->id)
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
    private function validarFormulario(Request $request, $colaborador = null)
    {

        if ($colaborador) {
            if ($request->user_id != $colaborador->user_id) {
                $validar['user_id'] = 'required|min:1|max:999|integer|unique:colaboradores,user_id';
            }

            if ($request->email != $colaborador->email) {
                $validar['email'] = 'required|email|unique:colaboradores,email';
            }

            if ($request->cpf != $colaborador->cpf) {
                $validar['cpf'] = 'required|max:14|unique:colaboradores,cpf';
            }
        } else {
            $validar['user_id'] = 'required|min:1|max:999|integer|unique:colaboradores,user_id';
            $validar['email'] = 'required|email|unique:colaboradores,email';
            $validar['cpf'] = 'required|max:14|unique:colaboradores,cpf';
        }

        $validar['nome'] = 'required|max:191|min:5';
        $validar['sobrenome'] = 'required|max:191|min:5';
        $validar['rg'] = 'required|max:15';
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

    private function getUsuariosSemColaborador()
    {
        $userList = null;
        $users = User::with('colaborador')->get();
        foreach ($users as $user) {
            if (!$user->colaborador) {
                $userList[] = $user;
            }
        }
        return $userList;
    }

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][2]) ? session()->get('perfil')['permissoes'][2]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }
}
