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
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_sp2d">Tanggal SP2D</label>
                                            <input type="text" name="tgl_sp2d" id="tgl_sp2d"
                                                value="{{ isset($sppd->tgl_sp2d) ? date('d-m-Y', strtotime($sppd->tgl_sp2d)) : old('tgl_sp2d') }}"
                                                class="form-control tanggal @error('tgl_sp2d') is-invalid @enderror ">
                                            @error('tgl_sp2d')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_sp2d">Nomer SP2D</label>
                                            <input type="text" name="no_sp2d" id="no_sp2d"
                                                value="{{ isset($sppd->no_sp2d) ? $sppd->no_sp2d : old('no_sp2d') }}"
                                                class="form-control @error('no_sp2d') is-invalid @enderror ">
                                            @error('no_sp2d')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="pekerjaan_id">Pekerjaan</label>
                                    <select name="pekerjaan_id" id="pekerjaan_id" class="form-control  @error('pekerjaan_id') is-invalid @enderror ">
                                        <option value="">Pilih</option>
                                        @foreach ($pekerjaan as $rn)
                                            <option @if(($sppd->pekerjaan_id??old('pekerjaan_id'))==$rn->id ) selected @endif value="{{ $rn->id }}">{{ $rn->nama_pekerjaan }}</option>
                                        @endforeach
                                    </select>
                                    @error('pekerjaan_id')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="nilai">Nilai</label>
                                    <input type="text" name="nilai" id="nilai"
                                        value="{{ isset($sppd->nilai) ? number_format($sppd->nilai, 2, ',', '') : old('nilai') }}"
                                        class="form-control angka @error('nilai') is-invalid @enderror ">
                                    @error('nilai')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" name="keterangan" id="keterangan"
                                        value="{{ isset($sppd->keterangan) ? $sppd->keterangan : old('keterangan') }}"
                                        class="form-control @error('keterangan') is-invalid @enderror ">
                                    @error('keterangan')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
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
    <link rel="stylesheet" href="{{ asset('vendor/datepicker/css/bootstrap-datepicker.css') }}">
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

        $('.angka').on('keyup', function() {
            angka = $(this).val();
            res = angkakoma(angka);
            $(this).val(res);
        });

    </script>
@stop
