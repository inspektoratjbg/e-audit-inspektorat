<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pegawai;
use App\User;
use App\Http\Requests\GantiPassRequest;
use Validator;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $role = $user->roles()->pluck('name')->toArray();
        // $pegawai = Pegawai::find($user->pegawai_id);

        return view('profil', compact('user', 'pegawai', 'role'));
    }

    public function resetPassword($id)
    {
        $user = User::findorfail($id);
        $role = $user->roles()->pluck('name')->toArray();
        return view('profildua', compact('user', 'role'));
    }

    public function prosesgantiPassword(GantiPassRequest $request)
    {

        $user = User::find(Auth::user()->id); //->where('password', bcrypt($request->password_lama))->first();
        if ($user != null) {
            $user->update(['password' => bcrypt($request->password_baru)]);
            $pesan = "Password berhasil di ganti";
        } else {
            // dd('');
            $pesan = "Password lama tidak sesuai";
        }

        return redirect('profil')->with(['status' => $pesan]);
    }

    public function prosesgantiPasswordDua(GantiPassRequest $request)
    {
        $user = User::find($request->id);
        if ($user != null) {
            $user->update(['password' => bcrypt($request->password_baru)]);
            $pesan = "Password berhasil di ganti";
        } else {
            // dd('');
            $pesan = "Password lama tidak sesuai";
        }

        return redirect('account')->with(['status' => $pesan]);
    }
}
