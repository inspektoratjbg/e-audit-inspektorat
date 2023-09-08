@extends('adminlte::page')
@section('content_header')
<h1>{{ $title }}</h1>
@stop
@section('content')

<form action="{{ $data['action'] }}" method="post">
    {{ csrf_field() }}
    {{ method_field($data['method']) }}
    <div class="card with-border">
        <div class="card-header">
            <h3 class="card-title">Data Pekerjaan</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <table class='table table-borderless'>
                        <tbody>
                            <tr>
                                <td>Tahun Anggaran</td>
                                <td width="1px">:</td>
                                <td>{{ $pekerjaan->tahun_anggaran }}</td>
                            </tr>
                            <tr>
                                <td>Nama Kegiatan</td>
                                <td width="1px">:</td>
                                <td>{{ $pekerjaan->nama_kegiatan }}</td>
                            </tr>
                            <tr>
                                <td>Pagu Anggaran</td>
                                <td width="1px">:</td>
                                <td>{{ number_format($pekerjaan->pagu_anggaran,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>HPS</td>
                                <td width="1px">:</td>
                                <td>{{ number_format($pekerjaan->harga_perkiraan,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>PPK</td>
                                <td width="1px">:</td>
                                <td>{{ $pekerjaan->ppk_nama }}</td>
                            </tr>
                            <tr>
                                <td>Konsultan Pengawas</td>
                                <td width="1px">:</td>
                                <td>{{ $pekerjaan->konsultan_nama }}</td>
                            </tr>

                            <tr>
                                <td>No SK</td>
                                <td width="1px">:</td>
                                <td>{{ $pekerjaan->no_sk }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal SK</td>
                                <td width="1px">:</td>
                                <td>{{ tgl_indo($pekerjaan->tanggal_sk) }}</td>
                            </tr>
                            <tr>
                                <td>Nilai Kontrak</td>
                                <td width="1px">:</td>
                                <td>{{ number_format($pekerjaan->nilai_kontrak,2,',','.') }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Mulai</td>
                                <td width="1px">:</td>
                                <td>{{ tgl_indo($pekerjaan->tanggal_mulai) }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Selesai</td>
                                <td width="1px">:</td>
                                <td>{{ tgl_indo($pekerjaan->tanggal_selesai) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align:center">Minggu Ke</th>
                                <th style="text-align:center">Target</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pekerjaan->rencana as $rencana)
                            <tr>
                                <td>
                                    Minggu ke {{ $rencana->minggu_ke }}
                                    <span class="d-block text-muted">{{ tgl_indo($rencana->tanggal_mulai) }} s.d {{ tgl_indo($rencana->tanggal_selesai) }}</span>
                                </td>
                                <td align="center">
                                    <div class="progress progress-xs">
                                        <div class="progress-bar {{ colorpersen($rencana->target) }}" style="width: {{$rencana->target}}%"></div>
                                    </div>
                                    {{ number_format($rencana->target,2,',','.') }} %
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor SK</label>
                                <input type="text" name="no_sk_addedum" id="no_sk_addedum" class="form-control @error('no_sk_addedum') is-invalid @enderror form-control-sm" value="{{ $pekerjaan->no_sk_addedum??old('no_sk_addedum') }}">
                                @error('no_sk_addedum')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal SK</label>
                                <input type="text" name="tanggal_sk_addedum" id="tanggal_sk_addedum" class="tanggal form-control @error('tanggal_sk_addedum') is-invalid @enderror form-control-sm" value="{{ isset($pekerjaan->tanggal_sk_addedum)?date('d-m-Y',strtotime($pekerjaan->tanggal_sk_addedum)):old('tanggal_sk_addedum') }}">
                                @error('tanggal_sk_addedum')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nilai Addedum</label>
                        <input type="text" name="nilai_kontrak_addedum" id="nilai_kontrak_addedum" class="angka form-control @error('nilai_kontrak_addedum') is-invalid @enderror form-control-sm" value="{{ isset($pekerjaan->nilai_kontrak_addedum)?number_format(0,2,',','.'):old('nilai_kontrak_addedum') }}">
                        @error('nilai_kontrak_addedum')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai Addedum</label>
                        <input readonly type="hidden" name="tanggal_mulai" id="tanggal_mulai" class="tanggal form-control @error('tanggal_mulai') is-invalid @enderror form-control-sm" value="{{ isset($pekerjaan->tanggal_mulai)?date('d-m-Y',strtotime($pekerjaan->tanggal_mulai)):old('tanggal_mulai') }}">
                        <input type="text" name="tanggal_mulai_addedum" id="tanggal_mulai_addedum" class="tanggal form-control @error('tanggal_mulai_addedum') is-invalid @enderror form-control-sm" value="{{ isset($pekerjaan->tanggal_mulai_addedum)?date('d-m-Y',strtotime($pekerjaan->tanggal_mulai_addedum)):old('tanggal_mulai_addedum') }}">
                        @error('tanggal_mulai_addedum')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai Addedum</label>
                        <input type="text" name="tanggal_selesai_addedum" id="tanggal_selesai_addedum" class="tanggal form-control @error('tanggal_selesai_addedum') is-invalid @enderror form-control-sm" value="{{ isset($pekerjaan->tanggal_selesai_addedum)?date('d-m-Y',strtotime($pekerjaan->tanggal_selesai_addedum)):old('tanggal_selesai_addedum') }}">
                        @error('tanggal_selesai_addedum')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Minggu Ke</th>
                                <th width="100px">Target (%)</th>
                            </tr>
                        </thead>
                        <tbody id="penjadwalan">
                            @foreach($pekerjaan->rencana as $rencana)
                            <tr>
                                <td > Minggu ke {{ $rencana->minggu_ke }}
                                    <br><span class='text-muted'>{{ date('d-m-Y',strtotime($rencana->tanggal_mulai)) }} s/d {{ date('d-m-Y',strtotime($rencana->tanggal_selesai)) }}</span>
                                    <input type='hidden' name='minggu_ke[]' value='{{ $rencana->minggu_ke }}'>
                                     <input required type='hidden' name='tanggal_mulai_minggu[]' value="{{ date('d-m-Y',strtotime($rencana->tanggal_mulai)) }}" class='form-control form-control-sm tanggal'> 
                                     <input required type='hidden' name='tanggal_selesai_minggu[]' value="{{ date('d-m-Y',strtotime($rencana->tanggal_selesai)) }}" class='form-control form-control-sm tanggal'>
                                </td>
                                <td><input required type='text' class='koma form-control form-control-sm' name='target[]' value="{{ number_format($rencana->target,2,',','') }}"></td>
                            <tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class=" card-footer">
            <div class="float-right">
                <a href="{{ url('pekerjaan',$pekerjaan->id) }}" class="btn btn-sm btn-info"><i class="fas fa-angle-double-left"></i>  Kembali</a>
                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
            </div>
        </div>
    </div>
</form>

@stop
@section('css')
<!-- <style src=""></style> -->
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

    $('#tanggal_mulai,#tanggal_selesai_addedum').on('change', function() {

        a = $('#tanggal_mulai').val();
        b = $('#tanggal_selesai_addedum').val();

        if (a != '' && b != '') {
            getweeks(a, b);
        }
    });

    function getweeks(a, b) {
        $.ajax({
            url: "{{ url('getweeks') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                awal: a,
                selesai: b
            },
            success: function(res) {
                console.log(res);
                html_ = "";
                ip = "{{ $pekerjaan->id??'' }}";

                ke = 1;
                jm = 0;
                $.each(res, function(ia, sd) {
                    jm += 1;
                });

                console.log(jm);
                $.each(res, function(i, d) {
                    urut = ke++;
                    mulai = d.tanggal.awal;
                    if (urut == 1) {
                        mulai = a;
                    }
                    selesai = d.tanggal.akhir
                    if (urut == jm) {
                        selesai = b;
                    }
                    target = 0;
                    html_ += "<tr>";
                    html_ += "<td >Minggu ke " + urut + "<br><span class='text-muted'>" + mulai + " s/d " + selesai + "</span>  <input type='hidden' name='minggu_ke[]' value='" + urut + "'> <input required type='hidden' name='tanggal_mulai_minggu[]' value='" + mulai + "' class='form-control form-control-sm tanggal'> <input required type='hidden' name='tanggal_selesai_minggu[]' value='" + selesai + "' class='form-control form-control-sm tanggal'></td>";
                    html_ += "<td><input required type='text'  class='koma form-control form-control-sm' name='target[]'  value'" + target + "' ></td>";
                    html_ += "<tr>";
                });
                $('#penjadwalan').html(html_);


                $('.koma').on('keyup', function() {
                    res = angkakoma($(this).val());
                    $(this).val(res);
                });

                $('.tanggal').datepicker({
                    format: "dd-mm-yyyy",
                    clearBtn: true,
                    autoclose: true,
                    language: "id"
                });



            }
        });
    }



    $('.angka').on('keyup', function() {
        angka = $(this).val();
        res = angkakoma(angka);
        $(this).val(res);
    });
</script>
@stop