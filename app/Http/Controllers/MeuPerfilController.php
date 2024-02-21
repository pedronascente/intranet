<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Colaborador\Base;
use App\Models\Colaborador\Cargo;
use App\Models\Colaborador\Empresa;
use App\Models\Colaborador\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Help\CaniveteHelp;

class MeuPerfilController extends Controller
{

  private $user;
  private $bases;
  private $empresas;
  private $cargos;
  private $path;
  
  public function __construct(User $user)
  {
    $this->user     = $user;
    $this->bases    = Base::orderBy('id', 'desc')->get();
    $this->empresas = Empresa::orderBy('id', 'desc')->get();
    $this->cargos   = Cargo::orderBy('id', 'desc')->get();
    $this->path     = 'img/colaborador/';
  }

  public function index(Request $request)
  {
        if (isset($request->user()->id)) {
            $usuario = $this->user->with('colaborador', 'perfil')->findorFail($request->user()->id);
            return view('meu_perfil.index', [
                'id usuario' => $usuario->id,
                'usuario' => $usuario,
                'colaborador' => $usuario->colaborador,
                'perfil' => $usuario->perfil,
                'status' => $usuario->getStatus($usuario->id),
            ]);
        } else {
            return redirect()->route('login.form');
        }
    }

    public function edit($id)
    {
      return view('meu_perfil.edit', [
        'bases' => $this->bases,
        'cargos' => $this->cargos,
        'empresas' => $this->empresas,
        'colaborador' => Colaborador::findOrFail($id),
      ]);
    }

    public function update(Request $request, $id)
    {
      $colaborador = Colaborador::with('cargo', 'empresa')->findOrFail($id);
      $request->validate($colaborador->rules($request, $colaborador), $colaborador->feedback());
      $this->preencherAtributosDoObjeto($request, $colaborador);
      if ($request->editProfile >= 1) {
        return redirect()
          ->route('meuPerfil.index')
          ->with('status', "Registro Atualizado!");
      } else {
        return redirect()
          ->route('colaborador.show', $colaborador->id)
          ->with('status', "Registro Atualizado!");
      }
    }

    private function preencherAtributosDoObjeto(Request $request, $colaborador)
    {
      $colaborador->nome = $request->nome;
      $colaborador->sobrenome = $request->sobrenome;
      $colaborador->email = $request->email;
      $colaborador->rg = $request->rg;
      $colaborador->cpf = $request->cpf;
      $colaborador->cnpj = $request->cnpj;
      $colaborador->ramal = $request->ramal;
      $colaborador->numero_matricula = $request->numero_matricula;
      $colaborador->base()->associate(Base::findOrFail($request->base_id));
      $colaborador->empresa()->associate(Empresa::findOrFail($request->empresa_id));
      $colaborador->cargo()->associate(Cargo::findOrFail($request->cargo_id));

      $CaniveteHelp = new CaniveteHelp();

      if ($request->hasFile('foto')) {
          $destino = $this->path . $colaborador->foto;
          if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
            File::delete($destino);
          }
          $colaborador->foto = $CaniveteHelp->upload($request, $this->path);
      } else {
          if ($foto = $CaniveteHelp->upload($request, $this->path)) {
              $colaborador->foto = $foto;
          } else {
              $colaborador->foto = 'dummy-round.png';
          }
      }
      $colaborador->save();
    }
}