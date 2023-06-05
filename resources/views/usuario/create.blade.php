@extends('layouts.app')
@section('content')
    <div class="card card-primary">
        <form action="{{ route('usuario.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group ">
                    <label>Nome:</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="nome" value="{{ old('name') }}">
                    @error('name')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Usuário:</label>
                    <input type="text" name="usuario" class="form-control @error('usuario') is-invalid @enderror"
                        placeholder="usuario" value="{{ old('usuario') }}">
                    @error('usuario')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="email" value="{{ old('email') }}">
                    @error('email')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="text" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="password" value="{{ old('password') }}">
                    @error('password')
                        <span class=" invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>RG:</label>
                            <input type="text" name="rg" class="form-control" placeholder="rg"
                                value="{{ old('rg') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CPF:</label>
                            <input type="text" name="cpf" class="form-control" placeholder="cpf"
                                value="{{ old('cpf') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>CNPJ:</label>
                            <input type="text" name="cnpj" maxlength="20" placeholder="__.__.___/_____-__"
                                class="form-control @error('cnpj') is-invalid  @enderror" value="{{ old('cnpj') }}"
                                data-inputmask="'alias': '99.999.999/9999-99'" data-mask="" inputmode="decimal">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Grupo:</label>
                            <select name="grupo" class="custom-select @error('grupo') is-invalid @enderror">
                                <option value="">...</option>
                                <option value="1" @if (old('grupo') == '1') selected @endif>
                                    Monitoramento</option>
                                <option value="2" @if (old('grupo') == '2') selected @endif>
                                    Comercial</option>
                            </select>
                            @error('grupo')
                                <span class=" invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Ativo:</label>
                            <select name="ativo" class="custom-select">
                                <option value="on" @if (old('ativo') == 'on') selected @endif>
                                    Sim</option>
                                <option value="off" @if (old('ativo') == 'off') selected @endif>
                                    Não</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="customFile">Foto</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value="Salvar">
            </div>
        </form>
    </div>
@endsection
