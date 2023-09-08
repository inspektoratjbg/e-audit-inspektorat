@extends('adminlte::page')
@section('content_header')
<h1>{{ $pekerjaan->nama_pekerjaan }}</h1>
@stop
@section('content')
<div class="card ">
    <div class="card-header">
        <h3 class="card-title">Detail Pekerjaan
            @if($pekerjaan->status==3)
            <strong> / Pekerjaan Selesai</strong>
            @endif
            @if($pekerjaan->status==4)
            <strong> / Pekerjaan Putus Kontrak</strong>
            @endif
        </h3>
        <div class="float-right">
            @if(usercan('addedum.create') && userRole('PPK') && $pekerjaan->status==2)
            <a href="{{ route('addedum.create',$pekerjaan->id) }}" class="btn btn-sm btn-info"><i class="fas fa-calendar-alt"></i> Addedum</a>
            @endif
            @if(userRole('PPK') && $pekerjaan->status==2)
            <a id="putus" href="#" data-url="{{ route('pekerjaan.putus.kontrak',$pekerjaan->id) }}" class="btn btn-sm btn-danger"><i class="far fa-times-circle"></i> Putus Kontrak</a>
            <a id="selesai" href="#" data-url="{{ route('pekerjaan.selesai',$pekerjaan->id) }}" class="btn btn-sm btn-success"><i class="fas fa-check"></i> Selesai Pekerjaan</a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Pagu Anggaran</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ number_format($pekerjaan->pagu_anggaran,2,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">HPS</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ number_format($pekerjaan->harga_perkiraan,2,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="info-box bg-light">
                            <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Nilai Kontrak</span>
                                <span class="info-box-number text-center text-muted mb-0">{{ number_format($pekerjaan->nilai_kontrak,2,',','.') }}</span>
                                @if($pekerjaan->nilai_kontrak_addedum<>'')
                                    <span class="info-box-number text-center text-success mb-0">Addedum {{ number_format($pekerjaan->nilai_kontrak_addedum,2,',','.') }}</span>
                                    @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12 ">
                        <h4>Capaian Progres Per {{ tgl_indo(terkini($pekerjaan->id)->tanggal) }} ( {{ number_format(terkini($pekerjaan->id)->hasil,2,',','.').' %'  }} )</h4>
                        @php
                        $minggubar="'Minggu Ke 0',";
                        $targetbar='0,';
                        $realisasibar ='0,';
                        @endphp
                        @if($pekerjaan->rencana->count()>0)
                        <div class="chart">
                            <canvas id="lineChart" style="height:500px; min-height:500px"></canvas>
                        </div>
                        @foreach($pekerjaan->rencana as $rencana)
                        @php
                        $minggubar.="'Minggu ke ".$rencana->minggu_ke."',";
                        $targetbar.=$rencana->target.',';
                        @endphp

                        <div class="post clearfix text-muted">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="text-sm">
                                        <b class="d-block">Minggu ke {{ $rencana->minggu_ke }}</b>
                                        {{ tgl_indo($rencana->tanggal_mulai) }} s.d {{ tgl_indo($rencana->tanggal_selesai) }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-sm">
                                        <b class="d-block">Target</b>
                                        {{ number_format($rencana->target,2,',','.') }} %
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-sm">
                                        <b class="d-block">Progres</b>
                                        @php
                                        $real=progres($pekerjaan->id,$rencana->minggu_ke);
                                        @endphp
                                        @if($real!=null)
                                        {{ number_format($real->realisasi,2,',','.') }} %

                                        <span class="text-muted">( {{ tgl_indo($real->verifikasi_at) }} ) </span>

                                        @if(userCan('progres.create') && $real->verifikasi_at=='' && $pekerjaan->status==2)
                                        <a href="{{ url('hapusprogres',[$pekerjaan->id,$real->minggu_ke]) }}" onclick="return confirm('apakah anda akan menghapus realisasi pada minggu ke {{ $rencana->minggu_ke }} ?')" class=""><i class="fas fa-trash-alt"></i></a>
                                        @endif
                                        @if($real->verifikasi_at!='')
                                        @php $realisasibar .=$real->realisasi.','; @endphp
                                        <span class="text-success"><br>Deviasi : {{ $real->realisasi  - $rencana->target }} % </span>
                                        <span class="text-danger">@php $kri=kritis($pekerjaan->id,$rencana->minggu_ke); if($kri){ echo " ( Kritis )"; } @endphp</span>
                                        @else
                                        <span class="text-red"><br>Realiasi akan masuk ke kurva apabila telah di verifikasi oleh PPK</span>
                                        @endif

                                        {{-- list dokumen --}}
                                    <ul class="list-unstyled">
                                        @foreach($real->dokumen as $dok)
                                        <li>
                                            <a href="{{ route('progres.files',$dok->nama_file) }}" data-toggle="lightbox" class="btn-link text-secondary"><i class="far fa-fw fa-image "></i>Preview
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif

                                    @if(userCan('progres.create') && $real==null && $pekerjaan->status==2)
                                    <a href="{{ url('progres',[$rencana->pekerjaan_id,$rencana->minggu_ke]) }}" class="btn btn-sm btn-primary"> <i class="fas fa-file-signature"></i> Update Progres</a>
                                    @endif

                                    </p>
                                </div>
                            </div>

                        </div>
                        @endforeach
                        @else
                        <div class="callout callout-danger">
                            <h5>Belum di input oleh konsultan pengawas !</h5>
                            @if(userRole('Konsultan'))
                            <p>Klik "Perencanaan" untuk input target realisasi .</p>
                            <a href="{{ url('perencanaan',$pekerjaan->id) }}" style="text-decoration: none;" class="btn text-white btn-sm btn-info">Perencanaan</a>
                            @else
                            <p>Silahkan hubungi konsultan pengawas.</p>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                <h5 class="text-primary"><i class="fas fa-pencil-ruler"></i>{{ $pekerjaan->nama_pekerjaan }}</h5>
                <br>
                <div class="text-muted">
                    <p class="text-sm">Nama Kegiatan
                        <b class="d-block">{{ $pekerjaan->nama_kegiatan }} </b>
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
                    <p class="text-sm">Penyedia
                        <b class="d-block">{{ $pekerjaan->nama_penyedia }}</b>
                    </p>
                    <p class="text-sm">Pengawas
                        <b class="d-block">{{ $pekerjaan->konsultan_nama }}</b>
                    </p>
                    <!-- addedum -->
                    @if($pekerjaan->no_sk_addedum<>'')
                        <hr>
                        <p class="text-sm">
                            <b class="d-block">Addedum </b>
                        </p>
                        <p class="text-sm">No , Tanggal SK / Kontrak
                            <b class="d-block">{{ $pekerjaan->no_sk_addedum }} , {{ tgl_indo($pekerjaan->tanggal_sk_addedum) }} </b>
                        </p>
                        <p class="text-sm">Pengerjaan Addedum
                            <b class="d-block">{{ tgl_indo($pekerjaan->tanggal_mulai_addedum) }} sd {{ tgl_indo($pekerjaan->tanggal_selesai_addedum) }}</b>
                        </p>
                        @endif
                </div>
                @if($pekerjaan->sp2d->count())
                <p class="text-sm"><b class="d-block">Pencairan Dana</b></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SP2D</th>
                            <th>Nilai</th>
                            <th>%</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pekerjaan->sp2d as $sp2d)
                        <tr>
                            <td>{{ $sp2d->no_sp2d }}<br>
                                <span class="text-muted">
                                    {{ tgl_indo($sp2d->tgl_sp2d) }}
                                </span>
                            </td>
                            <td>{{ number_format($sp2d->nilai,2,',','.') }}</td>
                            <td>{{ number_format($sp2d->nilai / $pekerjaan->nilai_kontrak * 100 ,2,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if($pekerjaan->dokumen->count())
                <p class="text-sm"><b class="d-block">Dokumen hasil SCM</b></p>

                @endif
                <ul class="list-unstyled">
                    @foreach($pekerjaan->dokumen as $dok)
                    <li>
                        <a href="{{ route('pekerjaan.files',$dok->nama_file) }}" target="_blank" class="btn-link text-secondary"><i class="far fa-fw fa-file "></i>{{ $dok->nama_file}} / Minggu ke {{ $dok->minggu_ke }}
                        </a>
                        @if(usercan('addedum.create') && $pekerjaan->status==2)
                        <a href="{{ url('hapuspekerjaanFile',[$dok->id]) }}" onclick="return confirm('apakah anda akan menghapus file  {{ $dok->keterangan_file}} ?')" class=""><i class="fas fa-trash-alt"></i></a>
                        @endif
                    </li>
                    @endforeach
                </ul>
                @if(usercan('addedum.create'))
                <div class="text-center mt-5 mb-3">
                </div>
                @if($pekerjaan->status==2)
                <hr>
                <h4>Upload File hasil pembuktian</h4>
                <div class="text-muted">
                    <form action="{{ $data['action'] }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field($data['method']) }}
                        <div class="form-group">
                            <button id='addLampiran' title="File Pendukung" class="btn btn-xs btn-outline-info" type="button"> <i class="fas fa-file-alt"></i> Dokumen Pendukung</button></label>
                            <div id="formLampiran">
                            </div>
                            <input type="hidden" name="pekerjaan_id" value="{{$pekerjaan->id}}">
                        </div>
                        <div class="form-group">
                            <div class="float-right">
                                <button type="submit" id="upload" class="btn btn-sm btn-primary d-none"><i class="fas fa-save"></i> Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>

    @stop
    @section('css')
    <link rel="stylesheet" href="{{ asset('vendor/ekko-lightbox/ekko-lightbox.css')}}">

    @endsection
    @section('js')
    <script src="{{ asset('vendor/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
    <script>
        $(document).ready(function() {


            // $('#table').on('click', '.hapus', function(e) {
            $('#putus, #selesai').click(function(e) {
                e.preventDefault();
                console.log('hapus');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    // text: "Anda tidak akan dapat mengembalikanya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, yakin!',
                    cancelButtonText: 'Tidak',
                }).then((result) => {
                    if (result.value) {
                        document.location.href = $(this).data('url');
                    }
                });
            });


        });

        var counter_lam = 0;
        $(document).on('click', '#addLampiran', function(e) {
            counter_lam++;
            $('#upload').removeClass('d-none');
            /*
            
            $('#upload').addClass('d-none'); */
            var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter_lam);
            om_ = '';
            @foreach($pekerjaan -> rencana as $mg)
            om_ += '<option value="{{ $mg->minggu_ke }}">Minggu ke {{ $mg->minggu_ke }}</option>';
            @endforeach
            newTextBoxDiv.after().html('<div class="row hapus">' +
                '<div class="col-md-8">' +
                '<div class="form-group">' +
                '<div class="input-group hapus">' +
                '<div class="input-group-append">' +
                '        <button class="btn btn-info" type="button" title="File Pendukung"><i class="fas fa-file" ></i></button>' +
                '    </div>' +
                '<input id="file_lampiran' + counter_lam + '" type="file" name="file_lampiran[]" class="form-control upload-file"><br>' +
                '<div class="input-group-append">' +
                '    <button class="btn btn-outline-danger hapus_lampiran" type="button"' +
                '        ><i class="fas fa-trash"></i></button>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4">' +
                '<div class="form-group">' +
                '<input type="hidden" name="keterangan_file[]" class=" form-control  form-control-sm" value="-" placeholder="Keterangan" required>' +
                '<select class="form-control form-control-sm" name="minggu_ke[]" required><option value="">Minggu Ke </option>' + om_ + '</select>' +
                '</div>' +
                '</div>' +
                '</div>');

            newTextBoxDiv.appendTo("#formLampiran");
            $(document).on('change', "#file_lampiran" + counter_lam, function(e) {
                filename = $(this).val().split('\\').pop();
                la = filename.split('.');
                vexe = ['jpeg', 'jpg', 'png', 'pdf', 'PDF'];
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

        });

        $(document).on('click', '.hapus_lampiran', function(e) {
            counter_lam--;
            $(this).parents(".hapus").remove();
            console.log(counter_lam);
            if (counter_lam == '0') {
                $('#upload').addClass('d-none');
            }
        });
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

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

        //   line chart
        var areaChartData = {
            labels: [<?=
                        substr($minggubar, 0, -1)
                        ?>],
            datasets: [{
                    label: 'Kumultaif perencanaan (%)',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [<?=
                            substr($targetbar, 0, -1)
                            ?>]
                },
                {
                    label: 'Kumulatif realisasi (%)',
                    backgroundColor: 'rgb(247, 5, 13)',
                    borderColor: 'rgb(247, 5, 13)',
                    pointRadius: false,
                    pointColor: 'rgb(247, 5, 13)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: [<?=
                            substr($realisasibar, 0, -1)
                            ?>]
                },
            ]
        }

        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            title: {
                display: true,
                text: 'Kurva S'
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: true,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: true,
                    }
                }]
            }
        }


        var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
        var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
        var lineChartData = jQuery.extend(true, {}, areaChartData)
        lineChartData.datasets[0].fill = false;
        lineChartData.datasets[1].fill = false;
        lineChartOptions.datasetFill = false

        var lineChart = new Chart(lineChartCanvas, {
            type: 'line',
            data: lineChartData,
            options: lineChartOptions
        })
    </script>
    @stop