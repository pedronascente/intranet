<?php

namespace App\Http\Controllers\Login;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Help\FormatarDataController;

class LoginController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;   
    }
    /**
     *  Mostrar formulario pro usuário fazer login.
     *
     * @param Request $request
     * @return void
     */
    public function create()
    {
        $messagem = FormatarDataController::formatarData();
        return view('login.create_login', 
            [
                'mensagem' => $messagem
            ]
        );
    }

    /**
     * Autenticar  usuário na aplicação.
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $credenciais = $request->validate($this->user->rulesLogin(), $this->user->feedbackLogin());
        $credenciais['status'] = 'on';
        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            $usuarioLogado = $request->user();
            //verifica se usuario Tem Token registrado.
            $usuario = User::with('tokens')->findOrFail($usuarioLogado->id);
            if($usuario->tokens()->count() <1){
                $this->logout($request);
                return redirect()->back()->with('error', 'Você não possui um Token válido.');
            }
            //Recuperar Perfil -modulos - Permissões: 
           // $this->criarSessaoPerfil($request, $usuarioDB->perfil->id);
            return redirect()->route('token.create');
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
}
