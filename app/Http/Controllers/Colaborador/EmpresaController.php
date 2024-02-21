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

    private $arrayListPermissoesDoModuloDaRota;

    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
        $this->middleware(function ($request, $next) {
            $this->arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota');
            return $next($request);
        });
    }

    public function index()
    {
        $arrayListEmpresa = $this->empresa->orderBy('id', 'desc')->paginate(10);
        return view('empresa.index', [
            'arrayListEmpresa' => $arrayListEmpresa,
            'arrayListPermissoesDoModuloDaRota' => $this->arrayListPermissoesDoModuloDaRota,
        ]);
    }

    public function create()
    {
        if (in_array('Criar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo = "Cadastrar Empresa";
            return view('empresa.create', ['titulo' => $titulo]);
        } else {
            return redirect()->route('empresa.index')->with('error', "Você não Tem Permissão de Cadastro.");
        } 
    }

    public function store(Request $request)
    {
        $request->validate($this->empresa->rules('store'), $this->empresa->feedback());
        if ($this->validarDuplicidade($request)) {
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
        if (in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
            $titulo  = "Editar Empresa";
            $Empresa = Empresa::findOrFail($id);
            return view('empresa.edit', [
                'empresa' => $Empresa,
                'titulo' => $titulo,
            ]);
        } else {
            return redirect()->route('empresa.index')->with('error', "Você não Tem Permissão de Edição.");
        } 
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
        if (in_array('Editar', $this->arrayListPermissoesDoModuloDaRota)) {
            $empresa = $this->empresa->with('colaboradores')->findOrFail($id);
            if ($empresa->colaboradores->count() >= 1) {
                return redirect()->route('empresa.index')->with('warning', 'Esta empresa tem colaborador associado e não pode ser excluída.');
            }
            $this->excluirImagem($empresa->imglogo); // Excluir a imagem associada se existir
            $empresa->delete();
            return redirect()->route('empresa.index')->with('status', 'Registro Excluído!');
        } else {
            return redirect()->route('empresa.index')->with('error', "Você não Tem Permissão de Excluir.");
        }    
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
