<?php

namespace App\Http\Controllers\Configuracoes;

use App\Models\Empresa;
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

    /**
     * Cria uma nova instância do controlador.
     *
     * @param Empresa $empresa
     */
    public function __construct(Empresa $empresa)
    {
        $this->empresa = $empresa;
    }

    /**
     * Exibe a lista de empresas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('configuracoes.empresa.index', [
            'collection' => $this->empresa->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Exibe o formulário de criação de uma nova empresa.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return view('configuracoes.empresa.create');
    }

    /**
     * Armazena uma nova empresa no banco de dados.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate($this->empresa->rules('store'), $this->empresa->feedback());
        if ($this->validarDuplicidade($request)) {
            return redirect()->route('empresa.index')
                            ->with('warning', 'Já existe uma empresa com este nome ou CNPJ!');
        }
        $this->empresa->nome = $request->nome;
        $this->empresa->cnpj = $request->cnpj;
        if ($imglogo = $this->empresa->upload($request)) {
            $this->empresa->imglogo  = $imglogo;
        }
        $this->empresa->save();
        return redirect()->route('empresa.index')->with('status', 'Registrado com sucesso!');
    }



    /**
     * Exibe o formulário de edição de uma empresa.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        return view('configuracoes.empresa.edit', [
            'empresa' => Empresa::findOrFail($id)
        ]);
    }

    /**
     * Atualiza uma empresa específica no banco de dados.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validar os dados do request de acordo com as regras definidas na model
        $request->validate($this->empresa->rules('update'), $this->empresa->feedback());
        // Encontrar a empresa no banco de dados pelo ID
        $empresa = $this->empresa->findOrFail($id);
        // Preencher os atributos da empresa com os dados do request
        $empresa->fill([
            'nome' => $request->nome,
            'cnpj' => $request->cnpj,
        ]);
        // Verificar se há uma nova imagem para upload
        if ($request->hasFile('imglogo') && $request->file('imglogo')->isValid()) {
            // Excluir a imagem antiga, se existir
            $this->excluirImagem($empresa->imglogo);
            // Fazer o upload da nova imagem
            $empresa->imglogo = $this->empresa->upload($request);
        }
        // Salvar as alterações no banco de dados
        $empresa->save();
        // Redirecionar de volta à lista de empresas com uma mensagem de sucesso
        return redirect()->route('empresa.index')->with('status', 'Registro Atualizado!');
    }

    /**
     * Exclui uma empresa específica do banco de dados, incluindo a imagem associada.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $empresa = $this->empresa->with('colaboradores')->findOrFail($id);
        if ($empresa->colaboradores->count() >= 1) {
            return redirect()->route('empresa.index')
                            ->with('warning', 'Esta empresa tem colaborador associado e não pode ser excluída.');
        }
        // Excluir a imagem associada se existir
        $this->excluirImagem($empresa->imglogo);
        $empresa->delete();
        return redirect()->route('empresa.index')
                        ->with('status', 'Registro Excluído!');
    }

    /**
     * Exclui uma imagem específica do diretório de uploads.
     *
     * @param string|null $imagemNome
     * @return void
     */
    private function excluirImagem($imagemNome)
    {
        if ($imagemNome) {
            $caminhoImagem = public_path('img/empresa') . '/' . $imagemNome;
            // Verificar se o arquivo existe antes de excluir
            if (file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
        }
    }

    public function show($id)
    {
        return redirect()
            ->route('empresa.index');
    }
}
