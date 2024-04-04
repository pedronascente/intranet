@extends('layouts.app')

@section('titulo', $titulo)

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">
            <a href="{{ route('cliente.index') }}">cliente</a>
        </li>
    </ol>
@endsection

@section('content')
    <div class="card p-3">
          
        @include('cliente.cliente.cliente_cpf') 
         
        <div class="card">
            <div class="card-header">
              <h4> Documentos</h4>
          </div>
            <div class="card-body">
                 <form action="{{ route('documento.store') }}" method="POST">
                    @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo de pessoa:</label>
                                        <select name="estado_civil" class="custom-select ">
                                            <option value="">Selecione...</option>
                                            <option value="casado">Fisica</option>
                                            <option value="solteiro" selected="">Juridica</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tipo documento:</label>
                                        <select name="estado_civil" class="custom-select ">
                                                <option value="">Selecione ...</option>
                                                <option value="consulta">Consulta</option>
                                                <option value="contrato_assinado">Contrato Assinado</option>
                                                <option value="alteracao_contratual">Alteração Contratual</option>
                                                <option value="carta_cancelamento">Carta de Cancelamento</option>
                                                <option value="certidao_casamento">Certidão de Casamento</option>
                                                <option value="certificado_uniao_estavel">Certificado de União Estável</option>
                                                <option value="cnh">CNH</option>
                                                <option value="cnpj">CNPJ</option>
                                                <option value="comprovante_endereco">Comprovante de Endereço</option>
                                                <option value="comprovante_pagamento">Comprovante de Pagamento</option>
                                                <option value="contrato_social">Contrato Social</option>
                                                <option value="correio">Correio</option>
                                                <option value="cotacao">Cotação</option>   
                                                <option value="cpf">CPF</option>
                                                <option value="crlv_documento_provisorio">CRLV - Documento Provisório</option>
                                                <option value="crlv">CRLV</option>
                                                <option value="declaracao_endereco">Declaração de Endereço</option>
                                                <option value="detran">Detran</option>
                                                <option value="dispensa_vistoria">Dispensa de vistoria</option>
                                                <option value="email">Email</option>
                                                <option value="endereco_entrega">Endereço de Entrega</option>
                                                <option value="nota_fiscal">Nota Fiscal</option>
                                                <option value="procuracao">Procuração</option>
                                                <option value="proposta">Proposta</option>  
                                                <option value="requerimento_empresario">Requerimento de Empresário</option>
                                                <option value="rg_frente">RG Frente</option>
                                                <option value="rg_verso">RG Verso</option>
                                                <option value="tabela_fipe">Tabela FIPE</option>
                                                <option value="termo_ciencia">Termo de Ciência</option>
                                                <option value="validacao_cartao">Validação do Cartão</option>	
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="customFile">Documento:</label>
                                        <div class="custom-file">
                                            <input type="file" name="foto" class="custom-file-input" id="customFile" value="">
                                            <label class="custom-file-label" for="customFile"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <x-botao.btn-salvar />
                             <x-botao.btn-voltar :rota="route('documento.index')" />
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection


































