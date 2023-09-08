@extends('adminlte::page')
@section('content_header')
    <h1>{{ $title }}</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" action="{{ $data['action'] }}" method="post">
                {{ csrf_field() }}
                {{ method_field($data['method']) }}
                <div class="card with-border card-success">
                    <div class="card-header">
                        <h3 class="card-title">Form</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-md-4">Satuan Kerja / OPD</label>
                                    <div class="col-md-8">
                                        <select name="kode_unit" id="kode_unit"
                                            class="form-control form-control-sm @error('kode_unit') is-invalid @enderror">
                                            <option value="">Pilih</option>
                                            @foreach ($unit as $ru)
                                                <option @if ($ru->kode_unit == ($ppk->kode_unit ?? old('kode_unit'))) selected @endif value="{{ $ru->kode_unit }}">
                                                    {{ $ru->nama_unit }}</option>
                                            @endforeach
                                        </select>
                                        @error('kode_unit')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-4">Nama</label>
                                    <div class="col-md-8">
                                        <input type="text" name="nama" id="nama" value="{{ $ppk->nama ?? old('nama') }}"
                                            class="@error('nama') is-invalid @enderror form-control form-control-sm">
                                        @error('nama')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-4">No Hp / Wa</label>
                                    <div class="col-md-8">
                                        <input type="number" name="no_hp" id="no_hp"
                                            value="{{ $ppk->no_hp ?? old('no_hp') }}"
                                            class="@error('no_hp') is-invalid @enderror form-control form-control-sm">
                                        @error('no_hp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-4">No SK</label>
                                    <div class="col-md-8">
                                        <input type="text" name="no_sk" id="no_sk"
                                            value="{{ $ppk->no_sk ?? old('no_sk') }}"
                                            class="@error('no_sk') is-invalid @enderror form-control form-control-sm">
                                        @error('no_sk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-4">Tanggal SK</label>
                                    <div class="col-md-8">
                                        <input type="text" name="tanggal_sk" id="tanggal_sk"
                                            value="{{  Carbon\Carbon::parse($ppk->tanggal_sk??date('d-m-Y'))->format('d-m-Y') ?? old('tanggal_sk') }}"
                                            class="@error('tanggal_sk') is-invalid @enderror form-control form-control-sm tanggal">
                                        @error('tanggal_sk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="control-label col-md-4">Email / akun</label>
                                    <div class="col-md-8">
                                        <input type="email" name="email" id="email"
                                            value="{{ $ppk->email ?? old('email') }}"
                                            class="@error('email') is-invalid @enderror form-control form-control-sm">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                @if($data['method']=='POST')
                                <div class="form-group row">
                                    <label class="control-label col-md-4">Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password" id="password"
                                            value="{{ $ppk->password ?? old('password') }}"
                                            class="@error('password') is-invalid @enderror form-control form-control-sm">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-4">Password Konfirmasi</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password_konfirmasi" id="password_konfirmasi"
                                            value="{{ $ppk->password_konfirmasi ?? old('password_konfirmasi') }}"
                                            class="@error('password_konfirmasi') is-invalid @enderror form-control form-control-sm">
                                        @error('password_konfirmasi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                                @endif
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
@section('css')
<link rel="stylesheet" href="{{ asset('vendor/datepicker/css/bootstrap-datepicker.css')}}">
@endsection
@section('js')
<script src="{{ asset('vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $('.tanggal').datepicker({
        format: "dd-mm-yyyy",
        clearBtn: true,
        autoclose: true,
        language: "id"
    });
</script>
@stop