<form action="{{ route('planilha-administrativo.filtro') }}" method="get">
    <div class="row">
        <div class="col-md-1">
            <div class="form-group">
                <div class="input-group">
                    <select name="ano" class="form-control form-control-lg">
                        <option value="">Ano</option>
                        @for ($ano = date('Y'); $ano >= 2020; $ano--)
                            <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>
                                {{ $ano }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-11">
            <div class="input-group">
                <input type="text" name="filtro" class="form-control form-control-lg"
                    value="{{ request('filtro') }}" placeholder="Pesquisar por">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
