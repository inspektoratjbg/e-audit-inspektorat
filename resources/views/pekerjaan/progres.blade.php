@extends('adminlte::page')
@section('content_header')
<h1>{{ $title }}</h1>
@stop
@section('content')
<div class="card ">
    <div class="card-header">
        <h3 class="card-title">Update Realisasi Mingguan</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-10 col-lg-6 order-2 order-md-1">
                <form action="{{ $data['action'] }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field($data['method']) }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Awal Minggu</label>
                                <input value="{{ date('d-m-Y',strtotime($rencana->tanggal_mulai)) }}" type="text" name="tanggal_mulai" id="tanggal_mulai" class="tanggal form-control form-control-sm" }>
                            </div>
                            <div class="form-group">
                                <label for="">Akhir Minggu</label>
                                <input value="{{ date('d-m-Y',strtotime($rencana->tanggal_selesai)) }}" type="text" name="tanggal_selesai" id="tanggal_selesai" class="tanggal form-control form-control-sm" }>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Target (%)</label>
                                <input class="form-control form-control-sm" disabled type="text" value="{{ number_format($rencana->target,2,',','') }}">
                            </div>
                            <div class="form-group">
                                <label for="">Realisasi (%)</label>
                                <input class="@error('realisasi') is-invalid @endif form-control form-control-sm koma"   name="realisasi" id="realisasi" type="text">
                                @error('realisasi')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button id='addLampiran' title="File Pendukung" class="btn btn-xs btn-outline-info" type="button"> <i class="fas fa-file-alt"></i> Dokumen Pendukung</button></label>
                                <div id="formLampiran">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="float-right">
                                <a href="{{ url('pekerjaan',$pekerjaan->id) }}" class="btn btn-sm btn-info"><i class="fas fa-angle-double-left"></i> Kembali</a>
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-12 col-md-4 col-lg-6 order-1 order-md-2">
                <h5 class="text-primary"><i class="fas fa-pencil-ruler"></i>{{ $pekerjaan->nama_kegiatan }}</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-muted">
                            <p class="text-sm">Konsultan Pengawas
                                <b class="d-block">{{ $pekerjaan->konsultan_nama }}</b>
                            </p>
                            <p class="text-sm">No , Tanggal SK
                                <b class="d-block">{{ $pekerjaan->no_sk }} , {{ tgl_indo($pekerjaan->tanggal_sk) }} </b>
                            </p>
                            <p class="text-sm">Pengerjaan
                                <b class="d-block">{{ tgl_indo($pekerjaan->tanggal_mulai) }} sd {{ tgl_indo($pekerjaan->tanggal_selesai) }}</b>
                            </p>
                            <p class="text-sm">PPK
                                <b class="d-block">{{ $pekerjaan->ppk_nama }}</b>
                            </p>
                            <p class="text-sm">OPD
                                <b class="d-block">{{ $pekerjaan->ppk->nama_unit }}</b>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="text-muted">
                            @if($pekerjaan->no_sk_addedum<>'')
                                <p class="text-sm">
                                    <b class="d-block">Addedum </b>
                                </p>
                                <p class="text-sm">No , Tanggal SK
                                    <b class="d-block">{{ $pekerjaan->no_sk_addedum }} , {{ tgl_indo($pekerjaan->tanggal_sk_addedum) }} </b>
                                </p>
                                <p class="text-sm">Pengerjaan Addedum
                                    <b class="d-block">{{ tgl_indo($pekerjaan->tanggal_mulai_addedum) }} sd {{ tgl_indo($pekerjaan->tanggal_selesai_addedum) }}</b>
                                </p>
                                @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>

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

        $('.koma').on('keyup', function() {
            res = angkakoma($(this).val());
            $(this).val(res);
        });

        $('.angka').on('keyup', function() {
            angka = $(this).val();
            res = formatangka(angka);
            $(this).val(res);
        });

        var counter_lam = 1;
        $(document).on('click', '#addLampiran', function(e) {


            var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter_lam);
            newTextBoxDiv.after().html('<div class="input-group hapus">' +
                '<div class="input-group-append">' +
                '        <button class="btn btn-info" type="button" title="File Pendukung"><i class="fas fa-file" ></i></button>' +
                '    </div>' +
                '<input id="file_lampiran' + counter_lam + '" type="file" name="file_lampiran[]" class="form-control upload-file"><br>' +
                '<div class="input-group-append">' +
                '    <button class="btn btn-outline-danger hapus_lampiran" type="button"' +
                '        ><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</div>');
            newTextBoxDiv.appendTo("#formLampiran");
            $(document).on('change', "#file_lampiran" + counter_lam, function(e) {
                filename = $(this).val().split('\\').pop();
                la = filename.split('.');
                vexe = ['jpeg', 'jpg', 'png'];
                exe = la[la.length - 1];
                status = '0';
                for (var i = 0; i < vexe.length; i++) {
                    var name = vexe[i];
                    if (name == exe.toLowerCase()) {
                        status = '1';
                        break;
                    }
                }
                if (status == '0') {
                    $(this).val('');
                    Swal.fire({
                        title: "Peringatan",
                        text: "File " + exe + " tidak di perbolehkan",
                        icon: "warning",
                        // timer: 2000,
                    });
                }


            });
            $('#file_lampiran' + counter_lam).trigger('click');
            counter_lam++;
        });

        $(document).on('click', '.hapus_lampiran', function(e) {
            $(this).parents(".hapus").remove();
        });
    </script>
    @stop