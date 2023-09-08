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
                <h3 class="card-title">Form Pekerjaan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>PPK</label>
                                    @if (userRole('Administrator'))
                                        <select name="ppk_id" id="ppk_id"
                                            class="form-control @error('ppk_id') is-invalid @enderror form-control-sm">
                                            <option value="">Pilih PPK</option>
                                            @foreach ($ppk as $rpk)
                                                <option @if ($rpk->id == ($pekerjaan->ppk_id ?? old('ppk_id'))) selected @endif value="{{ $rpk->id }}">
                                                    {{ $rpk->nama }} / {{ $rpk->nama_unit }} </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="hidden" name="ppk_id" id="ppk_id"
                                            class="form-control @error('ppk_id') is-invalid @enderror form-control-sm"
                                            value="{{ $pekerjaan->ppk_id ?? ($ppk->id ?? old('ppk_id')) }}">
                                        <input readonly type="text" name="ppk_nama" id="ppk_nama"
                                            class="form-control @error('ppk_nama') is-invalid @enderror form-control-sm"
                                            value="{{ $pekerjaan->ppk_nama ?? ($ppk->nama ?? old('ppk_nama')) }}">
                                    @endif
                                    @error('ppk_id')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Konsultan Pengawas</label>
                                    <select name="konsultan_id" id="konsultan_id"
                                        class="form-control @error('konsultan_id') is-invalid @enderror form-control-sm">
                                        <option value="">Pilih Konsultan</option>
                                        @foreach ($konsultan as $rpkk)
                                            <option @if ($rpkk->id == ($pekerjaan->konsultan_id ?? old('konsultan_id'))) selected @endif value="{{ $rpkk->id }}">
                                                {{ $rpkk->nama_konsultan }}</option>
                                        @endforeach
                                    </select>
                                    @error('konsultan_id')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class=""> Tahun</label>
                                    <input readonly type="text" name="tahun_anggaran" id="tahun_anggaran"
                                        class="form-control @error('tahun_anggaran') is-invalid @enderror form-control-sm "
                                        value="{{ $pekerjaan->tahun_anggaran ?? (old('tahun_anggaran') ?? date('Y')) }}">
                                        {{-- value="2022"> --}}
                                    @error('tahun_anggaran')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label class=""> Nama Kegiatan</label>
                                    <input type="text" name="nama_kegiatan" id="nama_kegiatan"
                                        class="form-control @error('nama_kegiatan') is-invalid @enderror form-control-sm "
                                        value="{{ $pekerjaan->nama_kegiatan ?? old('nama_kegiatan') }}">
                                    @error('nama_kegiatan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nama Pekerjaan</label>
                            <input type="text" name="nama_pekerjaan" id="nama_pekerjaan"
                                class="form-control @error('nama_pekerjaan') is-invalid @enderror form-control-sm "
                                value="{{ $pekerjaan->nama_pekerjaan ?? old('nama_pekerjaan') }}">
                            @error('nama_pekerjaan')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=""> Pagu Anggaran</label>
                                    <input type="text" name="pagu_anggaran" id="pagu_anggaran"
                                        class="angka form-control @error('pagu_anggaran') is-invalid @enderror form-control-sm "
                                        value="{{ isset($pekerjaan->pagu_anggaran) ? number_format($pekerjaan->pagu_anggaran, 2, ',', '') : old('pagu_anggaran') }}">
                                    @error('pagu_anggaran')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=""> Harga Perkiraan (HPS)</label>
                                    <input type="text" name="harga_perkiraan" id="harga_perkiraan"
                                        class="angka form-control @error('harga_perkiraan') is-invalid @enderror form-control-sm "
                                        value="{{ isset($pekerjaan->harga_perkiraan) ? number_format($pekerjaan->harga_perkiraan, 2, ',', '') : old('harga_perkiraan') }}">
                                    @error('harga_perkiraan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Penyedia</label>
                            <input type="text" name="nama_penyedia" id="nama_penyedia"
                                class="form-control @error('nama_penyedia') is-invalid @enderror form-control-sm"
                                value="{{ $pekerjaan->nama_penyedia ?? old('nama_penyedia') }}">
                            @error('nama_penyedia')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor SPK / Kontrak</label>
                                    <input type="text" name="no_sk" id="no_sk"
                                        class="form-control @error('no_sk') is-invalid @enderror form-control-sm"
                                        value="{{ $pekerjaan->no_sk ?? old('no_sk') }}">
                                    @error('no_sk')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal SPK /Kontrak </label>
                                    <input type="text" name="tanggal_sk" id="tanggal_sk"
                                        class="tanggal form-control @error('tanggal_sk') is-invalid @enderror form-control-sm"
                                        value="{{ isset($pekerjaan->tanggal_sk) ? date('d-m-Y', strtotime($pekerjaan->tanggal_sk)) : old('tanggal_sk') }}">
                                    @error('tanggal_sk')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nilai Kontrak</label>
                            <input type="text" name="nilai_kontrak" id="nilai_kontrak"
                                class="angka form-control @error('nilai_kontrak') is-invalid @enderror form-control-sm"
                                value="{{ isset($pekerjaan->nilai_kontrak) ? number_format($pekerjaan->nilai_kontrak, 2, ',', '') : old('nilai_kontrak') }}">
                            @error('nilai_kontrak')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Mulai Pekerjaan</label>
                                    <input type="text" name="tanggal_mulai" id="tanggal_mulai"
                                        class="tanggal form-control @error('tanggal_mulai') is-invalid @enderror form-control-sm"
                                        value="{{ isset($pekerjaan->tanggal_mulai) ? date('d-m-Y', strtotime($pekerjaan->tanggal_mulai)) : old('tanggal_mulai') }}">
                                    @error('tanggal_mulai')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Selesai Pekerjaan</label>
                                    <input type="text" name="tanggal_selesai" id="tanggal_selesai"
                                        class="tanggal form-control @error('tanggal_selesai') is-invalid @enderror form-control-sm"
                                        value="{{ isset($pekerjaan->tanggal_selesai) ? date('d-m-Y', strtotime($pekerjaan->tanggal_selesai)) : old('tanggal_selesai') }}">
                                    @error('tanggal_selesai')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
                {{-- <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th width="150px">Minggu Ke</th>
                                <th>Awal</th>
                                <th>Akhhir</th>
                                <th>Target (%)</th>
                            </tr>
                        </thead>
                        <tbody id="penjadwalan">
                            @if ($data['method'] == 'patch')
                            @foreach ($pekerjaan->rencana as $rencana)
                            <tr>
                                <td align='center'> {{ $rencana->minggu_ke }} <input type='hidden' name='minggu_ke[]' value='{{ $rencana->minggu_ke }}'></td>
                                <td> <input required type='text' name='tanggal_mulai_minggu[]' value="{{ date('d-m-Y',strtotime($rencana->tanggal_mulai)) }}" class='form-control form-control-sm tanggal'> </td>
                                <td> <input required type='text' name='tanggal_selesai_minggu[]' value="{{ date('d-m-Y',strtotime($rencana->tanggal_selesai)) }}" class='form-control form-control-sm tanggal'> </td>
                                <td><input required type='text' class='koma form-control form-control-sm' name='target[]' value='{{ $rencana->target }}'></td>
                            <tr>
                                @endforeach
                                @endif
                        </tbody>
                    </table>
                </div>
            </div> --}}

            </div>
            <div class=" card-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </div>
    </form>

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


        <?php
        if ($data['method'] == 'post' && old('tanggal_selesai') != '' && old('tanggal_mulai') != '') {
            ?>
            a = $('#tanggal_mulai').val();
            b = $('#tanggal_selesai').val();

            if (a != '' && b != '') {
                // getweeks(a, b);
            }
            <?php
        } ?>

        $('#tanggal_mulai,#tanggal_selesai').on('change', function() {

            a = $('#tanggal_mulai').val();
            b = $('#tanggal_selesai').val();

            if (a != '' && b != '') {
                // getweeks(a, b);
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
                    ip = "{{ $pekerjaan->id ?? '' }}";

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
                        html_ += "<td align='center'>" + urut +
                            "<input type='hidden' name='minggu_ke[]' value='" + urut + "'></td>";
                        html_ +=
                            "<td> <input required type='text' name='tanggal_mulai_minggu[]' value='" +
                            mulai + "' class='form-control form-control-sm tanggal'>  </td>";
                        html_ +=
                            "<td> <input required type='text' name='tanggal_selesai_minggu[]' value='" +
                            selesai + "' class='form-control form-control-sm tanggal'>  </td>";
                        html_ +=
                            "<td><input required type='text'  class='koma form-control form-control-sm' name='target[]'  value'" +
                            target + "' ></td>";
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
