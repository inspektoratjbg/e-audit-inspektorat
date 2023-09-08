@extends('adminlte::page')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Reset Password Pengguna</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">

            </div><!-- /.col -->
        </div><!-- /.row -->

    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            {{-- <img class="profile-user-img img-fluid img-circle" src="{{ url('/user.png') }}" alt="User profile picture"> --}}
                        </div>
                        <h3 class="profile-username text-center">{{ $user->name }}</h3>
                        <p class="text-muted text-center">{{ $user->email }}</p>
                        <strong><i class="fas fa-book mr-1"></i> Role</strong>
                        <ol class="text-muted">
                            @foreach($role as $rl)
                            <Li>{{ $rl }}</Li>
                            @endforeach
                        </ol>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-4">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <div class="card-title">
                            Ganti Password
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('passactiondua') }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}

                            <input type="hidden" name="id" value="{{ $user->id}}">
                            <div class="form-group">
                                <label for="">Password Baru</label>
                                <input type="password" name="password_baru" id="password_baru" class="form-control {{ $errors->has('password_baru') ? 'is-invalid' : ''}}">
                                @if ($errors->has('password_baru'))
                                <span class="error invalid-feedback"> {{ $errors->first('password_baru') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="">Konfirmasi Password</label>
                                <input type="password" name="password_konfirmasi" id="password_konfirmasi" class="form-control {{ $errors->has('password_konfirmasi') ? 'is-invalid' : ''}}">
                                @if ($errors->has('password_konfirmasi'))
                                <span class="error invalid-feedback"> {{ $errors->first('password_konfirmasi') }}</span>
                                @endif
                            </div>
                            <button class="btn btn-sm btn-info"><i class="fas fa-save"></i> Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>

@stop
