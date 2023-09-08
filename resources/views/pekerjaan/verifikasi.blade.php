@extends('adminlte::page')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    
</div>
<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="table-responsive">
                <table class="table table-hover text-nowrap " id="table">
                    <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Realisasi</th>
                            <th>Pekerjaan</th>
                            <th>Pengawas</th>
                            <th>Peneyedia</th>
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
            ajax: "{{ url('progresverifikasi') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'realisasi',
                    name: 'realisasi',
                    render: function(data, type, row) {
                        deviasi=row.deviasi;
                        return data.replace('.', ',') + "% <br><span class='text-danger'>deviasi :"+deviasi.replace('.', ',')+"%<span><br><span class='text-sm text-muted'>Minggu Ke " + row.minggu_ke + " : " + tanggal(row.tanggal_mulai) + " s/d " + tanggal(row.tanggal_selesai) + "<span>";
                    }
                },
                {
                    data: 'nama_kegiatan',
                    name: 'nama_kegiatan',
                    render: function(data, type, row) {
                        return data + "<br><span class='text-success'>" + row.tahun_anggaran + "</span>";
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
            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var input = document.createElement('input');
                    $(input).appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());

                            column.search(val ? val : '', true, false).draw();
                        });
                });
            },
            search: {
                "regex": true
            },
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