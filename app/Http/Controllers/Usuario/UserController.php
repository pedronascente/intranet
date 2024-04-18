<?php

namespace App\Http\Controllers\Usuario;

use App\Models\User;
use App\Models\Token;
use App\Models\Perfil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        return view('usuario.index', [
            'titulo' => "Listar Usuários",
            'arrayListUsuario' => $this->user->getUsuarioESeuPerfil($request->filtro),
        ]);
    }

    public function create()
    {
        
        if (!$this->validarpermissao('Criar')) {
            return redirect()->back();
        }

        return view('usuario.create', [
            'titulo' => 'Cadastrar usuário',
            'perfis' => Perfil::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->user->validarFormulario($request, 'post');
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
        if (!$this->validarpermissao('Editar')) {
            return redirect()->back();
        }
        return view('usuario.edit', [
            'titulo' => "Editar usuário",
            'user' => $this->user->findOrFail($id),
            'perfis' => Perfil::orderBy('id', 'desc')->get()
        ]);   
    }

    public function update(Request $request, $id)
    {
        if($id  == 1  &&  $request->perfil != 1){
            return redirect()->route('usuario.index')->with("error", "Este usuario é o administrador, portanto não pode ter seu perfil alterado!");
        }

        $this->user->validarFormulario($request,'put');
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
        if (!$this->validarpermissao('Visualizar')) {
            return redirect()->back();
        }
        $titulo = "Visualizar usuário";
        $usuario = $this->user->with('perfil', 'colaborador', 'tokens')->findOrFail($id);
        $status = $usuario->getStatus($id);

        return view('usuario.show', [
            'titulo' => $titulo,
            'usuario' => $usuario,
            'status' => $status,
        ]);
    }

    public function destroy($id)
    {
        if (!$this->validarpermissao('Excluir')) {
            return redirect()->back();
        }
        $usuario = $this->user->with('colaborador')->findOrFail($id);
        if (!empty($usuario->colaborador)) {
            return redirect()->route('usuario.index')->with('warning', "Não foi possivel escluir!, Este usuario está sendo associado a um colaborador.");
        }
        $usuario->delete();
        return redirect()->route('usuario.index')->with('status', "Registro excluido com sucesso!");    
    }
}