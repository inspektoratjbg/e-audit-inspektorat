@extends('adminlte::page')
@section('content_header')
<h1>{{ $title }}</h1>
@stop
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap " id="table">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Pekerjaan</th>
                            <th>Anggaran</th>
                            <th>PPK</th>
                            <th>Konsultan Pengawas</th>
                            <th>Waktu Pekerjaan</th>
                            <th width="120px"></th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>



@stop
@section('js')
<script>
    $(document).ready(function() {
        // console.log("ready!");
        $('#table').DataTable({
            processing: true,
            ordering: false,
            serverSide: false,
            ajax: "{{ url('laporan/belum') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_pekerjaan',
                    name: 'nama_pekerjaan',
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'>" + row.tahun_anggaran + "</span>";
                    }
                },
                
                {
                    data: 'nilai_kon',
                    name: 'nilai_kon',
                },
                {
                    data: 'ppk_nama',
                    name: 'ppk_nama',
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'>" + row.nama_unit + "</span>";
                    }
                },
                {
                    data: 'konsultan_nama',
                    name: 'konsultan_nama',
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'>SK : " + row.no_sk + "</span>";
                    }
                },
                {
                    data: 'tanggal_mulai',
                    name: 'tanggal_mulai',
                    render: function(data, type, row) {
                        return tanggal(row.tanggal_mulai) + " s/d " + tanggal(row.tanggal_selesai);
                    }
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