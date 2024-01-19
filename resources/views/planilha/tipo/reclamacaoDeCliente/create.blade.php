 <form action="{{ route('reclamacao-de-cliente.store') }}" method="POST" name="formulario-create">
     <input type="hidden" name="planilha_id" value="{{ $planilha->id }}">
     @csrf
     <div class="card-body">
         <div class="row">
             <div class="col-md-10">
                 <div class="form-group">
                     <label>Cliente:</label>
                     <input type="text" name="cliente" maxlength="190"
                         class="form-control @error('cliente') is-invalid  @enderror" placeholder="Cliente"
                         value="{{ old('cliente') }}">
                     @error('cliente')
                         <span class=" invalid-feedback">{{ $message }}</span>
                     @enderror
                 </div>
             </div>
             <div class="col-md-2">
                 <div class="form-group">
                     <label>Data:</label>
                     <input type="text" name="data" class="form-control  @error('data') is-invalid  @enderror"
                         data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask=""
                         inputmode="numeric" value="{{ old('data') }}" maxlength="10">
                     @error('data')
                         <span class=" invalid-feedback">{{ $message }}</span>
                     @enderror
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-md-4">
                 <div class="form-group">
                     <label>Conta:</label>
                     <input type="text" name="conta_pedido" maxlength="50"
                         class="form-control @error('conta_pedido') is-invalid  @enderror" placeholder="Conta"
                         value="{{ old('conta_pedido') }}">
                     @error('conta_pedido')
                         <span class=" invalid-feedback">{{ $message }}</span>
                     @enderror
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="form-group">
                     <label>Comissão:</label>
                     <input type="text" name="comissao" maxlength="9"
                         class="form-control @error('comissao') is-invalid  @enderror" value="{{ old('comissao') }}"
                         placeholder="00.00">
                     @error('comissao')
                         <span class=" invalid-feedback">{{ $message }}</span>
                     @enderror
                 </div>
             </div>
             <div class="col-md-4">
                 <div class="form-group">
                     <label>Desconto:</label>
                     <input type="text" name="desconto_comissao" maxlength="9"
                         class="form-control @error('desconto_comissao') is-invalid  @enderror"
                         value="{{ old('desconto_comissao') ? old('desconto_comissao') : 0 }}" placeholder="00.00">
                     @error('desconto_comissao')
                         <span class=" invalid-feedback">{{ $message }}</span>
                     @enderror
                 </div>
             </div>
         </div>
     </div>
     <div class="card-footer">
         <x-botao.btn-salvar />
         <x-botao.btn-voltar :rota="route('planilha.index')" />
     </div>
 </form>
