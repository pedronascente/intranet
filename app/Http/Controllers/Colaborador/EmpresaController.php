<?php

namespace App\Http\Controllers\Colaborador;;

use App\Models\Colaborador\Empresa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmpresaController extends Controller
{
    /**
     * Instância da Empresa
     * 
     * @var Empresa
     */
    private $empresa;

   
    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    public function index()
    {
         return view('empresa.index', [
            "titulo"=>"Listar Empresa",
            'arrayListEmpresa' => $this->empresa->getEmpresaOrderByIdDesc(),
        ]);
    }

    public function create()
    {
        if (!$this->validarpermissao('Criar')) {
            return redirect()->back();
        }
  
        return view('empresa.create', ['titulo' => "Cadastrar Empresa"]);
    }

    public function store(Request $request)
    {
        $request->validate($this->empresa->rules('store'), $this->empresa->feedback());
        if ($this->empresa->validarDuplicidade($request)) {
            return redirect()->route('empresa.index')->with('warning', 'Já existe uma empresa com este nome ou CNPJ!');
        }

        $this->empresa->nome = $request->nome;
        $this->empresa->cnpj = $request->cnpj;

        if ($imglogo = $this->empresa->upload($request)) {
            $this->empresa->imglogo = $imglogo;
        }
        $this->empresa->save();
        return redirect()->route('empresa.index')->with('status', 'Registrado com sucesso!');
    }

    public function edit($id)
    {
        if (!$this->validarpermissao('Editar')) {
            return redirect()->back();
        }
        return view('empresa.edit', [
            "titulo" => "Editar Empresa",
            "empresa" => $this->empresa->findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->empresa->rules('update'), $this->empresa->feedback());
        $empresa = $this->empresa->findOrFail($id);
        $empresa->fill([
            'nome' => $request->nome,
            'cnpj' => $request->cnpj,
        ]);
        if ($request->hasFile('imglogo') && $request->file('imglogo')->isValid()) {
            $this->excluirImagem($empresa->imglogo);
            $empresa->imglogo = $this->empresa->upload($request);
        }
        $empresa->save();
        return redirect()->route('empresa.index')->with('status', 'Registro Atualizado!');
    }

    public function destroy($id)
    {
        if (!$this->validarpermissao('Excluir')) {
            return redirect()->back();
        }
   
        $empresa = $this->empresa->with('colaboradores')->findOrFail($id);
        if ($empresa->colaboradores->count() >= 1) {
            return redirect()->route('empresa.index')->with('warning', 'Esta empresa tem colaborador associado e não pode ser excluída.');
        }
        $this->excluirImagem($empresa->imglogo); // Excluir a imagem associada se existir
        $empresa->delete();
        return redirect()->route('empresa.index')->with('status', 'Registro Excluído!');  
    }

    private function excluirImagem($imagemNome)
    {
        if ($imagemNome) {
            $caminhoImagem = public_path('img/empresa') . '/' . $imagemNome;
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }
    }

    public function show($id)
    {
        return redirect()->route('empresa.index');
    }    
} 
