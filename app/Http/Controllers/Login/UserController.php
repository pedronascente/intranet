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
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Help\PermissaoHelp;

class UserController extends Controller
{
    private $modulo;
    private $paginate;
    private $qtdToken;
    private $actionIndex;
    private $actionShow;
    private $actionSenhaSucesso;
    private $actionRecuperarSenhaCreate;
    private $actionRecuperarSenhaSucesso;

    public function __construct()
    {
        $this->modulo = 7;
        $this->paginate = 10;
        $this->qtdToken = 40;
        $this->actionIndex = 'App\Http\Controllers\Login\UserController@index';
        $this->actionShow = 'App\Http\Controllers\Login\UserController@show';
        $this->actionSenhaSucesso = 'App\Http\Controllers\Login\UserController@senhaSucesso';
        $this->actionRecuperarSenhaCreate = 'App\Http\Controllers\Login\UserController@recuperarSenhaCreate';
        $this->actionRecuperarSenhaSucesso = 'App\Http\Controllers\Login\UserController@senhaSucesso';
    }

    public function index()
    {
        return view('configuracoes.user.index', [
            'collections' => User::with('perfil')->orderBy('id', 'desc')->paginate($this->paginate),
            'permissoes' => PermissaoHelp::getPermissoes($this->modulo),
        ]);
    }

    public function create()
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Criar', 'modulo' => $this->modulo])) {
            return view('configuracoes.user.create', ['perfis' => Perfil::all()]);
        } else {
            return redirect()
                ->action($this->actionIndex);
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

        #criar e associar 2FA ao usuario:
        $user->cartao()->create([
            'status' => $request->status,
            'user_id' => $user->id,
            'nome' => "2FA-" . $user->id,
            'qtdToken' => $this->qtdToken,
        ]);

        //retornar o 2FA do usuario.
        $userw = User::with('cartao')->findOrFail($user->id);
        Token::gerarToken($userw->cartao);
        event(new Registered($user));
        Auth::login($user);
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registrado com sucesso!");
    }

    public function edit($id)
    {
        if (PermissaoHelp::verificaPermissao(['permissao' => 'Editar', 'modulo' => $this->modulo])) {
            return view('configuracoes.user.edit', ['user' => User::findOrFail($id), 'perfis' => Perfil::orderBy('id', 'desc')->get()]);
        } else {
            return redirect()
                ->action($this->actionIndex);
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
            ->action($this->actionShow, $usuario->id)
            ->with('status', "Atualizado com sucesso!");
    }

    public function show($id)
    {
        $usuario =  User::with('perfil', 'colaborador', 'cartao')->findOrFail($id);
        return view('configuracoes.user.show', [
            'user' => $usuario,
            'status' => $usuario->getStatus($id),
        ]);
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
                ->action($this->actionIndex)
                ->with('warning', "Não foi possivel escluir!, Este usuario está sendo associado a um colaborador.");
        }
        $usuario->delete();
        return redirect()
            ->action($this->actionIndex)
            ->with('status', "Registro excluido com sucesso!");
    }

    public function resetPassword(Request $request, $id)
    {
        $this->validarFormulario($request, 'resetPassword');
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
            ->action($this->actionSenhaSucesso);
    }

    public function recuperarSenhaCreate()
    {
        return view('login.recuperar_senha');
    }

    /*
        *  Responsavel por enviar email , para o usuario recuperar a senha
        *  validar email
        *  criar has de tokens de validação

    */
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
                ->action($this->actionRecuperarSenhaSucesso);
        }
        return redirect()
            ->action($this->actionRecuperarSenhaCreate)
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
}
