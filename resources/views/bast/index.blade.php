@extends('adminlte::page')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <div class="float-sm-right">
            @if (userCan('bast.create'))
                <a href="{{ route('bast.create') }}" class="btn btn-sm btn-primary"><i class=" fas fa-plus-square"></i>
                    Tambah</a>
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
                                <th>No BAST</th>
                                <th>Keterangan</th>
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
                ajax: "{{ route('bast.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama_pekerjaan',
                        name: 'nama_pekerjaan',
                        render:function(data,type,row){
                            return data+"<br><span class='text-muted'>"+row.nama_unit+"</span>";
                        }
                    },
                    {
                        data: 'no_bast',
                        name: 'no_bast',
                        render: function(data, type, row) {
                            return data + "<br><span class='text-success'> Tanggal : " + tanggal(row.tgl_bast) + "</span>";
                        }
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan',
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
