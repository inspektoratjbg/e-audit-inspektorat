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
                            <th>Pagu</th>
                            <th>HPS</th>
                            <th>Nilai Kontrak</th>
							<th>%</th>
                            <th>Nama Penyedia</th>
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
            ajax: "{{ url('laporan/hps') }}",
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
                    data: 'pagu_anggaran',
                    name: 'pagu_anggaran',
                    className: "text-right",
                    render: function(data, type, row) {
                        return formatangka(data) ;
                    }
                },
                {
                    data: 'harga_perkiraan',
                    name: 'harga_perkiraan',
                    className: "text-right",
                    render: function(data, type, row) {
                        return formatangka(data) ;
                    }
                },
                {
                    data: 'nilai_kontrak',
                    name: 'nilai_kontrak',
                    className: "text-right",
                    render: function(data, type, row) {
                        return formatangka(data);
                    }
                },
				{
                    data: 'persen',
                    name: 'persen',
                    className: "text-right",
                     
                },
                {
                    data: 'nama_penyedia',
                    name: 'nama_penyedia',
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