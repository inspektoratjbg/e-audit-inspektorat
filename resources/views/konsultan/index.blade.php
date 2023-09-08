@extends('adminlte::page')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    <div class="float-sm-right">
        @if(userCan('konsultan.create'))
        <a href="{{ route('konsultan.create')}}" class="btn btn-sm btn-primary"><i class=" fas fa-plus-square"></i> Tambah</a>
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
                            <th>Konsultan</th>
                            <th>Telp </th>
                            <th>Email </th>
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
            ajax: "{{ url('konsultan') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'nama_konsultan',
                    name: 'nama_konsultan'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp',

                },
                {
                    data: 'email',
                    name: 'email',

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