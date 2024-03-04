<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Models\Colaborador\Base;
use App\Models\Colaborador\Cargo;
use App\Models\Colaborador\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\Colaborador\Colaborador;
use App\Http\Controllers\Help\CaniveteHelp;
use App\Http\Controllers\SendEmail\EmailRespostaRecuperarSenha;
class MeuPerfilController extends Controller
{
  private $user;
  private $path;
  private $CaniveteHelp;
  private $colaborador;
  
  public function __construct(User $user, Colaborador $colaborador)
  {
    $this->path = 'img/colaborador/';
    $this->user = $user;
    $this->colaborador = $colaborador;
    $this->CaniveteHelp = new CaniveteHelp();
  }

  public function index(Request $request)
  {
      if (!isset($request->user()->id)) {
        return redirect()->route('login.form');
      }
      $usuario = $this->user->with('colaborador', 'perfil')->findorFail($request->user()->id);
      return view('meuPerfil.index', [
          'id usuario' => $usuario->id,
          'usuario' => $usuario,
          'colaborador' => $usuario->colaborador,
          'perfil' => $usuario->perfil,
          'status' => $usuario->getStatus($usuario->id),
      ]);
  }

  public function edit($id)
  {
    return view('meuPerfil.edit', [
      'titulo' => "Editar Meus dados",
      'bases' => $this->getBase(),
      'cargos' => $this->getCargo(),
      'empresas' => $this->getEmpresa(),
      'colaborador' => $this->colaborador->findOrFail($id),
    ]);
  }

  public function update(Request $request, $id)
  {
      $colaborador = $this->colaborador->with('cargo', 'empresa')->findOrFail($id);
      $request->validate($colaborador->rules($request, $colaborador), $colaborador->feedback());
      $this->preencherAtributosDoObjeto($request, $colaborador);
      if ($request->editProfile >= 1) {
        return redirect()->route('meuPerfil.index')->with('status', "Registro Atualizado!");
      } else {
        return redirect()->route('colaborador.show', $colaborador->id)->with('status', "Registro Atualizado!");
      }
  }
  
  public function resetarSenhaDoMeuPerfil(Request $request, $id)
  {
    // Validar senha
    $this->user->validarFormulario($request, 'resetPassword');

    // Buscar o usuário pelo ID
    $usuario = $this->user->with('colaborador')->findOrFail($id);

    // Atualizar a senha, se fornecida
    if (!empty($request->password)) {
      $usuario->password = Hash::make($request->password);
      // Salvar as alterações no banco de dados
      $usuario->save();
    }

    // Enviar email de confirmação
    $this->enviarEmail($usuario);

    // Encerrar a sessão do usuário
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirecionar para a página de sucesso
    return redirect()->route('meuPerfil.sucessoSenhaResetada');
  }

  public function sucessoSenhaResetada(){
    return view('meuPerfil.sucessoSenhaResetada');
  }

  private function preencherAtributosDoObjeto(Request $request, $colaborador)
  {
    $colaborador->nome = $request->nome;
    $colaborador->email = $request->email;
    $colaborador->rg = $request->rg;
    $colaborador->cpf = $request->cpf;
    $colaborador->cnpj = $request->cnpj;
    $colaborador->ramal = $request->ramal;
    $colaborador->numero_matricula = $request->numero_matricula;
    $colaborador->base()->associate(Base::findOrFail($request->base_id));
    $colaborador->empresa()->associate(Empresa::findOrFail($request->empresa_id));
    $colaborador->cargo()->associate(Cargo::findOrFail($request->cargo_id));

    if ($request->hasFile('foto')) {
        $destino = $this->path . $colaborador->foto;
        if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
          File::delete($destino);
        }
        $colaborador->foto = $this->CaniveteHelp->upload($request, $this->path);
    } else {
        if ($foto = $this->CaniveteHelp->upload($request, $this->path)) {
            $colaborador->foto = $foto;
        } else {
            $colaborador->foto = 'dummy-round.png';
        }
    }
    $colaborador->save();
  }

  private function enviarEmail($objetoModel)
  {
    $e = new EmailRespostaRecuperarSenha();
    $e->setFrom("desenvolvimento@grupovolpato.com");
    $e->setName($objetoModel->colaborador->nome);
    $e->setEmail($objetoModel->colaborador->email);
    $e->setSubject('Recuperar Senha');
    $e->setToken($objetoModel->tokens);
    $e->enviarEmail();
  }

  private function getBase(){
    return   Base::orderBy('id', 'desc')->get();
  }

  private function getEmpresa(){
     return Empresa::orderBy('id', 'desc')->get();
  }

  private function getCargo(){
     return Cargo::orderBy('id', 'desc')->get();;
  }

  public function show($id)
  {
    return redirect()->route('meuPerfil.index');
  }
}






/*
 public function resetarSenhaDoMeuPerfil(Request $request, $id)
  {
      $this->user->validarFormulario($request, 'resetPassword');
      $usuario = $this->user->with('colaborador')->findOrFail($id);
      if (empty(!$request->password)) {
        $usuario->password = Hash::make($request->password);
      }
      $usuario->update();

      $this->enviarEmail($usuario);

      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();

      return redirect()->route('meuPerfil.sucessoSenhaResetada');
  }
*/