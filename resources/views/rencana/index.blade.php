@extends('adminlte::page')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
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
                            <th>Nilai Kontrak</th>
                            <!-- <th>Status</th> -->
                            <th width="80px"></th>
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
            ajax: "{{ route('perencanaan.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_kegiatan',
                    name: 'nama_kegiatan',
                    render: function(data, type, row) {
                        // return data + "<br><span class='text-info'>"+row.nama_unit+"</span><br><span class='text-success'>" + row.tahun_anggaran + "</span>";
                        return data + "<br><span class='text-info'>" + row.nama_unit + "</span><br><span class='text-success'>" + row.tahun_anggaran + "</span><br><span class='text-warning'>"+row.status_name+"</span>";
                    }
                },
                {
                    data: 'ppk_nama',
                    name: 'ppk_nama',
                    render:function(data,type,row){
                        return data+"<br><span class='text-success'> Pengawas : "+row.konsultan_nama+"</span>";
                    }
                },
                {
                    data: 'nama_penyedia',
                    name: 'nama_penyedia',
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'>SK : " + row.no_sk + "</span>";
                    }
                },
                {
                    data: 'nilai_kon',
                    name: 'nilai_kon',
                },
                /* {
                    data: 'status_name',
                    name: 'status_name',
                }, */
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
        return tgl[2]+"-"+string[1]+"-"+string[0];

    }
</script>
@stop