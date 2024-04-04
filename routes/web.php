<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Contrato\ContratoRastreamentoController;

use App\Http\Controllers\MeuPerfilController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Login\TokenController;
use App\Http\Controllers\Usuario\UserController;

use App\Http\Controllers\Cliente\SocioController;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Cliente\ContatoController;
use App\Http\Controllers\Cliente\VeiculoController;
use App\Http\Controllers\Cliente\EnderecoController;

use App\Http\Controllers\Colaborador\BaseController;
use App\Http\Controllers\Colaborador\CargoController;
use App\Http\Controllers\Comissao\PlanilhaController;
use App\Http\Controllers\Colaborador\EmpresaController;

use App\Http\Controllers\Cliente\DocumentacaoController;
use App\Http\Controllers\Configuracoes\ModuloController;
use App\Http\Controllers\Configuracoes\PerfilController;

use App\Http\Controllers\Usuario\RecuperarSenhaController;
use App\Http\Controllers\Colaborador\ColaboradorController;
use App\Http\Controllers\Configuracoes\PermissaoController;
use App\Http\Controllers\Configuracoes\ConfiguracaoController;

use App\Http\Controllers\Comissao\Administrativo\ArquivoController;
use App\Http\Controllers\Comissao\Planilhas\EntregaDeAlarmeController;
use App\Http\Controllers\Comissao\Planilhas\PortariaVirtualController;
use App\Http\Controllers\Comissao\Planilhas\ReclamacaoDeClienteController;
use App\Http\Controllers\Comissao\Administrativo\ImprimirPlanilhaController;
use App\Http\Controllers\Comissao\Planilhas\TecnicaDeRastreamentoController;
use App\Http\Controllers\Comissao\Planilhas\PlanilhaTipoColaboradorController;
use App\Http\Controllers\Comissao\Administrativo\AdministrarComissaoController;
use App\Http\Controllers\Comissao\Planilhas\PlanilhaTipoAdministrativoController;
use App\Http\Controllers\Comissao\Planilhas\ComercialRastreamentoVeicularController;
use App\Http\Controllers\Comissao\Planilhas\SupervisaoComercialRastreamentoController;
use App\Http\Controllers\Comissao\Planilhas\TecnicaAlarmesCercaEletricaCFTVController;
use App\Http\Controllers\Comissao\Planilhas\ComercialAlarmeCercaEletricaCFTVController;
use App\Http\Controllers\Comissao\Planilhas\SupervisaoComercialAlarmesCercaEletricaCFTVController;
use App\Http\Controllers\Comissao\Administrativo\RelatorioController as PlanilhaRelatorioController;
use App\Http\Controllers\Comissao\Planilhas\SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController;

Route::prefix('/login')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login.form');
    Route::get('/logout', [LoginController::class, 'logout'])->name('login.sair');
    Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->prefix('/token')->group(function () {
    Route::get('/', [TokenController::class, 'create'])->name('token.create');
    Route::post('/', [TokenController::class, 'store'])->name('token.store');
    Route::get('/get-posicao-token', [TokenController::class, 'getPosicaoToken']);
});

Route::middleware(['auth','validarToken'])->group(function () {
    Route::redirect('/', '/dashboard', 301);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::middleware([
        'ValidarPermissaoDeRota:configuracoes',
        'AtivarDesativarModuloECategoria:configuracoes'
    ])->get('/configuracoes', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');
});

Route::middleware([
    'auth', 
    'validarToken'
    ])->group(function () {
        Route::middleware([
            'ValidarPermissaoDeRota:colaborador',
            'AtivarDesativarModuloECategoria:colaborador'
        ])->resource('/colaborador', ColaboradorController::class);

        Route::middleware([
            'ValidarPermissaoDeRota:cargo',
            'AtivarDesativarModuloECategoria:cargo'
        ])->resource('/cargo', CargoController::class);
        
        Route::middleware([
            'ValidarPermissaoDeRota:empresa',
            'AtivarDesativarModuloECategoria:empresa'
        ])->resource('/empresa', EmpresaController::class);

        Route::middleware([
            'ValidarPermissaoDeRota:base', 
            'AtivarDesativarModuloECategoria:base'
        ])->resource('/base', BaseController::class);

        Route::middleware([
            'ValidarPermissaoDeRota:permissao', 
            'AtivarDesativarModuloECategoria:permissao'
        ])->resource('/permissao', PermissaoController::class);

        Route::middleware([
            'ValidarPermissaoDeRota:modulo',
            'AtivarDesativarModuloECategoria:modulo'
        ])->resource('/modulo', ModuloController::class);

        Route::middleware([
            'ValidarPermissaoDeRota:usuario', 
            'AtivarDesativarModuloECategoria:usuario'
        ])->resource('/usuario', UserController::class);
        
        Route::middleware([
            'ValidarPermissaoDeRota:perfil', 
            'AtivarDesativarModuloECategoria:perfil'
        ])->group(function () {
            Route::resource('/perfil', PerfilController::class);
            Route::get('perfil/desativar/{id}', [PerfilController::class, 'desativar'])->name('perfil.desativar');
        });      
});

Route::prefix('/meuperfil')->group(function () {
    Route::get('/', [MeuPerfilController::class, 'index'])->name('meuPerfil.index');
    Route::get('/{id}/edit', [MeuPerfilController::class, 'edit'])->name('meuPerfil.edit');
    Route::put('/{id}', [MeuPerfilController::class, 'update'])->name('meuPerfil.update');
    Route::get('/{id}', [MeuPerfilController::class, 'show']);
    Route::put('/resetar-senha/{id}', [MeuPerfilController::class, 'resetarSenhaDoMeuPerfil'])->name('meuPerfil.resetarSenha');
    Route::get('/sucesso', [MeuPerfilController::class, 'sucessoSenhaResetada'])->name('meuPerfil.sucessoSenhaResetada');
});
 
Route::prefix('/recuperar-senha')->group(function () {
    Route::get('/', [RecuperarSenhaController::class, 'informarEmailRecuperarSenha'])->name('recuperarSenha.informarEmailRecuperarSenha');
    Route::post('/', [RecuperarSenhaController::class, 'enviarEmailRecuperarSenha'])->name('recuperarSenha.enviarEmailRecuperarSenha');
    Route::get('/sucesso', [RecuperarSenhaController::class, 'sucessoEnviarEmailRecuperarSenha'])->name('recuperarSenha.sucessoEnviarEmailRecuperarSenha');
    Route::get('/{email}/{token}', [RecuperarSenhaController::class, 'cadastrarNovaSenha'])->name('recuperarSenha.cadastrarNovaSenha');
    Route::get('/{id}', [RecuperarSenhaController::class, 'show'])->name('recuperarSenha.show');
    Route::put('/{id}', [RecuperarSenhaController::class, 'resetarMinhaSenhaDeUsuario'])->name('recuperarSenha.resetarMinhaSenhaDeUsuario');
    Route::get('success/', [RecuperarSenhaController::class, 'sucessoSenhaRecuperada'])->name('recuperarSenha.sucessoSenhaRecuperada');
});

Route::middleware([
    'ValidarPermissaoDeRota:lancar-comissao',
    'AtivarDesativarModuloECategoria:lancar-comissao'
    ])->group(function () {
    //planililha:
    Route::resource('/planilha', PlanilhaController::class);
    Route::get('/planilha{planilha}/homologar', [PlanilhaController::class, 'homologar'])->name('planilha.homologar');
    Route::prefix('/comissao')->group(function () {
        Route::get('/', function () {
            return redirect()->route('planilha.index');
        });
        //pesquisar colaborador:   
        Route::prefix('/pesquisar')->group(function () {
            Route::get('/', [ColaboradorController::class, 'createPesquisar'])->name('colaborador.pesquisar');
            Route::get('/resultado', [ColaboradorController::class, 'showPesquisar'])->name('colaborador.showPesquisar');
        });
        //comissoes:
        Route::get('/{id}/plailha', [PlanilhaTipoColaboradorController::class, 'index'])->name('planilha-colaborador-tipo.index');
        Route::resource('/reclamacao-de-cliente', ReclamacaoDeClienteController::class);
        Route::resource('/entrega-de-alarme', EntregaDeAlarmeController::class);
        Route::resource('/supervisao-cace-cftv', SupervisaoComercialAlarmesCercaEletricaCFTVController::class);
        Route::resource('/supervisao-c-r', SupervisaoComercialRastreamentoController::class);
        Route::resource('/tecnica-de-rastreamento', TecnicaDeRastreamentoController::class);
        Route::resource('/stsace-cftv', SupervisaoTecnicaESacAlarmesCercaEletricaCFTVController::class);
        Route::resource('/portaria-virtual', PortariaVirtualController::class);
        Route::resource('/cace-cftv', ComercialAlarmeCercaEletricaCFTVController::class);
        Route::resource('/comercial-rastreamento-veicular', ComercialRastreamentoVeicularController::class);
        Route::resource('/tecnica-ace-cftv', TecnicaAlarmesCercaEletricaCFTVController::class);
    });
});

Route::middleware([
    'ValidarPermissaoDeRota:administrar-comissao', 
    'AtivarDesativarModuloECategoria:administrar-comissao'
    ])->group(function () {
    Route::prefix('/comissao-administrativo')->group(function () {
        Route::get('/', function () {
            return redirect()->route('comissao.administrativo.index');
        });
        Route::name('comissao.')->group(function () {
            Route::resource('/administrativo', AdministrarComissaoController::class);
            Route::name('administrativo.')->group(function () {
                Route::prefix('/arquivos')->group(function () {
                    Route::get('/', [ArquivoController::class, 'index'])->name('arquivo.index');
                    Route::get('/{id}/recuperar', [ArquivoController::class, 'recuperar'])->name('arquivo.recuperar');
                    Route::get('/{id}/arquivar', [ArquivoController::class, 'arquivar'])->name('arquivo.arquivar');
                });
                Route::prefix('/planilha')->group(function () {
                    Route::get('/{id}/reprovar', [AdministrarComissaoController::class, 'editReprovar'])->name('reprovar');
                    Route::put('/{id}', [AdministrarComissaoController::class, 'updateReprovar'])->name('reprovarUpdate');
                });
                Route::get('/imprimir-pdf/{id}', [ImprimirPlanilhaController::class, 'imprimirPDF'])->name('imprimirPDF');
                Route::get('{id}/planilha', [PlanilhaTipoAdministrativoController::class, 'index'])->name('tipoAdministrativo.index');
                Route::get('relatorio/buscar', [PlanilhaRelatorioController::class, 'getRelatorio'])->name('relatorio');
                Route::get('{planilha}/{comissao}/editarComissaoAdministrativo', [AdministrarComissaoController::class, 'editarComissaoAdministrativo'])->name('editarComissaoAdministrativo'); 
            });
        });
    });
});


Route::middleware([
    'ValidarPermissaoDeRota:cliente',
    'AtivarDesativarModuloECategoria:cliente'
])->resource('/cliente', ClienteController::class);

Route::middleware([
    'ValidarPermissaoDeRota:contato',
    'AtivarDesativarModuloECategoria:contato'
])->resource('/contato', ContatoController::class);

Route::middleware([
    'ValidarPermissaoDeRota:endereco',
    'AtivarDesativarModuloECategoria:endereco'
])->resource('/endereco', EnderecoController::class);

Route::middleware([
    'ValidarPermissaoDeRota:veiculo',
    'AtivarDesativarModuloECategoria:veiculo'
])->resource('/veiculo', VeiculoController::class);

Route::middleware([
    'ValidarPermissaoDeRota:documentacao',
    'AtivarDesativarModuloECategoria:documentacao'
])->resource('/documento', DocumentacaoController::class);

Route::middleware([
    'ValidarPermissaoDeRota:socio',
    'AtivarDesativarModuloECategoria:socio'
])->resource('/socio', SocioController::class);


Route::middleware([
    'ValidarPermissaoDeRota:contrato',
    'AtivarDesativarModuloECategoria:contrato'
])->resource('/contrato',ContratoRastreamentoController::class);