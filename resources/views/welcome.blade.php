<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Pelayanan PBB P2</title>
    <meta content="PBB p2 kab malang" name="keywords">
    <meta content="Pelayanan PBB P2 Bapenda Kabupaten Malang" name="descriptison">

    <!-- Favicons -->
    <link href="{{ asset('vesperr/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('vesperr/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('vesperr/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('vesperr/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
    <link href="{{ asset('vesperr/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{ asset('vesperr/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('vesperr/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('vesperr/assets/vendor/venobox/venobox.css')}}" rel="stylesheet">
    <link href="{{ asset('vesperr/assets/vendor/aos/aos.css')}}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('vesperr/assets/css/style.css')}}" rel="stylesheet">

    <style>
        .validate {
            color: red;
        }
    </style>

</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center">

            <div class="logo mr-auto">
                <a href="http://sipanji.id"><img height="80px" src="{{ asset('vesperr/logo.png')}}" alt="" class="img-fluid"></a>
            </div>
            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li class="active"><a href="#header">Home</a></li>
                    <li><a href="#features">Pelayanan</a></li>
                    {{--
                    <li><a href="#sknjop">SK NJOP</a></li>
                    <li><a href="#pembayaranpbb">RIWAYAT PEMBAYARAN</a></li>
                    --}}
                    <li class="drop-down"><a href="#">Pengajuan</a>
                        <ul>
                            <li><a href="{{ url('login') }}">Login</a></li>
                            <li><a href="{{ url('register') }}">Registrasi</a></li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- .nav-menu -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up" style="color:#00bde4">Adaptasi Kebiasaan Baru</h1>
                    <h2 data-aos="fade-up" data-aos-delay="400">Dimasa pandemi Covid 19, BAPENDA Kabupaten Malang berusaha tetap memberikan pelayanan terbaik kepada masyarakat dengan menghadirkan LAYANAN PBB - P2 secara online. </h2>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
                    <img src="{{ asset('vesperr/assets/img/hero-img.png')}}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- End Hero -->

    <main id="main">


        <!-- ======= Clients Section ======= -->
        <section id="clients" class="clients clients">
            <div class="container">

                <div class="row">
                    <div class="col-lg-2 col-md-4 col-6">
                        <img src="{{ asset('bg.png') }}" class="img-fluid" alt="" data-aos="zoom-in">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                        <img src="{{ asset('bg.png') }}" class="img-fluid" alt="" data-aos="zoom-in">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                        <img src="{{ asset('bg.png') }}" class="img-fluid" alt="" data-aos="zoom-in">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                        <img src="{{ asset('bg.png') }}" class="img-fluid" alt="" data-aos="zoom-in">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                        <img src="{{ asset('bg.png') }}" class="img-fluid" alt="" data-aos="zoom-in">
                    </div>

                    <div class="col-lg-2 col-md-4 col-6">
                        <img src="{{ asset('bg.png') }}" class="img-fluid" alt="" data-aos="zoom-in">
                    </div>

                </div>

            </div>
        </section><!-- End Clients Section -->

        <section id="features" class="features">
            <div class="container">

                <div class="section-title" data-aos="fade-up">
                    <h2>Pelayanan</h2>
                    <p>Jenis Pelayanan yang tersedia PBB P2</p>
                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="300">
                    <div class="col-lg-3 col-md-4">
                        <div class="icon-box">
                            <i class="icofont-edit" style="color: #ffbb2c;"></i>
                            <h3><a href="#">PENDAFTARAN DATA BARU</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
                        <div class="icon-box">
                            <i class="icofont-exchange" style="color: #5578ff;"></i>
                            <h3><a href="#">MUTASI OBJEK/SUBJEK</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
                        <div class="icon-box">
                            <i class="icofont-ui-edit" style="color: #e80368;"></i>
                            <h3><a href="#">PEMBETULAN SPPT/SKP/STP</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4 mt-lg-0">
                        <div class="icon-box">
                            <i class="icofont-ui-close" style="color: #e361ff;"></i>
                            <h3><a href="#">PEMBATALAN SPPT/SKP</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="icofont-copy-invert" style="color: #47aeff;"></i>
                            <h3><a href="#">SALINAN SPPT/SKP</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="icofont-listing-box" style="color: #ffa76e;"></i>
                            <h3><a href="#">KEBERATAN PENUNJUKAN WAJIB PAJAK</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="icofont-money" style="color: #11dbcf;"></i>
                            <h3><a href="#">KEBERATAN ATAS PAJAK TERHUTANG</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="ri-price-tag-2-line" style="color: #4233ff;"></i>
                            <h3><a href="#">PENGURANGAN ATAS BESARNYA PAJAK TERHUTANG</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="ri-anchor-line" style="color: #b2904f;"></i>
                            <h3><a href="#">RESTITUSI DAN KOMPENSASI</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="ri-disc-line" style="color: #b20969;"></i>
                            <h3><a href="#">PENGURANGAN DENDA ADMINISTRASI</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="ri-base-station-line" style="color: #ff5828;"></i>
                            <h3><a href="#">PENENTUAN KEMBALI TANGGAL JATUH TEMPO</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <!-- <i class="ri-fingerprint-line" style="color: #29cc61;"></i> -->
                            <i class="icofont-calendar" style="color: blueviolet;"></i>
                            <h3><a href="#">PENUNDAAN TANGGAL JATUH TEMPO SPOP</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="icofont-data" style="color:yellowgreen "></i>
                            <h3><a href="#">PEMBERIAN INFORMASI PBB</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="icofont-card" style="color:violet"></i>
                            <h3><a href="#">PEMBETULAN SK KEBERATAN</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">

                            <i class="icofont-box" style="color:green"></i>
                            <h3><a href="#">PENERBITAN KEMBALI</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="icofont-badge" style="color:yellow"></i>
                            <h3><a href="#">FASUM</a></h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 mt-4">
                        <div class="icon-box">
                            <i class="icofont-attachment" style="color: blue;"></i>
                            <h3><a href="#">SK NJOP</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- End Features Section -->

        <!-- ======= sknjop Section ======= -->
        {{--
        <section id="sknjop" class="contact">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Permohonan SK NJOP</h2>
                </div>
                <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
                    <div class="col-lg-12 col-md-12" data-aos="fade-up" data-aos-delay="300">
                        @if ($message = Session::get('status'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
        @if($cetak=Session::get('cetak'))
        atau bisa di cetak langsung dengan <a target="_blank" href="{{ $cetak }}">Klik disini</a>
        @endif
        </div>
        @endif

        <form onsubmit="return confirm('pastikan data yang anda kirimkan valid. apabila dokumen tidak valid , maka ajuan tidak diproses');" action="{{ url('prosesnjop') }}" method="post" role="form" class="phpa-email-form" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <div class="row">
                <div class="col-md-4">
                    <input type='hidden' class='form-control' name='tahun_pajak' id='tahun_pajak' value="{{ date('Y') }}" placeholder='Tahun Pajak (*)' realonly data-rule='' data-msg=''>
                    <div class="form-group">
                        <input type='text' class='form-control' maxlength="16" onchange="return checkLength(this)" onkeypress="return isNumber(event)" name='nik' value="{{ old('nik') }}" id='nik' placeholder='NIK (*)' data-rule='minlen:16' data-msg='Masukan NIK 16 digit'>
                        <div id="msg_nik" class="validate">{{ $errors->has('nik')? $errors->first('nik'):'' }}</div>
                    </div>
                    <div class="form-group">
                        <input type='text' class='form-control' name='nama' id='nama' placeholder='Nama Pemohon (*)' value="{{ old('nama') }}" data-rule='required' data-msg='Nama pemohon (*)'>
                        <div class="validate">{{ $errors->has('nama')? $errors->first('nama'):'' }}</div>
                    </div>
                    <div class="form-group">
                        <input type='text' class='form-control' name='alamat' id='alamat' placeholder='Alamat pemohon (*)' value="{{ old('alamat') }}" data-rule='required' data-msg='Alamat pemohon (*)'>
                        <div class="validate">{{ $errors->has('alamat')? $errors->first('alamat'):'' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control' name='rt' id='rt' value="{{ old('rt') }}" placeholder='RT (*)' data-rule='required' data-msg='Data RT (*)'>
                                <div class="validate">{{ $errors->has('rt')? $errors->first('rt'):'' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control' name='rw' id='rw' placeholder='RW (*)' value="{{ old('rw') }}" data-rule='required' data-msg='Data RT (*)'>
                                <div class="validate">{{ $errors->has('rw')? $errors->first('rw'):'' }}</div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control' name='desa' id='desa' value="{{ old('desa') }}" placeholder='Desa / Kelurahan (*)' data-rule='required' data-msg='Masukan data Desa / Kelurahan'>
                                <div class="validate">{{ $errors->has('desa')? $errors->first('desa'):'' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control' name='kecamatan' id='kecamatan' value="{{ old('kecamatan') }}" placeholder='Kecamatan (*)' data-rule='required' data-msg='Masukan data Kecamatan'>
                                <div class="validate">{{ $errors->has('kecamatan')? $errors->first('kecamatan'):'' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type='text' class='form-control' name='kabupaten' id='kabupaten' value="{{ old('kabupaten') }}" placeholder='Kabupaten (*)' data-rule='required' data-msg='Masukan data kabupaten'>
                        <div class="validate">{{ $errors->has('kabupaten')? $errors->first('kabupaten'):'' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control' name='no_telp' id='no_telp' value="{{ old('no_telp') }}" placeholder='Telepon (*)' data-rule='required' data-msg='Masukan data telepon'>
                                <div class="validate">{{ $errors->has('no_telp')? $errors->first('no_telp'):'' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control' name='email' id='email' placeholder='Email (*)' value="{{ old('email') }}" data-rule='email' data-msg='Masukan data email'>
                                <div class="validate">{{ $errors->has('email')? $errors->first('email'):'' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type='text' class='form-control nop' name='nop' id='nop' onkeyup="formatnop(this)" onblur="checkLengthnop(this)" onkeypress="return isNumber(event)" placeholder='NOP / Nomor objek pajak (*)' data-rule='required' data-msg='Masukan data NOP'>
                        <div id='VAL_NOP' class="VAL_NOP validate">{{ $errors->has('nop')? $errors->first('nop'):'' }}</div>
                    </div>
                    <div class="form-group">
                        <input type='text' class='form-control alamat_op' name='alamat_op' id='alamat_op' placeholder='Alamat objek' data-rule='required' data-msg='Masukan amlamat objek'>
                        <div class="validate">{{ $errors->has('alamat_op')? $errors->first('alamat_op'):'' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control rt_op' name='rt_op' id='rt_op' placeholder='RT Objek'>
                                <div class="validate">
                                    {{ $errors->has('rt_op')? $errors->first('rt_op'):'' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control rw_op' name='rw_op' id='rw_op' placeholder='RW Objek'>
                                <div class="validate">{{ $errors->has('rw_op')? $errors->first('rw_op'):'' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control desa_op' name='desa_op' id='desa_op' placeholder='Desa Objek' data-rule='required' data-msg='Masukan desa objek'>
                                <div class="validate">{{ $errors->has('desa_op')? $errors->first('desa_op'):'' }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type='text' class='form-control kecamatan_op' name='kecamatan_op' id='kecamatan_op' placeholder='Kecamatan Objek' data-rule='required' data-msg='Masukan data kecamatan objek'>
                                <div class="validate">{{ $errors->has('kecamatan_op')? $errors->first('kecamatan_op'):'' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type='text' class='form-control kabupaten_op' name='kabupaten_op' id='kabupaten_op' placeholder='Kabupten Objek' data-rule='required' data-msg='Masukan data kabupaten objek' Value="Malang">
                        <div class="validate">{{ $errors->has('kabupaten_op')? $errors->first('kabupaten_op'):'' }}</div>
                    </div>
                    <div class="form-group">
                        <textarea name="keterangan" id="keterangan" class="form-control" cols="30" rows="2" placeholder="Keterangan"></textarea>
                        <div class="validate"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">KTP (*)</label>
                        <input type="file" name="file_ktp" id="file_ktp" class="form-control" accept="image/*">
                        <div class="validate">{{ $errors->has('file_ktp')? $errors->first('file_ktp'):'' }}</div>
                    </div>
                    <div class="form-group">
                        <label for="">SPPT (*)</label>
                        <input type="file" name="file_sppt" id="file_sppt" class="form-control" accept="image/*">
                        <div class="validate">{{ $errors->has('file_sppt')? $errors->first('file_sppt'):'' }}</div>
                    </div>
                    <div class="form-group">
                        <label for="">Bukti Pembayaran / STTS (*)</label>
                        <input type="file" name="file_bukti_bayar" id="file_bukti_bayar" class="form-control" accept="image/*">
                        <div class="validate">{{ $errors->has('file_bukti_bayar')? $errors->first('file_bukti_bayar'):'' }}</div>
                    </div>
                </div>
            </div>


            <div class="text-center"><button class="btn btn-info" type="submit">Submit</button> (*) <span style="color:red">Wajib diisi</span></div>
        </form>
        </div>

        </div>

        </div>
        </section>

        <!-- End Contact Section -->
        <!-- ======= riwayat pbb Section ======= -->
        <section id="pembayaranpbb" class="contact">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Permohonan Riwayat Pembayaran PBB</h2>
                </div>
                <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
                    <div class="col-lg-12 col-md-12" data-aos="fade-up" data-aos-delay="300">
                        @if ($message = Session::get('statusa'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                            @if($cetak=Session::get('cetak'))
                            atau bisa di cetak langsung dengan <a target="_blank" href="{{ $cetak }}">Klik disini</a>
                            @endif
                        </div>
                        @endif

                        <form onsubmit="return confirm('pastikan data yang anda kirimkan valid. apabila dokumen tidak valid , maka ajuan tidak diproses');" action="{{ url('prosesriwayatpbb') }}" method="post" role="form" class="phpa-email-form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('POST') }}
                            <div class="row">
                                <div class="col-md-4">
                                    <input type='hidden' class='form-control' name='b_tahun_pajak' id='b_tahun_pajak' value="{{ date('Y') }}" placeholder='Tahun Pajak' realonly data-rule='' data-msg=''>
                                    <div class="form-group">
                                        <input type='text' class='form-control' maxlength="16" onchange="return checkLength(this)" onkeypress="return isNumber(event)" name='b_nik' value="{{ old('nik') }}" id='b_nik' placeholder='NIK' data-rule='minlen:16' data-msg='Masukan NIK 16 digit'>
                                        <div id="msg_nik" class="validate">{{ $errors->has('b_nik')? $errors->first('b_nik'):'' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <input type='text' class='form-control' name='b_nama' id='b_nama' placeholder='Nama Pemohon' value="{{ old('nama') }}" data-rule='required' data-msg='Masukan nama pemohon'>
                                        <div class="validate">{{ $errors->has('b_nama')? $errors->first('b_nama'):'' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <input type='text' class='form-control' name='b_alamat' id='b_alamat' placeholder='Alamat pemohon' value="{{ old('alamat') }}" data-rule='required' data-msg='Masukan alamat pemohon'>
                                        <div class="validate">{{ $errors->has('b_alamat')? $errors->first('b_alamat'):'' }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control' name='b_rt' id='b_rt' value="{{ old('rt') }}" placeholder='RT' data-rule='required' data-msg='Masukan data RT'>
                                                <div class="validate">{{ $errors->has('b_rt')? $errors->first('b_rt'):'' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control' name='b_rw' id='b_rw' placeholder='RW' value="{{ old('rw') }}" data-rule='required' data-msg='Masukan data RT'>
                                                <div class="validate">{{ $errors->has('b_rw')? $errors->first('b_rw'):'' }}</div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control' name='b_desa' id='b_desa' value="{{ old('desa') }}" placeholder='Desa / Kelurahan' data-rule='required' data-msg='Masukan data Desa / Kelurahan'>
                                                <div class="validate">{{ $errors->has('b_desa')? $errors->first('b_desa'):'' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control' name='b_kecamatan' id='b_kecamatan' value="{{ old('kecamatan') }}" placeholder='Kecamatan' data-rule='required' data-msg='Masukan data Kecamatan'>
                                                <div class="validate">{{ $errors->has('b_kecamatan')? $errors->first('b_kecamatan'):'' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type='text' class='form-control' name='b_kabupaten' id='b_kabupaten' value="{{ old('kabupaten') }}" placeholder='Kabupaten' data-rule='required' data-msg='Masukan data kabupaten'>
                                        <div class="validate">{{ $errors->has('b_kabupaten')? $errors->first('b_kabupaten'):'' }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control' name='b_no_telp' id='b_no_telp' value="{{ old('no_telp') }}" placeholder='Telepon' data-rule='required' data-msg='Masukan data telepon'>
                                                <div class="validate">{{ $errors->has('b_no_telp')? $errors->first('b_no_telp'):'' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control' name='b_email' id='b_email' placeholder='Email' value="{{ old('email') }}" data-rule='email' data-msg='Masukan data email'>
                                                <div class="validate">{{ $errors->has('b_email')? $errors->first('b_email'):'' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type='text' class='form-control nop' name='b_nop' id='b_nop' onkeyup="formatnop(this)" onblur="checkLengthnop(this)" onkeypress="return isNumber(event)" placeholder='NOP / Nomor objek pajak' data-rule='required' data-msg='Masukan data NOP'>
                                        <div id='b_VAL_NOP' class="VAL_NOP validate">{{ $errors->has('b_nop')? $errors->first('b_nop'):'' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <input type='text' class='form-control alamat_op' name='b_alamat_op' id='b_alamat_op' placeholder='Alamat objek' data-rule='required' data-msg='Masukan amlamat objek'>
                                        <div class="validate">{{ $errors->has('b_alamat_op')? $errors->first('b_alamat_op'):'' }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control rt_op' name='b_rt_op' id='b_rt_op' placeholder='RT Objek'>
                                                <div class="validate">
                                                    {{ $errors->has('b_rt_op')? $errors->first('b_rt_op'):'' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control rw_op' name='b_rw_op' id='b_rw_op' placeholder='RW Objek'>
                                                <div class="validate">{{ $errors->has('b_rw_op')? $errors->first('b_rw_op'):'' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control desa_op' name='b_desa_op' id='b_desa_op' placeholder='Desa Objek' data-rule='required' data-msg='Masukan desa objek'>
                                                <div class="validate">{{ $errors->has('b_desa_op')? $errors->first('b_desa_op'):'' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input type='text' class='form-control kecamatan_op' name='b_kecamatan_op' id='b_kecamatan_op' placeholder='Kecamatan Objek' data-rule='required' data-msg='Masukan data kecamatan objek'>
                                                <div class="validate">{{ $errors->has('b_kecamatan_op')? $errors->first('b_kecamatan_op'):'' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type='text' class='form-control kabupaten_op' name='b_kabupaten_op' id='b_kabupaten_op' placeholder='Kabupten Objek' data-rule='required' data-msg='Masukan data kabupaten objek' Value="Malang">
                                        <div class="validate">{{ $errors->has('b_kabupaten_op')? $errors->first('b_kabupaten_op'):'' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <textarea name="b_keterangan" id="keterangan" class="form-control" cols="30" rows="2" placeholder="Keterangan"></textarea>
                                        <div class="validate"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">SPPT</label>
                                        <input type="file" name="b_file_sppt" id="file_sppt" class="form-control" accept="image/*">
                                        <div class="validate">{{ $errors->has('b_file_sppt')? $errors->first('b_file_sppt'):'' }}</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Bukti Pembayaran / STTS</label>
                                        <input type="file" name="b_file_bukti_bayar" id="file_bukti_bayar" class="form-control" accept="image/*">
                                        <div class="validate">{{ $errors->has('b_file_bukti_bayar')? $errors->first('b_file_bukti_bayar'):'' }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center"><button class="btn btn-info" type="submit">Submit</button></div>
                        </form>
                    </div>

                </div>

            </div>
        </section>
        --}}

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 text-lg-left text-center">
                    <div class="copyright">
                        &copy; Copyright <strong>BAPENDA Kabupten Malang</strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                </div>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('Vesperr/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('Vesperr/assets/vendor/aos/aos.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('Vesperr/assets/js/main.js') }}"></script>
    <script>
        // b_nop
        $(".nop,.b_nop").on('keyup keypress change  keydown', function() {
            console.log("Cari NOP")
            var vnop = $(this).val();
            var nopv = vnop.replace(/[^\d]/g, "");

            if (nopv.length == 18) {
                $.ajax({
                    url: "{{ url('cekop') }}",
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'nop': nopv
                    },
                    beforeSend: function() {
                        // loading();
                        // $('.loading').show();
                        $('html, body').css("cursor", "wait");
                    },
                    dataType: "html",
                    success: function(result) {
                        $('html, body').css("cursor", "default");

                        var datashow = JSON.parse(result);

                        if (datashow[0].kode != '1') {
                            $(".VAL_NOP").html("<span style='color:red'>NOP tidak ditemukan.</span>");
                        } else {
                            $(".VAL_NOP").html("<span style='color:green'>NOP valid.</span>");
                        }

                        $(".alamat_op").val(datashow[0].alamat_op);
                        $(".rt_op").val(datashow[0].rt_op);
                        $(".rw_op").val(datashow[0].rw_op);
                        $(".kecamatan_op").val(datashow[0].nama_kec_op);
                        $(".desa_op").val(datashow[0].nama_kel_op);

                    },
                    error: function() {
                        // close();
                        $('html, body').css("cursor", "default");
                        $(".alamat_op").val('');
                        $(".rt_op").val('');
                        $(".rw_op").val('');

                        $(".kecamatan_op").val('');
                        $(".desa_op").val('');

                    }
                });
            } else {
                $(".alamat_op").val('');
                $(".rt_op").val('');
                $(".rw_op").val('');

                $(".kecamatan_op").val('');
                $(".desa_op").val('');
            }
        });

        function checkLength(el) {
            if (el.value.length != 16) {
                $("#msg_nik").html("<span style='color:red'>Panjang NIK harus  16 digit.</span>");
            } else {
                $("#msg_nik").html("");
            }
        }

        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }

        function checkLengthnop(el) {
            b = el.value.replace(/[^\d]/g, "");

            if (b.length != 18) {
                // alert("Panjang nik 16 digit.")
                $("#VAL_NOP").html("<span style='color:red'>Panjang NOP harus  18 angka.</span>");
            } else {
                $("#VAL_NOP").html("");
            }
        }

        function formatnop(objek) {
            a = objek.value;
            b = a.replace(/[^\d]/g, "");
            c = "";
            panjang = b.length;

            if (panjang <= 2) {
                // 35 -> 0,2
                c = b;
            } else if (panjang > 2 && panjang <= 4) {
                // 07. -> 2,2
                c = b.substr(0, 2) + '.' + b.substr(2, 2);
            } else if (panjang > 4 && panjang <= 7) {
                // 123 -> 4,3
                c = b.substr(0, 2) + '.' + b.substr(2, 2) + '.' + b.substr(4, 3);
            } else if (panjang > 7 && panjang <= 10) {
                // .123. ->
                c = b.substr(0, 2) + '.' + b.substr(2, 2) + '.' + b.substr(4, 3) + '.' + b.substr(7, 3);
            } else if (panjang > 10 && panjang <= 13) {
                // 123.
                c = b.substr(0, 2) + '.' + b.substr(2, 2) + '.' + b.substr(4, 3) + '.' + b.substr(7, 3) + '.' + b.substr(10, 3);
            } else if (panjang > 13 && panjang <= 17) {
                // 1234
                c = b.substr(0, 2) + '.' + b.substr(2, 2) + '.' + b.substr(4, 3) + '.' + b.substr(7, 3) + '.' + b.substr(10, 3) + '.' + b.substr(13, 4);
            } else {
                // .0
                c = b.substr(0, 2) + '.' + b.substr(2, 2) + '.' + b.substr(4, 3) + '.' + b.substr(7, 3) + '.' + b.substr(10, 3) + '.' + b.substr(13, 4) + '.' + b.substr(17, 1);
                // alert(panjang);
            }
            objek.value = c;
        }
    </script>

</body>

</html>