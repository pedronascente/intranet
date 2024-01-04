
<form action="{{ $route }}" method="get">
    <div class=" col-md-8 offset-md-2">
        <div class="row">
            <div class="col-md-2">
                <div class="input-group input-group-lg">
                    <select name="ano" class="form-control form-control-lg">
                        <option value="">Ano</option>
                        @for ($ano = date('Y'); $ano >= 2020; $ano--)
                            <option value="{{ $ano }}" {{ request('ano') == $ano ? 'selected' : '' }}>
                                {{ $ano }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-10">
                <div class="input-group input-group-lg">
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
    </div>
</form>