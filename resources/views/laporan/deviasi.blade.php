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
                            <th>Minggu Ke</th>
                            <td>Realisasi</td>
                            <td>Deviasi</td>
                            <th>Keterangan</th>
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
            ajax: "{{ url('laporan/deviasi') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_kegiatan',
                    name: 'nama_kegiatan',
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'>" + row.tahun_anggaran + "</span>";
                    }
                },
                {
                    data: 'minggu_ke',
                    name: 'minggu_ke',
                    className: "text-right",
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'>Pekerjaan : " + tanggal(row.tm) + " s/d " + tanggal(row.ts) + "</span>";
                    }
                },
                {
                    data: 'realisasi',
                    name: 'realisasi',
                    render: function(data, type, row) {
                        return data + "%<br><span class='text-muted'>Target :" + row.rencana + "%</span>";
                    }
                },
                {
                    data: 'deviasi',
                    name: 'deviasi',
                    render: function(data, type, row) {
                        return data + "%";
                    }
                },
                {
                    data: 'peringatan_nama',
                    name: 'peringatan_nama',
                    
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