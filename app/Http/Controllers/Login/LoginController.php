<?php

namespace App\Http\Controllers\Login;

use App\Models\User;
use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Help\FormatarDataController;

class LoginController extends Controller
{
    private $actionCreateToken;

    public function __construct()
    {
        $this->actionCreateToken = 'App\Http\Controllers\Login\TokenController@create';
    }
    /**
     *  Mostrar formulario pro usuário fazer login.
     *
     * @param Request $request
     * @return void
     */
    public function showForm(Request $request)
    {
        $messagem = FormatarDataController::formatarData();
        return view('login.passo_01', ['mensagem' =>   $messagem]);
    }

    /**
     * Autenticar  usuário na aplicação.
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $credenciais = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'O campo usuario é obrigatório!',
            'password.required' => 'O campo senha é obrigatório!',
        ]);
        $credenciais['status'] = 'on';
        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            $usuarioLogado = $request->user();
            $usuarioDB = User::with('tokens', 'perfil')->findOrFail($usuarioLogado->id);
            if (!$usuarioDB->tokens) {
                $this->logout($request);
                return redirect()->back()->with('error', 'Você não possui um 2FA válido.');
            }
            $this->criarSessaoPerfil($request, $usuarioDB->perfil->id);
            return redirect()
                ->action($this->actionCreateToken);
        } else {
            return redirect()->back()->with('error', 'Usuário ou senha inválido.');
        }
    }

    /**
     * Desconectar o usuário do aplicativo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    private function criarSessaoPerfil($request, $id)
    {
        $perfil = Perfil::with('modulos')->findOrFail($id);
        $sessaoPerfil['dados'] = [
            "id" => $perfil->id,
            "nome" => $perfil->nome,
        ];
        if ($perfil->modulos) {
            foreach ($perfil->modulos as  $modulo) {
                $sessaoPerfil['modulos'][] = [
                    "id"        => $modulo->id,
                    "nome"      => $modulo->nome,
                    "rota"      => $modulo->rota,
                    "slug"      => $modulo->slug,
                    "tipo_menu" => $modulo->tipo_menu,
                ];
            }
        }
        $permissoes = $perfil->getPermissoes($id);
        if ($permissoes) {
            $sessaoPerfil['permissoes']  = $permissoes;
        }
        $request->session()->put('perfil', $sessaoPerfil);
    }
}
