<?php

namespace App\Http\Controllers;

use App\Http\Requests\Ppkrequest;
use App\Ppk;
use App\Unit;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PpkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:ppk.list')->only('index');
        $this->middleware('permission:ppk.create')->only(['create', 'store']);
        $this->middleware('permission:ppk.edit')->only(['edit', 'update']);
        $this->middleware('permission:ppk.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Ppk::whereNull('deleted_at');
            return DataTables::of($data)
                ->order(function ($query) {
                    $query->orderBy('nama_unit', 'asc');
                })
                ->addColumn('tgl_sk',function($data){
                    return tgl_indo($data->tanggal_sk);
                })
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    $btn = '<a href="' . route('ppk.edit', $role->id) . '" class="badge badge-primary"><i class=" fas fa-pencil-alt"></i> </a>';
                    $btn .= '<a href="#"   data-url="' . route('ppk.hapus', $role->id) . '" class="hapus badge badge-danger"><i class="fas fa-trash-alt"></i> </a>';
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action','tgl_sk'])
                ->make(true);
        }
        $title = "Daftar pegawai PPK";
        return view('ppk/index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [
            'action' => route('ppk.store'),
            'method' => 'POST'
        ];
        $title = "Tambah Pegawai PPK";
        $unit = Unit::get();
        // dd($unit);
        return view('ppk.form', \compact('data', 'title', 'unit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Ppkrequest $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->except(['_token', '_method', 'password', 'password_konfirmasi', 'tanggal_sk']);
            $unit = Unit::find($request->kode_unit);

            $data['nama_unit'] = $unit->nama_unit;
            $data['created_by'] = Auth()->user()->id;
            $data['tanggal_sk'] = Carbon::parse($request->tanggal_sk)->format('Y-m-d');
            $ppk = Ppk::create($data);

            User::create(
                [
                    'ppk_id' => $ppk->id,
                    'email' => $ppk->email,
                    'name' => $ppk->nama,
                    'password' => \bcrypt($request->password)
                ]
            )->assignRole('PPK');

            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $pesan = 'Message: ' . $e->getMessage();
        }
        // dd($pesan);
        return redirect(url('ppk'))->with(['status' => $pesan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $ppk = Ppk::findorfail($id);
        $data = [
            'action' => route('ppk.update', $id),
            'method' => 'PATCH'
        ];
        $title = "Edit pegawai PPK";
        $unit = Unit::get();

        return view('ppk.form', \compact('data', 'ppk', 'title', 'unit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        DB::beginTransaction();
        try {


            // $data = $request->except(['_token', '_method']);
            $data = $request->except(['_token', '_method', 'password', 'password_konfirmasi', 'tanggal_sk']);
            $data['updated_by'] = Auth()->user()->id;
            $unit = Unit::find($request->kode_unit);
            $data['nama_unit'] = $unit->nama_unit;
            $ppk = Ppk::findorfail($id);
            $ppk->update($data);


            User::where('ppk_id', $ppk->id)->update(
                [
                    'email' => $ppk->email,
                    'name' => $ppk->nama
                ]
            );
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $pesan = 'Message: ' . $e->getMessage();
        }
        // dd($pesan);
        return redirect(url('ppk'))->with(['status' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::beginTransaction();
        try {

            Ppk::find($id)->update(
                [
                    'deleted_by' => Auth()->user()->id,
                    'deleted_at' => Carbon::now()
                ]
            );


            User::where('ppk_id', $id)->update([
                'disabled_by' => Auth()->user()->id,
                'disabled_at' => Carbon::now()
            ]);

            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $pesan = 'Message: ' . $e->getMessage();
        }
        // dd($pesan);
        return redirect(url('ppk'))->with(['status' => $pesan]);
    }
}
