@extends('adminlte::page')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Form Permission</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Sistem</a></li>
                    <li class="breadcrumb-item"><a href="/permission">Permission</a></li>
                    <li class="breadcrumb-item active">Form Permission</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->

    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ $data['action'] }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field($data['method']) }}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Permission</label>
                                        <input type="text" name="name" value="{{ $data['permission']->name??'' }}" id="permission" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label for="">Role</label>
                                    <div class="row">
                                        @foreach($data['role'] as $role)
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox mr-sm-2">
                                                    <input @if(!empty($data['permission'])) @if($role->hasPermissionTo($data['permission']->name)) checked @endif @endif type="checkbox" class="custom-control-input" name="role[]" id="{{ $role->name }}" value="{{ $role->name }}">
                                                    <label class="custom-control-label" for="{{ $role->name }}">{{ $role->name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit"><i class="fa fa-check"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@stop