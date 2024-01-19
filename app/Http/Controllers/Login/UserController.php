<?php

namespace App\Http\Controllers\Login;

use App\Models\User;
use App\Models\Token;
use App\Models\Perfil;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user =  $this->user->with('perfil')->orderBy('id', 'desc')->paginate(10);
        return view('configuracoes.user.index', [
            'collections' => $user,
        ]);
    }

    public function create()
    {
        return view('configuracoes.user.create', [
            'perfis' => Perfil::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->user->validarFormulario($request, 'store');
        $user = $this->user;
        $user->name           = $request->name;
        $user->status         = $request->status;
        $user->qtdToken       = $request->qtdToken;
        $user->colaborador_id = $request->colaborador_id;
        $user->perfil_id      = $request->perfil;
        $user->password       = Hash::make($request->password);
        $user->save();

        Token::gerarToken($user);

        return redirect()
            ->route('user.index')
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        return view('configuracoes.user.edit', [
            'user'   => $this->user->findOrFail($id),
            'perfis' => Perfil::orderBy('id', 'desc')->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->user->validarFormulario($request, 'update');
        $user         = $this->user->with('perfil')->findOrFail($id);
        $perfil       = Perfil::findOrFail($request->perfil);
        $user->perfil()->associate($perfil)->update();
        $user->status = $request->status;
        $user->name   = $request->name;
        if (empty(!$request->password)) {
            $user->password = Hash::make($request->password);
        }
        return redirect()
            ->route('user.show', $user->id)
            ->with('status', "Atualizado com sucesso!");
    }

    public function show($id)
    {
        $usuario =  $this->user->with('perfil', 'colaborador','tokens')
                               ->findOrFail($id);
        return view('configuracoes.user.show', [
            'user' => $usuario,
            'status' => $usuario->getStatus($id),
        ]);
    }

    public function meuPerfil(Request $request)
    {
        if (isset($request->user()->id)) {
            $usuario = $this->user->with('colaborador', 'perfil')
                                  ->findorFail($request->user()->id);
            return view('meu_perfil.index', [
                'id usuario'  => $usuario->id,
                'usuario'     => $usuario,
                'colaborador' => $usuario->colaborador,
                'perfil'      => $usuario->perfil,
                'status'      => $usuario->getStatus($usuario->id),
            ]);
        } else {
            return redirect()
                ->route('login.form');
        }
    }

    public function destroy($id)
    {
        $usuario = $this->user->with('colaborador')->findOrFail($id);
        if (!empty($usuario->colaborador)) {
            return redirect()
                ->route('user.index')
                ->with('warning', "Não foi possivel escluir!, Este usuario está sendo associado a um colaborador.");
        }
        $usuario->delete();
        return redirect()
            ->route('user.index')
            ->with('status', "Registro excluido com sucesso!");
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
        $this->composeEmail($usuario->colaborador, 'senha_recuperada');
        return redirect()
            ->route('user.senhaSucesso');
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
            $this->composeEmail($colaborador, 'recuperar_senha');
            return redirect()
                ->route('user.senhaSucesso');
        }
        return redirect()
            ->route('user.recuperarSenhaCreate')
            ->with('error', "Este email não está registrado!");
    }

    public function recuperarSenhaSucesso()
    {
        return view('login.recuperar_senha_sucesso');
    }

    public function senhaCreate($email, $token)
    {
        $colaborador = Colaborador::where('email', $email)->where('token_reset_pass', $token)->first();
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

    public function composeEmail($colaborador, $tipoMensagem)
    {
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
        try {
            //Server configuracoes
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();
            //Send using SMTP
            $mail->Host       = env('PHP_MAILER_HOST');                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = env('PHP_MAILER_USERNAME');;                     //SMTP username
            $mail->Password   = env('PHP_MAILER_PASSWORD');                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = env('PHP_MAILER_PORT');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //Recipients
            $mail->setFrom('desenvolvimento@grupovolpato.com', 'Intranet');
            $mail->addAddress($colaborador->email, $colaborador->nome);     //Add a recipient
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Recuperar Senha';
            $mail->Body = $this->getBody($colaborador, $tipoMensagem);
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
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
                $html .= "<title>Laravel - Resultados</title>";
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
