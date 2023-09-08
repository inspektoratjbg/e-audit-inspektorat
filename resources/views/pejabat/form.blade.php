@extends('adminlte::page')
@section('content_header')
<h1>{{ $title }}</h1>
@stop
@section('content')
<div class="row">
    <div class="col-md-6">
        <form class="form-horizontal" action="{{ $data['action'] }}" method="post">
            {{ csrf_field() }}
            {{ method_field($data['method']) }}
            <div class="card with-border card-success">
                <div class="card-header">
                    <h3 class="card-title">Form</h3>
                </div>
                <div class="card-body">
                <div class="form-group row">
                        <label class="control-label col-md-4"> Pejabat</label>
                        <div class="col-md-8">
                            <input disabled type="text" name="jabatan" id="jabatan" value="{{ $pejabat->jabatan??old('jabatan') }}" class="@error('jabatan') is-invalid @enderror form-control form-control-sm">
                            @error('jabatan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-4">Nama Pejabat</label>
                        <div class="col-md-8">
                            <input type="text" name="nama_pejabat" id="nama_pejabat" value="{{ $pejabat->nama_pejabat??old('nama_pejabat') }}" class="@error('nama_pejabat') is-invalid @enderror form-control form-control-sm">
                            @error('nama_pejabat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                
                    <div class="form-group row">
                        <label class="control-label col-md-4">Email</label>
                        <div class="col-md-8">
                            <input type="email" name="email" id="email" value="{{ $pejabat->email??old('email') }}" class="@error('email') is-invalid @enderror form-control form-control-sm">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
@section('js')
<script>

</script>
@stop