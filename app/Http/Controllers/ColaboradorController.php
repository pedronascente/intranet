<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Colaborador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ColaboradorController extends Controller
{
    public function index()
    {
        $collection = Colaborador::orderBy('id', 'desc')->paginate(10);
        return view('colaborador.index', ['collection' => $collection]);
    }

    public function create()
    {
        $empresas = Empresa::orderBy('id', 'desc')->get();
        $cargos = Cargo::orderBy('id', 'desc')->get();
        return view('colaborador.create', [
            'empresas' => $empresas,
            'cargos' => $cargos,
        ]);
    }

    public function store(Request $request)
    {
        if ($this->validarFormulario($request)) {
            return redirect()
                ->back()
                ->withInput($request->all());
        } else {
            $colaborador = new Colaborador();
            $colaborador->nome = $request->nome;
            $colaborador->sobrenome = $request->sobrenome;
            $colaborador->email = $request->email;
            $colaborador->rg = $request->rg;
            $colaborador->cpf = $request->cpf;
            $colaborador->cnpj = $request->cnpj;
            $colaborador->cargo_id = $request->cargo_id;
            $colaborador->empresa_id = $request->empresa_id;
            if ($foto = $this->upload($request)) {
                $colaborador->foto = $foto;
            } else {
                $colaborador->foto = 'dummy-round.png';
            }
            $colaborador->save();
            return redirect()
                ->action('App\Http\Controllers\ColaboradorController@index')
                ->with('status', "Registrado com sucesso!");
        }
    }

    public function show($id)
    {
        $c = Colaborador::findOrFail($id);
        return view('colaborador.show', ['colaborador' => $c]);
    }

    public function edit($id)
    {
        $colaboraodor = Colaborador::findOrFail($id);
        $empresas = Empresa::orderBy('id', 'desc')->get();
        $cargos = Cargo::orderBy('id', 'desc')->get();
        return view('colaborador.edit', [
            'colaborador' => $colaboraodor,
            'empresas' => $empresas,
            'cargos' => $cargos,
        ]);
    }

    public function update(Request $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->nome = $request->nome;
        $colaborador->sobrenome = $request->sobrenome;
        $colaborador->email = $request->email;
        $colaborador->rg = $request->rg;
        $colaborador->cpf = $request->cpf;
        $colaborador->cnpj = $request->cnpj;
        $colaborador->cargo_id = $request->cargo_id;
        $colaborador->empresa_id = $request->empresa_id;
        if ($request->hasFile('foto')) {
            $destino = 'img/colaborador/' . $colaborador->foto;
            if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
                File::delete($destino);
            }
            $colaborador->foto = $this->upload($request);
        }
        $colaborador->update();
        return redirect()
            ->action('App\Http\Controllers\ColaboradorController@index')
            ->with('status', "Registro Atualizado!");
    }

    public function createAssociar($id)
    {
        $colaboraodor = Colaborador::findOrFail($id);
        //retornar todos os usuarios que ainda não estão relacionados.
        $users = User::with('colaborador')->get();
        return view('colaborador.associar', [
            'colaborador' => $colaboraodor,
            'users' => $users,
        ]);
    }

    public function updateAssociar(Request $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->user_id = $request->user_id;
        $colaborador->update();
        return redirect(route('colaborador.show', $colaborador->id))
            ->with('status', "Usuário Foi associado com sucesso!");
    }

    public function destroyAssociacao($id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->user_id = null;
        $colaborador->update();
        return redirect(route('colaborador.show', $colaborador->id))
            ->with('status', "Usuário Foi desassociado com sucesso!");
    }

    public function destroy($id)
    {
        $colaborador = Colaborador::with('user')->findOrFail($id);
        if ($colaborador->user) {
            return redirect()
                ->action('App\Http\Controllers\ColaboradorController@show', $id)
                ->with('warning', "Este colaborador tem Usuário associado, por tanto não pode ser excluida.");
        }
        $destino = 'img/colaborador/' . $colaborador->foto;
        if ($colaborador->foto != 'dummy-round.png' && File::exists($destino)) {
            File::delete($destino);
        }
        $colaborador->delete();
        return redirect()
            ->action('App\Http\Controllers\ColaboradorController@index')
            ->with('status', "Registro Excluido!");
    }
    private function upload(Request $request)
    {
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $requestImagem = $request->foto;
            $extension = $requestImagem->extension();
            $imagemName = md5($requestImagem->getClientOriginalName() . strtotime('now')) . '.' . $extension;
            $requestImagem->move(public_path('img/colaborador'), $imagemName);
            return $imagemName;
        }
        return false;
    }

    private function validarFormulario(Request $request)
    {
        $request->validate(
            [
                'nome' => 'required|max:191|min:5',
                'sobrenome' => 'required|max:191|min:5',
                'email' => 'required|email',
                'rg' => 'required|max:15',
                'cpf' => 'required|max:14',
                'empresa_id' => 'required',
                'cargo_id' => 'required',
            ],
            [
                'nome.required' => 'Campo obrigatório.',
                'sobrenome.required' => 'Campo obrigatório.',
                'email.required' => 'Digite um e-mail válido',
                'rg.required' => 'Campo obrigatório.',
                'cpf.required' => 'Campo obrigatório.',
                'empresa_id.required' => 'Campo obrigatório.',
                'cargo_id.required' => 'Campo obrigatório.',
            ]
        );
    }
}
