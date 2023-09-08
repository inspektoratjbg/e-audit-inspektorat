@extends('adminlte::page')
@section('content_header')
    <h1>{{ $pekerjaan->nama_kegiatan }}</h1>
@stop
@section('content')
    <div class="card ">
        <div class="card-header">
            <h3 class="card-title">Detail Pekerjaan</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Pagu Anggaran</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ number_format($pekerjaan->pagu_anggaran, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">HPS</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ number_format($pekerjaan->harga_perkiraan, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text text-center text-muted">Nilai Kontrak</span>
                                    <span
                                        class="info-box-number text-center text-muted mb-0">{{ number_format($pekerjaan->nilai_kontrak, 2, ',', '.') }}</span>
                                    @if ($pekerjaan->nilai_kontrak_addedum != '')
                                        <span class="info-box-number text-center text-success mb-0">Addedum
                                            {{ number_format($pekerjaan->nilai_kontrak_addedum, 2, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12 ">
                            <h4>Target Realisasi</h4>
                            <form action="{{ $data['action'] }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field($data['method']) }}
                                <input type="hidden" name="pekerjaan_id" value="{{ $pekerjaan->id }}">
                                <div class="row">
                                    <div class="col-md-12">
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
                                            </tbody>
                                        </table>
                                        <div class="float-sm-right">
                                            <button class="btn btn-sm btn-info"><i class="fas fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                    <h5 class="text-primary"><i class="fas fa-pencil-ruler"></i>{{ $pekerjaan->nama_kegiatan }}</h5>
                    <br>
                    <div class="text-muted">
                        <p class="text-sm">Konsultan Pengawas
                            <b class="d-block">{{ $pekerjaan->konsultan_nama }}</b>
                        </p>
                        <p class="text-sm">No , Tanggal SK
                            <b class="d-block">{{ $pekerjaan->no_sk }} , {{ tgl_indo($pekerjaan->tanggal_sk) }} </b>
                        </p>
                        <p class="text-sm">Pengerjaan
                            <b class="d-block">{{ tgl_indo($pekerjaan->tanggal_mulai) }} sd
                                {{ tgl_indo($pekerjaan->tanggal_selesai) }}</b>
                        </p>
                        <p class="text-sm">PPK
                            <b class="d-block">{{ $pekerjaan->ppk_nama }}</b>
                        </p>
                        <p class="text-sm">OPD
                            <b class="d-block">{{ $pekerjaan->ppk->nama_unit }}</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @stop
    @section('css')
        <link rel="stylesheet" href="{{ asset('vendor/ekko-lightbox/ekko-lightbox.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datepicker/css/bootstrap-datepicker.css') }}">
    @endsection
    @section('js')
        <script src="{{ asset('vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('vendor/ekko-lightbox/ekko-lightbox.min.js') }}"></script>
        <script>
            a = "{{ date('d-m-Y', strtotime($pekerjaan->tanggal_mulai)) }}";
            b = "{{ date('d-m-Y', strtotime($pekerjaan->tanggal_selesai)) }}";
            if (a != '' && b != '') {
                getweeks(a, b);
            }

            $('.tanggal').datepicker({
                format: "dd-mm-yyyy",
                clearBtn: true,
                autoclose: true,
                language: "id"
            });

            $('.angka').on('keyup', function() {
                angka = $(this).val();
                res = formatangka(angka);
                $(this).val(res);
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
                                mulai + "' readonly class='form-control form-control-sm  '>  </td>";
                            html_ +=
                                "<td> <input required type='text' name='tanggal_selesai_minggu[]' value='" +
                                selesai + "' readonly class='form-control form-control-sm  '>  </td>";
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

        </script>
    @stop
