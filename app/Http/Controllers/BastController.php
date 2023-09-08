<?php

namespace App\Http\Controllers;

use App\Bast;
use App\Http\Requests\BastRequest;
use App\Pekerjaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class BastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bast::with(['pekerjaan'])->wherenull('pekerjaan_bast.deleted_at');
            $ppk_id = Auth()->user()->ppk_id;
            if ($ppk_id <> '') {
                $data = $data->whereraw(" pekerjaan_id in ( select id from pekerjaan where ppk_id='" . $ppk_id . "' and deleted_at is null ) ");
            }
            $row = DataTables::of($data)
                ->addcolumn('nama_pekerjaan', function ($data) {
                    return optional($data->pekerjaan)->nama_pekerjaan;
                })
                ->addcolumn('nama_unit', function ($data) {
                    return optional(optional($data->pekerjaan)->ppk)->nama_unit;
                })
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    if (userCan('bast.edit')) {
                        $btn .= '<a href="' . route('bast.edit', $role->id) . '" class="badge badge-success"><i class=" fas fa-pencil-alt"></i> </a>';
                    }
                    if (userCan('bast.delete')) {
                        $btn .= '<a href="#"   data-url="' . route('bast.hapus', $role->id) . '" class="hapus badge badge-danger"><i class="fas fa-trash-alt"></i> </a>';
                    }
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action', 'nama_unit', 'nama_pekerjaan'])
                ->make(true);
            return $row;
        }
        $title = "Daftar BAST";
        Activity('table')
            ->log('membuka halaman BAST');
        return view('bast.index', compact('title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'action' => route('bast.store'),
            'method' => 'POST'
        ];
        $pekerjaan = Pekerjaan::wherenull('deleted_at')->where('status',3);
        $ppk_id = Auth()->user()->ppk_id;
        if ($ppk_id <> '') {
            $pekerjaan = $pekerjaan->whereraw("ppk_id='" . $ppk_id . "' and deleted_at is null");
        }
        $pekerjaan = $pekerjaan->get();
        $title = "Tambah BAST";
        Activity('table')
            ->log('membuka halaman ' . $title);
        return view('bast.form', compact('title', 'data', 'pekerjaan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BastRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                "Pekerjaan_id" => $request->pekerjaan_id,
                "keterangan" => $request->keterangan,
                "no_bast" => $request->no_bast,
                "tgl_bast" => Carbon::parse($request->tgl_bast)->format('Y-m-d'),
                "created_by" => Auth()->user()->id,
                "created_at" => Carbon::now(),
            ];
            Bast::create($data);
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }

        return redirect(url('bast'))->with(['status' => $pesan]);
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
        $data = [
            'action' => route('bast.update',$id),
            'method' => 'PATCH'
        ];
        // $pekerjaan = Pekerjaan::wherenull('deleted_at')->get();
        $pekerjaan = Pekerjaan::wherenull('deleted_at')->where('status',3);
        $ppk_id = Auth()->user()->ppk_id;
        if ($ppk_id <> '') {
            $pekerjaan = $pekerjaan->whereraw("ppk_id='" . $ppk_id . "' and deleted_at is null");
        }
        $pekerjaan = $pekerjaan->get();
        $title = "Edit BAST";
        $bast=Bast::findorfail($id);
        Activity('table')
            ->log('membuka halaman ' . $title);
        return view('bast.form', compact('title', 'data', 'pekerjaan','bast'));
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
        DB::beginTransaction();
        try {
            $data = [
                "Pekerjaan_id" => $request->pekerjaan_id,
                "keterangan" => $request->keterangan,
                "no_bast" => $request->no_bast,
                "tgl_bast" => Carbon::parse($request->tgl_bast)->format('Y-m-d'),
                "updated_by" => Auth()->user()->id,
                "updated_at" => Carbon::now(),
            ];
            Bast::findorfail($id)->update($data);
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }

        return redirect(url('bast'))->with(['status' => $pesan]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = [
                "deleted_by" => Auth()->user()->id,
                "deleted_at" => Carbon::now(),
            ];
            Bast::findorfail($id)->update($data);
            DB::commit();
            $pesan = "berhasil di hapus";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }

        return redirect(url('bast'))->with(['status' => $pesan]);
    }
}
