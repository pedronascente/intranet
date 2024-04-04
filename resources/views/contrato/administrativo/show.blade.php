@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('contrato.index') }}">Contrato</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
        <div class="card card-primary">
            <div class="card-header">
               CLIENTE
            </div>
            <div class="card-body">
               <div class="table-responsive p-0">

               
                    <table class="table table-bordered  table-striped">
                        <tr>
                            <td><b> DADOS DO CLIENTE</b> </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td><b>Tipo Pessoa:</b> Fisica</td>
                            <td><b>Nome/Razão Social:</b> CANDIDO JAURI DE BASTOS</td>
                            <td><b>CPF/CNPJ:</b> 555.813.230-20</td>
                        </tr>
                        <tr>
                            <td><b>Insc. Municipal:</b> NÃO POSSUI</td>
                            <td><b>RG / Insc. Estadual:</b> 9037345701</td>
                            <td><b>Estado Civil:</b>  casado</td>
                        </tr>
                    </table>
                    
                    <table class="table table-bordered  table-striped">
                        <tr>
                            <td><b>CONTATOS</b> </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td colspan="3"><b>1°Contato:</b> CANDIDO</td>
                        </tr>
                        <tr>
                            <td><b>E-mail:</b> candido.ct@gmail.com</td>
                            <td><b>Telefone1:</b> (51)99966-8039</td>
                            <td><b>Telefone2:</b> (51)99966-8039</td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>2°Contato:</b> CANDIDO</td>
                        </tr>
                        <tr>
                            <td><b>E-mail:</b> candido.ct@gmail.com</td>
                            <td><b>Telefone1:</b> (51)99966-8039</td>
                            <td><b>Telefone2:</b> (51)99966-8039</td>
                        </tr>
                    </table>
                    <table class="table table-bordered  table-striped">
                        <tr>
                            <td><b> ENDEREÇO</b> </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td><b>CEP:</b>  94858-530</td>
                            <td><b>UF:</b> RS</td>
                            <td></td>
                        </tr>
                      
                        <tr>
                            <td><b>Endereço</b> R CATURRITAS</td>
                            <td></td>
                            <td><b>Numero:</b> 605</td>
                        </tr>
                        <tr>
                            <td><b>Cidade:</b> ALVORADA</td>
                            <td><b>Bairro:</b> JARDIM ALGARVE</td>
                            <td><b>Complemento:</b> </td>
                        </tr>
                    </table>

                    <table class="table table-bordered  table-striped">
                        <tr>
                            <td><b> VEÍCULOS:</b> </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        @for ($i=0; $i<2; $i++)
                       
                            <tr>
                                <td><b>Placa:</b>            IYA9597</td>
                                <td><b>Chassi:</b>           93HGH8860JZ110686</td>
                                <td><b>Marca / Modelo :</b>  HONDA/WR-V EXL CVT</td>
                            </tr>
                            <tr>
                                <td><b>Renavan:</b> 01128449851</td>
                                <td><b>Ano: </b>    17/18</td>
                                <td><b>Cor:</b>     BRANCA</td>
                            </tr>
                            <tr>
                                <td><b>Bateria:</b>      12V</td>
                                <td><b>Bloqueio:</b>     SIM</td>
                                <td><b>Combustivel:</b>  Bicombustível</td>
                            </tr>
                           
                            <tr>
                                <td><b>Serviço:</b>           RASTREAMENTO</td>
                                <td><b>Taxa mensal:</b>       R$69.00</td>
                                <td><b>Taxa Habilitação:</b>  R$78.90</td>
                            </tr>
                            <tr>
                                <td><b>Sserviço:</b> ASSISTÊNCIA VEICULAR</td>
                                <td><b>Taxa mensal:</b> R$69.00</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                            </tr>
                            
                        @endfor
                    </table>
                    
                    <table class="table table-bordered  table-striped">
                        <tr>
                            <td><b>CONTRATO</b> </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td><b>Tipo de contrato:</b> Comodato</td>
                            <td><b>Vigência:</b>  12 meses</td>
                            <td></td>
                        </tr>
                    </table>

                    <table class="table table-bordered  table-striped">
                        <tr>
                            <td><b>FORMA DE PAGAMENTO</b> </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <td><b>Taxa Habilitação:</b> BOLETO</td>
                            <td><b>Data:</b>  00/00/2024</td>
                        </tr>
                        <tr>
                            <td><b>Taxa Mensalidade:</b> BOLETO</td>
                            <td><b>Melhor dia de Pagamento:</b>  12</td>
                        </tr>
                    </table>

                    <table class="table table-bordered  table-striped">
                        <tr>
                            <td><b>TAXA DE SERVIÇOS</b> </td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr class="text-center">
                            <td><b>TAXA DE HABILITAÇÃO</b></td>
                            <td><b>MENSALIDADE</b></td>
                        </tr>
                        <tr>
                            <td class="p-0">
                                <table class="table table-bordered  ">
                                    <tr><td><b>Qtd. Veículo : </b> 2</td></tr>
                                   
                                    <tr><td><b>Data : </b>00/00/2024</td></tr>
                                     <tr><td><b>Valor total : </b> R$ 54.545</td></tr>
                                </table>
                            </td>
                       
                             <td class="p-0">
                                <table class="table table-bordered">
                                    <tr><td><b>Qtd. Veículo:</b> 2</td></tr>
                                    <tr><td><b>Rastreador veícular:</b> R$ 69.00</td></tr>
                                    <tr><td><b>Assistência veícular:</b> R$ 46.00</td></tr>
                                    <tr><td><b>Valor total:</b> R$ 115.00</td></tr>
                                    <tr><td><b>Melhor dia pagamento:</b> R$ 115.00</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                     <table class="table table-bordered  table-striped">
                        <tr>
                            <td><b>DÓC. ANEXO</b> </td>
                        </tr>
                    </table>
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th>Arquivo</th>
                                <th>Número Contrato</th>
                                <th>Descrição</th>
                                <th>Tipo Pessoa</th>
                                <th width="5%" class="text-center">Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                <img src="https://blog.usezapay.com.br/wp-content/uploads/2022/10/cnhmineiro.webp" width="50">
                                </td>
                                <td>00012</td>
                                <td>CARTA_CANCELAMENTO</td>
                                <td>Fisica</td>
                                <td>
                                <a href="" class="btn btn-sm btn-dark" title="Baixar">
                                        Baixar
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <img src="https://blog.usezapay.com.br/wp-content/uploads/2022/10/cnhmineiro.webp" width="50">
                                </td>
                                <td>00012</td>
                                <td>CARTA_CANCELAMENTO</td>
                                <td>Fisica</td>
                                <td>
                                <a href="" class="btn btn-sm btn-dark" title="Baixar">
                                        Baixar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="" class="btn btn-sm btn-dark" title="Baixar">
                    Imprimir
                </a>
                <a href="" class="btn btn-sm btn-danger" title="Baixar">
                    Reprovar
                </a>
            </div>
        </div>  
    </div>
@endsection
