<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cartao;
use App\Models\Perfil;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function index()
    {
        return view(
            'settings.user.index',
            [
                'collections' => User::with('perfil')->orderBy('id', 'desc')->paginate(8)
            ]
        );
    }

    public function create()
    {
        $perfis = Perfil::all();
        return view('settings.user.register', ['perfis' => $perfis]);
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
            'status' => $request->status,
            'perfil_id' => $request->perfil,
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
        $perfis = Perfil::orderBy('id', 'desc')->get();
        return view('settings.user.edit', [
            'user' => $user,
            'perfis' => $perfis
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
        $usuario = User::with('perfil')->findOrFail($id);
        $perfil = Perfil::findOrFail($request->perfil);
        $this->validarFormulario($request, 'update');
        $usuario->status = $request->status;
        $usuario->name = $request->name;
        if (empty(!$request->password)) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->perfil()->associate($perfil)->update();
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
        return view(
            'settings.user.show',
            [
                'user' => User::with('perfil', 'colaborador', 'cartao')->findOrFail($id)
            ]
        );
    }

    /**
     * Responsável por Excluir usuário
     *0
     * @param [Integer] $id
     * @return void
     */
    public function destroy(Request $request, $id)
    {
        $usuario = User::with('colaborador', 'cartao')->findOrFail($request->id);
        if (!empty($usuario->colaborador)) {
            return redirect()
                ->action('App\Http\Controllers\UserController@index')
                ->with('warning', "Não foi possivel escluir!, Este usuario está sendo associado a um colaborador.");
        }
        $usuario->delete();
        return redirect()
            ->action('App\Http\Controllers\UserController@index')
            ->with('status', "Registro excluido com sucesso!");
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
                    'status' => ['required', 'string'],
                    'perfil' => ['required'],
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
                    'status' => ['required', 'string'],
                    'perfil' => ['required'],
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
