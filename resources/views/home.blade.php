@extends('adminlte::page')
@section('content')
<div class="row">
    <div class="col-md-6">
        <!-- TABLE: LATEST ORDERS -->
        <div class="card">
            <div class="card-header border-transparent">
                <!-- <h3 class="card-title"></h3> -->
                <div class="user-block">
                    <img class="img-circle" src="{{ asset('grafik.png') }}" alt="User Image">
                    <span class="username"><a href="#">Deviasi Pekerjaan Per {{ tgl_indo(date('ymd')) }}</a></span>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Pekerjaan</th>
                                <th>Target</th>
                                <th>Realisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deviasi as $dv)
                            <tr>
                                <td class="text-primary">
                                    {{ $dv->nama_pekerjaan }}<br>
                                    <span class="text-muted">{{ $dv->nama_penyedia }}</span>
                                </td>
                                <td>
                                    {{ number_format($dv->target,2,',','.') }}
                                </td>
                                <td>
                                    {{ number_format($dv->realisasi,2,',','.') }}<br>
                                    <span class="text-danger">{{ number_format($dv->deviasi,2,',','.') }}</span>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>

        </div>
        <!-- /.card -->
    </div>
    <div class="col-md-6">
        <div class="card card-widget">
            <div class="card-header">
                <div class="user-block">
                    <img class="img-circle" src="{{ asset('toa.png') }}" alt="User Image">
                    <span class="username"><a href="#">Pemberitahuan</a></span>
                </div>

                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body card-comments">
                @foreach($verifikasi as $ver)
                <div class="card-comment">
                    <img class="img-circle img-sm" src="{{ asset('user.png') }}" alt="User Image">
                    <div class="comment-text">
                        <span class="username">
                            {{ $ver->nama_konsultan}}
                            <span class="text-muted float-right"> @if( tgl_indo($ver->created_at) != tgl_indo(date('Y-m-d')) ) {{ tgl_indo($ver->created_at) }} , @else Hari ini @endif {{ waktu($ver->created_at)}} </span>
                        </span><!-- /.username -->
                        <p>Entri progres pekerjaan {{ $ver->nama_pekerjaan }} Minggu Ke {{ $ver->minggu_ke}}  Realisasi : {{ number_format($ver->realisasi,2,',','.') }} </p>
                        <!-- <button type="button" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i> Verifikasi</button> -->
                        <!-- <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button> -->
                    </div>
                    <!-- /.comment-text -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@stop
@section('js')
<script>
    $(document).ready(function() {

    });
</script>
@stop