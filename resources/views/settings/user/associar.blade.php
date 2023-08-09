@extends('layouts.iframe')
@section('content')
    <div class="card">
        <form action="{{ route('user.updateassociar', $user->id) }}" method="POST" name="formularuio-associar-colaborador">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-exclamation-triangle"></i> Selecione um colaborador abaixo, para ser
                            associado!
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Colaborador:</label>
                            <select name="colaborador_id"
                                class="custom-select @error('colaborador_id') is-invalid @enderror">
                                <option value="">...</option>
                                @foreach ($colabordores as $item)
                                    <option value="{{ $item->id }}" @if (old('colaborador_id') == $item->id) selected @endif>
                                        {{ $item->nome }} {{ $item->sobrenome }} </option>
                                @endforeach
                            </select>
                            @error('colaborador_id')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Usuário:</label>
                            <input type="text" name="name" maxlength="190"
                                class="form-control @error('name') is-invalid  @enderror" placeholder="Nome"
                                value="{{ $user->name }}" disabled>
                            @error('name')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn bg-gradient-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Salvar</button>
            </div>
        </form>
    </div>
@endsection
