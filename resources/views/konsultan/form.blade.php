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
                        <label class="control-label col-md-4">Nama Konsultan</label>
                        <div class="col-md-8">
                            <input type="text" name="nama_konsultan" id="nama_konsultan" value="{{ $konsultan->nama_konsultan??old('nama_konsultan') }}" class="@error('nama_konsultan') is-invalid @enderror form-control form-control-sm">
                            @error('nama_konsultan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-4">No Hp / Wa</label>
                        <div class="col-md-8">
                            <input type="number" name="no_hp" id="no_hp" value="{{ $konsultan->no_hp??old('no_hp') }}" class="@error('no_hp') is-invalid @enderror form-control form-control-sm">
                            @error('no_hp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-4">Email</label>
                        <div class="col-md-8">
                            <input type="email" name="email" id="email" value="{{ $konsultan->email??old('email') }}" class="@error('email') is-invalid @enderror form-control form-control-sm">
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