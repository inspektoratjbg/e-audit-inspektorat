<?php

use App\Konsultan;
use App\Ppk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('home');
});


/* Route::get('/dataacak', function () {
    $ppk=Ppk::first();
}); */

Auth::routes();

Route::get('getweeks', function (Request $request) {
    $a = $request->awal;
    $b = $request->selesai;
    $res = rangeMinggu($a, $b);
    return $res;
});


Route::get('itemweek', function (Request $request) {
    return itemRencana($request->id, $request->minggu, $request->ket);
});

Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

Route::middleware(['auth', 'active_user'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    // sistem
    Route::resource('role', 'RoleController');
    Route::get('/role/{role}/hapus', 'RoleController@destroy')->name('role.hapus');

    Route::get('/profil', 'ProfileController@index')->name('profil');

    Route::get('resetpassword/{id}', 'ProfileController@resetPassword');

    Route::post('/passactiondua', 'ProfileController@prosesgantiPasswordDua');
    Route::post('/passaction', 'ProfileController@prosesgantiPassword')->name('change');

    Route::resource('permission', 'PermissionController');
    Route::get('/permission/{role}/hapus', 'PermissionController@destroy')->name('permission.hapus');

    Route::resource('account', 'PenggunaController')->only(['index', 'edit', 'create', 'store', 'update']);

    Route::resource('ppk', 'PpkController')->except(['destroy']);
    Route::get('/ppk/{ppk}/hapus', 'PpkController@destroy')->name('ppk.hapus');

    Route::resource('konsultan', 'KonsultanController')->except(['destroy']);
    Route::get('konsultan/{konsultan}/hapus', 'KonsultanController@destroy')->name('konsultan.hapus');

    Route::resource('sppd', 'SppdController')->except(['destroy']);
    Route::get('sppd/{sppd}/hapus', 'SppdController@destroy')->name('sppd.hapus');

    Route::resource('bast', 'BastController')->except(['destroy']);
    Route::get('bast/{bast}/hapus', 'BastController@destroy')->name('bast.hapus');

    Route::resource('pekerjaan', 'PekerjaanController')->except(['destroy']);
    Route::get('/pekerjaan/{pekerjaan}/hapus', 'PekerjaanController@destroy')->name('pekerjaan.hapus');
    Route::post('pekerjaanFile', 'PekerjaanController@storeFile')->name('pekerjaan.storeFile');
    Route::get('pekerjaanFile/{id}', 'PekerjaanController@getFile')->name('pekerjaan.files');
    Route::get('hapuspekerjaanFile/{id}', 'PekerjaanController@deleteFile')->name('pekerjaan.deleteFile');
    Route::get('selesai/{id}', 'PekerjaanController@PekerjaanSelesai')->name('pekerjaan.selesai');
    Route::get('putuskontrak/{id}', 'PekerjaanController@PekerjaanPutusKontrak')->name('pekerjaan.putus.kontrak');

    // penjadwalan kegiatan
    Route::resource('perencanaan', 'RencanaController')->except(['destroy', 'create', 'edit', 'update']);

    Route::get('addedum/{id}', 'AddedumController@create')->name('addedum.create');
    Route::post('addedum/{id}', 'AddedumController@store')->name('addedum.store');


    Route::get('progres/{id}/{minggu}', 'ProgresController@create')->name('progres.create');
    Route::post('progres/{id}/{minggu}', 'ProgresController@store')->name('progres.store');
    Route::get('hapusprogres/{id}/{minggu}', 'ProgresController@delete')->name('progres.create');

    Route::get('progresfile/{id}', 'ProgresController@getFile')->name('progres.files');

    Route::get('progresverifikasi', 'ProgresController@index')->name('progres.verifikasi');
    Route::get('progresverifikasi/{id}', 'ProgresController@prosesverifikasi');


    Route::resource('pejabat', 'PejabatController')->only(['index', 'edit', 'update']);


    Route::group(['prefix' => 'laporan', 'as' => 'laporan.'], function () {
        Route::get('belum', 'Laporancontroller@belumMethod')->name('belum');
        Route::get('deviasi', 'Laporancontroller@deviasiMethod')->name('deviasi');
        Route::get('hps', 'Laporancontroller@HpsMethod')->name('hps');
    });
});
