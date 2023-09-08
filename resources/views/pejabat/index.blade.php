@extends('adminlte::page')
@section('content_header')
<h1>{{ $title }}</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="3px">No</th>
                    <th>Jabatan</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th width="3px"></th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @foreach($pejabat as $rp)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $rp->jabatan }}</td>
                    <td>{{ $rp->nama_pejabat }}</td>
                    <td>{{ $rp->email }}</td>
                    <td align="center">
                        <a href="{{ route('pejabat.edit', $rp->id) }}" class="btn btn-sm btn-success"><i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</div>
@stop
@section('css')

@endsection
@section('js')

@stop