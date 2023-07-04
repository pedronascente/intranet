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
        return view('user.index', ['collections' => $collections]);
    }

    public function create()
    {
        $grupos = Grupo::all();
        return view('user.register', ['grupos' => $grupos]);
    }

    public function store(Request $request)
    {
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
        return view('user.edit', [
            'user' => $user,
            'grupos' => $grupos
        ]);
    }

    public function update(Request $request, $id)
    {
        $usuario = User::with('grupo')->findOrFail($id);
        $this->validarFormulario($request, $usuario);
        echo 'usuario atualizado!';
    }

    public function show($id)
    {
        $user = User::with('grupo', 'colaborador')->findOrFail($id);
        return view('user.show', ['user' => $user]);
    }

    public function destroy($id)
    {
        return redirect()
            ->action('App\Http\Controllers\UserController@index')
            ->with('status', "Inativado com sucesso!");
    }

    private function validarFormulario(Request $request, $usuario)
    {
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
    }

    public function createAssociar($id)
    {
        $user = User::findOrFail($id);
        $colaboradores = Colaborador::where('user_id', null)->get();
        return view('user.associar', ['user' => $user, 'colabordores' => $colaboradores]);
    }

    public function updateAssociar(Request $request, $id)
    {

        $colaborador = Colaborador::findOrFail($request->colaborador_id);
        $colaborador->user_id = $id;
        $colaborador->update();
        return redirect(route('user.show', $id))
            ->with('status', "Colaborador associado com sucesso!");
    }

    public function destroyAssociacao($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        $id_user = $colaborador->user->id;
        $colaborador->user_id = null;
        $colaborador->update();
        return redirect(route('user.show', $id_user))
            ->with('status', "Usuário Foi desassociado com sucesso!");
    }
}
