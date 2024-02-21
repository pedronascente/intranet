<?php

namespace App\Http\Controllers\Login;

use App\Models\User;
use App\Models\Token;
use App\Models\Perfil;
use App\Models\Colaborador\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Help\CaniveteHelp;
use Illuminate\Support\Facades\Redirect;
class UserController extends Controller
{
    private $user;
    private $arrayListPermissoesDoModuloDaRota;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index()
    {
        $titulo = "Lista de Usuários";
        $arrayListUsuario = $this->user->with('perfil')->orderBy('id', 'desc')->paginate(10);
        return view('usuario.index', [
            'titulo' => $titulo,
            'arrayListUsuario' => $arrayListUsuario,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create()
    {
        if (in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = 'Cadastrar usário';
            $Perfil = Perfil::all();
            return view('usuario.create', [
                'titulo' => $titulo,
                'perfis' => $Perfil
            ]);
        } else {
            return redirect()->route('usuario.index')->with('error', "Você não Tem Permissão de Cadastro.");
        }       
    }

    public function store(Request $request)
    {
        $this->user->validarFormulario($request, 'store');
        $user = new User();
        $user->name = $request->name;
        $user->status = $request->status;
        $user->qtdToken = $request->qtdToken;
        $user->colaborador_id = $request->colaborador_id;
        $user->perfil_id = $request->perfil;
        $user->password = Hash::make($request->password);
        try {
            $user->save();
            Token::gerarToken($user->id, $request->qtdToken);
            return Redirect::route('usuario.index')->with('status', "Registrado com sucesso!");
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'Ocorreu um erro ao salvar o usuário. Por favor, tente novamente.']);
        }
    }

    public function edit($id)
    {
        if (in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Editar usuário";
            $user = $this->user->findOrFail($id);
            $perfil = Perfil::orderBy('id', 'desc')->get();
            return view('usuario.edit', [
                'titulo' => $titulo,
                'user' => $user,
                'perfis' => $perfil
            ]);
        } else {
            return redirect()->route('usuario.index')->with('error', "Você não Tem Permissão de Editar.");
        }       
    }

    public function update(Request $request, $id)
    {
        $this->user->validarFormulario($request, 'update');
        $user = $this->user->with('perfil')->findOrFail($id);
        $perfil = Perfil::findOrFail($request->perfil);

        if ($user->qtdToken != $request->qtdToken) {
            Token::gerarToken($id, $request->qtdToken);
        }

        $user->status = $request->status;
        $user->name = $request->name;
        $user->qtdToken = $request->qtdToken; 
        $user->perfil()->associate($perfil);
        
        if (empty(!$request->password)) {
            $user->password = Hash::make($request->password);
        }

        try {
            $user->save();
            return redirect()->route('usuario.show', $user->id)->with('status', "Atualizado com sucesso!");
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['error' => 'Ocorreu um erro ao atualizar o usuário. Por favor, tente novamente.']);
        }
    }

    public function show($id)
    {
        if (in_array('Visualizar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Visualizar usuário";
            $usuario = $this->user->with('perfil', 'colaborador', 'tokens')->findOrFail($id);
            $status = $usuario->getStatus($id);
            return view('usuario.show', [
                'titulo' => $titulo,
                'user' => $usuario,
                'status' => $status,
                'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
            ]);
        } else {
            return redirect()->route('usuario.index')->with('error', "Você não Tem Permissão de Visualizar.");
        }      
    }

    public function destroy($id)
    {
        if (in_array('Excluir', $this->arrayListPermissoesDoModuloDaRota)) {
            $usuario = $this->user->with('colaborador')->findOrFail($id);
            if (!empty($usuario->colaborador)) {
                return redirect()->route('usuario.index')->with('warning', "Não foi possivel escluir!, Este usuario está sendo associado a um colaborador.");
            }
            $usuario->delete();
            return redirect()->route('usuario.index')->with('status', "Registro excluido com sucesso!");
        } else {
            return redirect()->route('usuario.index')->with('error', "Você não Tem Permissão de Excluir.");
        }       
    }

    public function resetarSenha(Request $request, $id)
    {
        $this->user->validarFormulario($request, 'resetPassword');
        $usuario = User::with('colaborador')->findOrFail($id);
        if (empty(!$request->password)) {
            $usuario->password = Hash::make($request->password);
        }
        $usuario->update();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $this->enviarEmail($usuario->colaborador, 'senha_recuperada');
        return redirect()->route('usuario.senhaSucesso');
    }

    public function recuperarSenhaCreate()
    {
        return view('login.recuperar_senha');
    }

    public function recuperarSenhaStore(Request $request)
    {
        $request->validate(['email' => 'required|email|email',]);
        $colaborador = Colaborador::where('email', $request->email)->first();
        $tokenResetEmail = md5(time());
        if ($colaborador && $colaborador->count() >= 1) {
            $colaborador->token_reset_pass = $tokenResetEmail;
            $colaborador->update();
            //enviar email :
            $this->enviarEmail($colaborador, 'recuperar_senha');
            return redirect()->route('usuario.recuperarSenhaSucesso');
        }
        return redirect()->route('usuario.recuperarSenhaCreate')->with('error', "Este email não está registrado!");
    }

    public function recuperarSenhaSucesso()
    {
        return view('login.recuperar_senha_sucesso');
    }

    public function senhaCreate($email, $token)
    {
        $colaborador = Colaborador::with('usuario')->where('email', $email)->where('token_reset_pass', $token)->first();
        if (!$colaborador) {
            return redirect('/');
        } else {
            return view('login.senha_create', ['colaborador' => $colaborador]);
        }
    }

    public function senhaSucesso()
    {
        return view('login.senhaSucesso');
    }

    private function enviarEmail($colaborador, $tipoMensagem)
    {
        $CaniveteHelp = new CaniveteHelp();  
        $CaniveteHelp->enviarEmail([
            'emailFfrom'=> 'desenvolvimento@grupovolpato.com',
            'email'=> $colaborador->email,
            'nome'=> $colaborador->nome,
            'body'=> $this->getBody($colaborador, $tipoMensagem),
        ]);
    }

    private function getBody($colaborador, $tipoMensagem)
    {
        switch ($tipoMensagem) {
            case 'recuperar_senha':
                $link = route('senha', [$colaborador->email, $colaborador->token_reset_pass]);
                $html = "<!doctype html>";
                $html .= "<html>";
                $html .= "<head>";
                $html .= "<meta charset='utf-8'>";
                $html .= "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
                $html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
                $html .= "<title>Recuperar minha Senha</title>";
                $html .= "</head>";
                $html .= "<body>";
                $html .= "<p>presado(a) $colaborador->nome</p>";
                $html .= "<p>Recebemos em nosso sistema uma solicitação para recuperar sua senha </p>";
                $html .= "<p>Por favor, caso não tenha solicitado favor, ignore este email. caso contrario ...</p>";
                $html .= "
                    <h1>Super Dicas para uma boa senha!</h1>
                        <ul>
                            <li>deve ter pelo menos 6 caracteres: [ min:6 ]</li>
                            <li>deve conter pelo menos uma letra minúscula: [a-z]</li>
                            <li>deve conter pelo menos uma letra maiúscula: [A-Z]</li>
                            <li>deve conter pelo menos um dígito: [0-9]</li>
                            <li>deve conter um caractere especial:[@$!%*#?&]</li>
                        </ul>";
                $html .= "
                    <br>
                    <p>
                        <a href=" . $link . " >CLIQUE AQUI PARA RECUPERAR SUA SENHA</a>
                    </p>";
                $html .= "</body>";
                $html .= "</html>";
                return $html;
                break;
            case 'senha_recuperada':
                $html = "<!doctype html>";
                $html .= "<html>";
                $html .= "<head>";
                $html .= "<meta charset='utf-8'>";
                $html .= "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
                $html .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">";
                $html .= "<title>Laravel - Resultados</title>";
                $html .= "</head>";
                $html .= "<body>";
                $html = "<h1>Sua Senha foi alterada!</h1>";
                $html .= "<p>Olá, $colaborador->nome</p>";
                $html .= "<p>A senha cadastrada na Intranet foi alterada</p>";
                $html .= "<p>Caso não tenha pedido esssa Alteração, entre em contato com</p>";
                $html .= "<p>o suporte o mais rápido possivel</p>";
                $html .= "</body>";
                $html .= "</html>";
                return  $html;
                break;
        }
    }
}
