<?php

namespace App\Http\Controllers\Usuario;

use App\Models\User;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Colaborador\Colaborador;
use App\Http\Controllers\SendEmail\EmailSolicitacaoRecuperarSenha;
use App\Http\Controllers\SendEmail\EmailRespostaRecuperarSenha;

class RecuperarSenhaController extends Controller
{
  private $user;
  
  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function informarEmailRecuperarSenha()
  {
    return view('recuperarSenha.createInformarEmailRecuperarSenha');
  }

  public function enviarEmailRecuperarSenha(Request $request)
  {
      $request->validate(['email' => 'required|email|email',]);
      $colaborador = Colaborador::where('email', $request->email)->first();
      $tokenResetEmail = md5(time());
      if ($colaborador && $colaborador->count() >= 1) {
        $colaborador->token_reset_pass = $tokenResetEmail;
        $colaborador->update();

        $this->enviarEmail($colaborador, 'recuperar_senha');

        return redirect()->route('recuperarSenha.sucessoEnviarEmailRecuperarSenha');
      }
      return redirect()->route('recuperarSenha.informarEmailRecuperarSenha')->with('error', "Este email não está registrado!");
  }

  public function sucessoEnviarEmailRecuperarSenha()
  {
      return view('recuperarSenha.sucessoEmailEnviadoRecuperarSenha');
  }

  public function cadastrarNovaSenha($email, $token)
  {
      $colaborador = Colaborador::with('usuario')->where('email', $email)->where('token_reset_pass', $token)->first();
      if (!$colaborador) {
        return redirect('/');
      } else {
        return view('recuperarSenha.createCadastrarNovaSenha', ['colaborador' => $colaborador]);
      }
  }

  public function resetarMinhaSenhaDeUsuario(Request $request, $id)
  {
      $this->user->validarFormulario($request, 'resetPassword');
      $usuario = User::with('colaborador')->findOrFail($id);
      
      if (empty(!$request->password)) {
        $usuario->password = Hash::make($request->password);
      }

      if($request->resetToken){
          Token::gerarToken($usuario->id, $usuario->qtdToken);
      }
      $this->enviarEmail($usuario, 'senha_recuperada');

      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();

      return redirect()->route('recuperarSenha.sucessoSenhaRecuperada');
  }

  public function sucessoSenhaRecuperada()
  {
      return view('recuperarSenha.sucessoSenhaRecuperada');
  }

  private function enviarEmail($objetoModel, $tipoMensagem)
  {
      switch ($tipoMensagem) 
      {
        case 'recuperar_senha':
            $e = new EmailSolicitacaoRecuperarSenha();
            $e->setFrom("desenvolvimento@grupovolpato.com");
            $e->setName($objetoModel->nome);
            $e->setEmail($objetoModel->email);
            $e->setSubject('Recuperar Senha');
            $e->setTokenResetPass($objetoModel->token_reset_pass);
            $e->setLink('recuperarSenha.cadastrarNovaSenha');
            $e->enviarEmail();
        break;
        case 'senha_recuperada':
            $e = new EmailRespostaRecuperarSenha();
            $e->setFrom("desenvolvimento@grupovolpato.com");
            $e->setName($objetoModel->colaborador->nome);
            $e->setEmail($objetoModel->colaborador->email);
            $e->setSubject('Recuperar Senha');
            $e->setToken($objetoModel->tokens);
            $e->enviarEmail();
        break;
      } 
  }

  public function show($id)
  {
    return redirect()->route('recuperarSenha.informarEmailRecuperarSenha');
  }
}
