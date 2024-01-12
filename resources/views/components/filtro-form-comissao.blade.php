<form action="{{ $route }}" method="get">
    <div class=" col-md-8 offset-md-2">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <input type="text" name="filtro" class="form-control form-control-lg" value="{{ request('filtro') }}"
                        placeholder="Pesquisar por">
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