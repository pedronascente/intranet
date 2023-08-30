<?php

namespace App\Http\Controllers;

use App\Models\User;
//use App\Models\Cartao;
use App\Models\Perfil;
//use App\Models\Colaborador;
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
                'collections' => User::with('perfil')->orderBy('id', 'desc')->paginate(8),
                'permissoes' => $this->getPermissoes()
            ]
        );
    }

    public function create()
    {
        if ($this->verificarPermissao('Criar')) {
            return view(
                'settings.user.register',
                [
                    'perfis' => Perfil::all()
                ]
            );
        } else {
            return redirect()
                ->action('App\Http\Controllers\UserController@index');
        }
    }

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
        if ($this->verificarPermissao('Editar')) {
            return view(
                'settings.user.edit',
                [
                    'user' => User::findOrFail($id),
                    'perfis' => Perfil::orderBy('id', 'desc')->get()
                ]
            );
        } else {
            return redirect()
                ->action('App\Http\Controllers\UserController@index');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validarFormulario($request, 'update');
        $usuario = User::with('perfil')->findOrFail($id);
        $perfil = Perfil::findOrFail($request->perfil);
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

    public function show($id)
    {
        $usuario =  User::with('perfil', 'colaborador', 'cartao')->findOrFail($id);
        return view(
            'settings.user.show',
            [
                'user' => $usuario,
                'status' => $usuario->getStatus($id),
            ]
        );
    }

    public function profile(Request $request)
    {
        if ($request->user()) {
            $id = $request->user()->id;
            $usuario = User::with('colaborador', 'perfil', 'cartao')->findorFail($id);
            return view('profile.index', [
                'id usuario' => $id,
                'usuario' => $usuario,
                'colaborador' => $usuario->colaborador,
                'perfil' => $usuario->perfil,
                'cartao' => $usuario->cartao,
                'status' => $usuario->getStatus($id),
            ]);
        } else {
            dd('usuario não localizado!');
        }
    }

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

    public function resetPassword(Request $request, $id)
    {
        $this->validarFormulario($request, 'resetPassword');
        $usuario = User::findOrFail($id);
        if (empty(!$request->password)) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->update();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
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
                    'password' => $this->getRegraPassword(),
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
                        'password' => $this->getRegraPassword(),
                    ]);
                }
                $request->validate($regras);
                break;
            case 'resetPassword':
                $request->validate([
                    'password_confirmation' => ['required'],
                    'password' => $this->getRegraPassword(),
                ]);
                break;
        }
    }

    private function getPermissoes()
    {
        $arrayPermissoes  = isset(session()->get('perfil')['permissoes'][7]) ? session()->get('perfil')['permissoes'][7]->toArray() : null;
        if (!empty($arrayPermissoes)) {
            $permissoes = $arrayPermissoes;
        } else {
            $permissoes = null;
        }
        return $permissoes;
    }

    private function getRegraPassword()
    {
        return [
            'required',
            'confirmed',
            'string',
            'min:6',              // deve ter pelo menos 6 caracteres
            'regex:/[a-z]/',      // deve conter pelo menos uma letra minúscula
            'regex:/[A-Z]/',      // deve conter pelo menos uma letra maiúscula
            'regex:/[0-9]/',      // deve conter pelo menos um dígito
            'regex:/[@$!%*#?&]/', // deve conter um caractere especial
        ];
    }

    private function verificarPermissao($permissao)
    {
        $modulo = 7;
        $ArrayLystPermissoes = [];
        if (session()->get('perfil')) {
            foreach (session()->get('perfil')['permissoes'] as $item) {
                foreach ($item as  $value) {
                    if ($value->modulo_id == $modulo) {
                        $ArrayLystPermissoes[] = $value->nome;
                    };
                }
            }
        }
        if (in_array($permissao, $ArrayLystPermissoes)) {
            return true;
        } else {
            return false;
        }
    }
}
