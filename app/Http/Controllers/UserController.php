<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Colaborador;
use App\Models\User;
use App\Models\Grupo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $collections  =  User::with('grupo')->orderBy('id', 'desc')->paginate(8);
        return view('settings.user.index', ['collections' => $collections]);
    }

    public function create()
    {
        $grupos = Grupo::all();
        return view('settings.user.register', ['grupos' => $grupos]);
    }

    /**
     * Responsavel por salvar os dados na base
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validarFormulario($request, 'store');
        $user = User::create([
            'name' => $request->name,
            'ativo' => $request->ativo,
            'grupo_id' => $request->grupo,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        Auth::login($user);
        return redirect()
            ->action('App\Http\Controllers\UserController@index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $grupos = Grupo::orderBy('id', 'desc')->get();
        return view('settings.user.edit', [
            'user' => $user,
            'grupos' => $grupos
        ]);
    }

    /**
     * Responsável por Atualizar usuário
     *
     * @param Request $request
     * @param [integer] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $usuario = User::with('grupo')->findOrFail($id);
        $grupo = Grupo::findOrFail($request->grupo);
        $this->validarFormulario($request, 'update');
        $usuario->ativo = $request->ativo;
        $usuario->name = $request->name;
        if (empty(!$request->password)) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->grupo()->associate($grupo)->update();
        return redirect()
            ->action('App\Http\Controllers\UserController@show', $usuario->id)
            ->with('status', "Atualizado com sucesso!");
    }

    /**
     * Responsável por mostrar detalhes do usuário
     *
     * @param [Integer] $id
     * @return void
     */
    public function show($id)
    {
        $user = User::with('grupo', 'colaborador', 'cartao')->findOrFail($id);
        return view('settings.user.show', ['user' => $user]);
    }

    /**
     * Responsável por Excluir usuário
     *
     * @param [Integer] $id
     * @return void
     */
    public function destroy($id)
    {
        return redirect()
            ->action('App\Http\Controllers\UserController@index')
            ->with('status', "Inativado com sucesso!");
    }

    /**
     * Responsavel por validar formulario
     *
     * @param Request $request
     * @param [object] $usuario
     * @return void
     */
    private function validarFormulario(Request $request, $tipo)
    {
        switch ($tipo) {
            case 'store':
                $request->validate([
                    'ativo' => ['required', 'string'],
                    'grupo' => ['required'],
                    'name' => ['required', 'string', 'max:255'],
                    'password_confirmation' => ['required'],
                    'password' => [
                        'required',
                        'confirmed',
                        'string',
                        'min:6',              // deve ter pelo menos 6 caracteres
                        'regex:/[a-z]/',      // deve conter pelo menos uma letra minúscula
                        'regex:/[A-Z]/',      // deve conter pelo menos uma letra maiúscula
                        'regex:/[0-9]/',      // deve conter pelo menos um dígito
                        'regex:/[@$!%*#?&]/', // deve conter um caractere especial
                    ],
                ]);
                break;
            case 'update':
                $regras =  [
                    'ativo' => ['required', 'string'],
                    'grupo' => ['required'],
                    'name' => ['required', 'string', 'max:255'],
                ];
                if (!is_null($request->password) || !is_null($request->password_confirmation)) {
                    $regras = array_merge($regras, [
                        'password_confirmation' => ['required'],
                        'password' => [
                            'required',
                            'confirmed',
                            'string',
                            'min:6',              // deve ter pelo menos 6 caracteres
                            'regex:/[a-z]/',      // deve conter pelo menos uma letra minúscula
                            'regex:/[A-Z]/',      // deve conter pelo menos uma letra maiúscula
                            'regex:/[0-9]/',      // deve conter pelo menos um dígito
                            'regex:/[@$!%*#?&]/', // deve conter um caractere especial
                        ],
                    ]);
                }
                $request->validate($regras);
                break;
        }
    }

    /**
     * Responsavel por mostar formulario de associação
     *
     * @param [Integer] $id
     * @return void
     */
    public function createAssociar($id)
    {
        $user = User::findOrFail($id);
        $colaboradores = Colaborador::where('user_id', null)->get();
        return view('settings.user.associar', ['user' => $user, 'colabordores' => $colaboradores]);
    }

    /**
     * Associar Colaborador
     *
     * @param Request $request
     * @param [Integer] $id
     * @return void
     */
    public function associarColaborador(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $colaborador = Colaborador::findOrFail($request->colaborador_id);
        $colaborador->user()->associate($user)->update();
        return redirect(route('user.show', $id))
            ->with('status', "Colaborador associado com sucesso!");
    }

    /**
     * Disassociar Colaborador
     *
     * @param [Integer] $id
     * @return void
     */
    public function desassociarColaborador($id)
    {
        $colaborador = Colaborador::with('user')->findOrFail($id);
        $user = User::findOrFail($colaborador->user_id);
        $colaborador->user()->disassociate($user)->save();
        return redirect(route('user.show', $user->id))
            ->with('status', "Usuário Foi desassociado com sucesso!");
    }
}
