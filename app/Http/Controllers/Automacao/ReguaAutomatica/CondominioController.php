<?php

namespace App\Http\Controllers\Automacao\ReguaAutomatica;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Automacao\ReguaAutomatica\Condominio;

class CondominioController extends Controller
{
  private $_arrayListPermissoesDoModuloDaRota;
  private $_Modelcondominio;

  public function __construct(Condominio $condominio)
  {
    $this->_Modelcondominio = $condominio;
    $this->middleware(function ($request, $next) {
      $this->_arrayListPermissoesDoModuloDaRota = session()->get('permissoesDoModuloDaRota') ? session()->get('permissoesDoModuloDaRota') : [];
      return $next($request);
    });
  }

  public function index()
  {
    $this->ValidarPermissoesDoModuloDaRota('Visualizar');
    $titulo = "Listar Condominio";
    $collerction = Condominio::all();

    return view("automacao.reguaAutomatica.adm.condominio.index", [
      'titulo' => $titulo,
      'collerction' => $collerction,
      'arrayListPermissoesDoModuloDaRota' => $this->_arrayListPermissoesDoModuloDaRota
    ]);
  }

  public function create()
  {
    $titulo = "Cadastrar Condominio, Regua, Tomadas";
    return view("automacao.reguaAutomatica.adm.condominio.create",  ['titulo' => $titulo]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'condominio' => 'required|string',
      'usuario' => 'required|string',
      'senha' => 'required|string',
      'ip' => 'required|string',
      'quantidadeTomada' => 'required',
    ]);

    $this->_Modelcondominio->criarCondominio($request);

    return redirect()->route('condominoController.index')->with('status', "Registrado com sucesso.");
  }

  public function show($id)
  {
    $condominio = Condominio::with('regua')->findOrFail($id);
    $titulo = "Detalhes";
    return view("automacao.reguaAutomatica.adm.condominio.show", [
      'titulo' => $titulo,
      'condominio' => $condominio,
      'arrayListPermissoesDoModuloDaRota' => $this->_arrayListPermissoesDoModuloDaRota
    ]);
  }

  public function edit($id)
  {
    $condominio = $this->_Modelcondominio->with('regua')->find($id);
    $titulo = "Editar Condonio";
    
    return view('automacao.reguaAutomatica.adm.condominio.edit', [
      'titulo' => $titulo,
      'condominio' => $condominio
    ]);
  }
  public function destroy($id)
  {
    try {
      $objetoModel = $this->_Modelcondominio->findOrFail($id);
      $objetoModel->delete();

      return redirect()
        ->back()
        ->with('status', "Registro excluído com sucesso!");
    } catch (\Exception $e) {
     

      // Retornar uma mensagem de erro para o usuário
      return redirect()
        ->back()
        ->with('error', "Erro ao excluir registro. Por favor, tente novamente mais tarde.");
    }
  }

  public function update(Request $request, $id)
  {

    $this->_Modelcondominio->atualizar($request, $id);
    return redirect()->route('condominoController.show', $id)->with('status', "Registro atualizado com sucesso.");
  }

  private function ValidarPermissoesDoModuloDaRota($permissao)
  {
    switch ($permissao) {
      case 'Criar':
        if (!in_array('Criar', $this->_arrayListPermissoesDoModuloDaRota)) {
          return redirect()->route('condominoController.index')->with('error', "Você não tem permissão de cadastro.");
        }
        break;
      case 'Visualizar':
        if (!in_array('Visualizar', $this->_arrayListPermissoesDoModuloDaRota)) {
          return redirect()->route('condominoController.index')->with('error', "Você não tem permissão de Visualização.");
        }
      case 'Editar':
        if (!in_array('Editar', $this->_arrayListPermissoesDoModuloDaRota)) {
          return redirect()->route('condominoController.index')->with('error', "Você não tem permissão de edição.");
        }
        break;
      case 'Excluir':
        if (!in_array('Excluir', $this->_arrayListPermissoesDoModuloDaRota)) {
          return redirect()->route('condominoController.index')->with('error', "Você não tem permissão de excluir.");
        }
        break;
    }
    return true;
  }
}
