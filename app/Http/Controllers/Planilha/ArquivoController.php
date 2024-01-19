<?php 

namespace App\Http\Controllers\planilha;

use Illuminate\Http\Request;
use App\Models\Planilha\Planilha;
use App\Http\Controllers\Controller;

class ArquivoController extends Controller
{
    private $planilha;
    private $titulo;

    public function __construct(Planilha $planilha)
    {
        $this->titulo = "Planilha Arquivada";
        $this->planilha = $planilha;
    }

    /**
     * Exibe a página de planilhas arquivadas.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Obtém planilhas com status 2 (Arquivada) ordenadas por ID em ordem decrescente e paginadas
        $collections = $this->planilha
            ->whereIn('planilha_status_id', [2])
            ->orderBy('id', 'desc')
            ->paginate(10);
        // Retorna a visão (view) 'planilha.administrativo.arquivos' com os dados necessários
        return view('planilha.administrativo.arquivos', [
            'titulo' => $this->titulo, // Título da página
            'collections' => $collections, // Planilhas arquivadas a serem exibidas na view
        ]);
    }

    /**
     * Arquiva uma planilha, alterando seu status para 'Arquivada'.
     *
     * @param  int  $id  Identificador da planilha a ser arquivada.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function arquivar($id)
    {
        // Chama o método privado para atualizar o status da planilha para 'Arquivada'
        $this->updateStatus($id, 2);

        // Redireciona para a página de listagem de planilhas administrativas
        return redirect()->route('comissao.administrativo.index')->with('status', "Planilha Arquivada com sucesso.");
    }

    /**
     * Recupera uma planilha, alterando seu status para 'Recuperada para Homologação'.
     *
     * @param  int  $id  Identificador da planilha a ser recuperada.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function recuperar($id)
    {
        // Chama o método privado para atualizar o status da planilha para 'Recuperada para Homologação'
        $this->updateStatus($id, 5);

        // Redireciona para a página de listagem de planilhas administrativas
        return redirect()->route('comissao.administrativo.index')->with('status', "Planilha Recuperada para Homologação.");
    }

    public function pesquisarPor(Request $request, $origem)
    {
        $collections  = $this->planilha->pesquisarPor($request, $origem);

        // Retorna a visão (view) com os dados necessários
        return view('planilha.administrativo.' . $origem, [
            'titulo' => $this->titulo . " | " . ucfirst($origem), // Título da página
            'collections' => $collections, // Planilhas a serem exibidas na view
        ]);
    }
    
    /**
     * Atualiza o status de uma planilha com base no ID e no novo status fornecido.
     *
     * @param  int  $id  Identificador da planilha a ser atualizada.
     * @param  int  $statusId  Novo identificador de status para a planilha.
     * @return void
     */
    private function updateStatus($id, $statusId)
    {
        // Obtém a planilha existente com base no ID fornecido
        $planilha = $this->planilha->findOrFail($id);

        // Atualiza o status da planilha
        $planilha->planilha_status_id = $statusId;
        $planilha->update();
    }
}
