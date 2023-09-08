@extends('adminlte::page')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    <div class="float-sm-right">
        @if(userCan('pekerjaan.create'))
        <a href="{{ route('pekerjaan.create')}}" class="btn btn-sm btn-primary"><i class=" fas fa-plus-square"></i> Tambah</a>
        @endif
    </div><!-- /.col -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap " id="table">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Pekerjaan</th>
                            <th>PPK</th>
                            <th>Penyedia</th>
                            <th>Realisasi</th>
                            <th>Nilai SPK / Kontrak</th>
                            <th width="80px"></th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>
@stop
@section('script')
<style>
    .text-wrap {
        white-space: normal;
    }

    .width-200 {
        width: 300px;
    }
</style>
@stop
@section('js')
<script>
    $(document).ready(function() {
        // console.log("ready!");
        $('#table').DataTable({
            // deferRender: true,
            scrollX: false,
            
            processing: true,
            ordering: false,
            serverSide: false,
            ajax: "{{ route('pekerjaan.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_pekerjaan',
                    name: 'nama_pekerjaan',
                    render: function(data, type, row) {
                        return "<div class='text-wrap width-200'>"+data + "<br><span class='text-info'>" + row.nama_unit + "</span><br><span class='text-success'>" + row.tahun_anggaran + "</span><br><span class='text-warning'>" + row.status_name + "</span></div>";
                    }
                },
                {
                    data: 'ppk_nama',
                    name: 'ppk_nama',
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'> Pgws : " + row.konsultan_nama + "</span>";
                    }
                },
                {
                    data: 'nama_penyedia',
                    name: 'nama_penyedia',
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'>" + row.no_sk + "</span>";
                    }
                },
                {
                    data: 'terkini',
                    name: 'terkini',
                },
                {
                    data: 'nilai_kon',
                    name: 'nilai_kon',
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
            ],
            fnCreatedRow: function(row, data, index) {
                $('td', row).eq(0).html(index + 1);
            }
        });
    });


    function tanggal(tgl) {
        string = tgl.split('-');
        return tgl[2] + "-" + string[1] + "-" + string[0];

    }
</script>
@stop