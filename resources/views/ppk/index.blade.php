@extends('adminlte::page')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
        <div class="float-sm-right">
            @if (userCan('ppk.create'))
                <a href="{{ route('ppk.create') }}" class="btn btn-sm btn-primary"><i class=" fas fa-plus-square"></i>
                    Tambah</a>
            @endif
        </div><!-- /.col -->

    </div>
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="table-responsive">
                    <table class="table table-hover text-nowrap " id="table">
                        <thead>
                            <tr>
                                <th width="10px">No</th>
                                <th>Satuan Kerja</th>
                                <th>Nama</th>
                                <th>Telp </th>
                                <th>Kontak </th>
                                <th>Nomor SK </th>
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
                ajax: "{{ url('ppk') }}",
                // order: [[ 0, "desc" ]],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama_unit',
                        name: 'nama_unit',
                        visible: false
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        render: function(data, type, row) {
                            return data + "<br><span class='text-muted'>" + row.nama_unit +
                                "</span>";
                        }
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp',
                        visible: false
                    },
                    {
                        data: 'email',
                        name: 'email',
                        render: function(data, type, row) {
                            return data + "<br><span class='text-muted'>" + row.no_hp + "</span>";
                        }
                    },
                    {
                        data: 'no_sk',
                        name: 'no_sk',
                        render: function(data, type, row) {
                            return data + "<br><span class='text-muted'>" + row.tgl_sk + "</span>";
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

    </script>
@stop
