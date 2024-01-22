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

    public function index(Request $request)
    {
        $arrayPlanilhaStatusId = [2];
        if ($request->query('ano') || $request->query('filtro')) {
            $collections = $this->planilha->getPlanilha($request, $arrayPlanilhaStatusId);
        } else {
            $collections = $this->planilha
                ->whereIn('planilha_status_id', $arrayPlanilhaStatusId)
                ->orderBy('id', 'desc')
                ->paginate(10); 
        }
        return view('planilha.administrativo.arquivos', [
            'titulo'      => $this->titulo,
            'collections' => $collections,
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
    
    /**
     * Atualiza o status de uma planilha com base no ID e no novo status fornecido.
     *
     * @param  int  $id  Identificador da planilha a ser atualizada.
     * @param  int  $statusId  Novo identificador de status para a planilha.
     * @return void
     */
    private function updateStatus($id, $statusId)
    {
        $planilha = $this->planilha->findOrFail($id);
        $planilha->planilha_status_id = $statusId;
        $planilha->update();
    }
}
