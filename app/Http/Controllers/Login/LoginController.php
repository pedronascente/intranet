<?php

namespace App\Http\Controllers\Login;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Help\CaniveteHelp;

class LoginController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;   
    }
    
    public function create()
    {
        $messagem = CaniveteHelp::formatarDataLogin();
        return view('login.create_login', 
            [
                'mensagem' => $messagem
            ]
        );
    }

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
            return redirect()->route('token.create');
        } else {
            return redirect()->back()->with('error', 'Usuário ou senha inválido.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
