<?php

namespace App\Http\Controllers;

use App\Http\Requests\SppdRequest;
use App\Pekerjaan;
use App\Sppd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

class SppdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Sppd::with(['pekerjaan'])->wherenull('pekerjaan_sp2d.deleted_at');
            $ppk_id = Auth()->user()->ppk_id;
            if ($ppk_id <> '') {
                $data = $data->whereraw(" pekerjaan_id in ( select id from pekerjaan where ppk_id='" . $ppk_id . "' and deleted_at is null ) ");
            }

            $row = DataTables::of($data)
                ->addcolumn('nama_pekerjaan', function ($data) {
                    return optional($data->pekerjaan)->nama_pekerjaan;
                })
                ->addcolumn('nilai_', function ($data) {
                    return number_format($data->nilai,2,',','.');
                })
                ->addcolumn('nama_unit', function ($data) {
                    return optional(optional($data->pekerjaan)->ppk)->nama_unit;
                })
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    if (userCan('sppd.edit')) {
                        $btn .= '<a href="' . route('sppd.edit', $role->id) . '" class="badge badge-success"><i class=" fas fa-pencil-alt"></i> </a>';
                    }
                    if (userCan('sppd.delete')) {
                        $btn .= '<a href="#"   data-url="' . route('sppd.hapus', $role->id) . '" class="hapus badge badge-danger"><i class="fas fa-trash-alt"></i> </a>';
                    }
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action', 'nama_unit', 'nama_pekerjaan'])
                ->make(true);

            return $row;
        }
        $title = "Daftar SP2D";
        Activity('table')
            ->log('membuka halaman sp2d');
        return view('sppd.index', compact('title'));
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
            'action' => route('sppd.store'),
            'method' => 'POST'
        ];
        $pekerjaan = Pekerjaan::wherenull('deleted_at');
        $ppk_id = Auth()->user()->ppk_id;
        if ($ppk_id <> '') {
            $pekerjaan = $pekerjaan->whereraw("ppk_id='" . $ppk_id . "' and deleted_at is null");
        }
        $pekerjaan = $pekerjaan->get();
        $title = "Tambah SP2D";
        Activity('table')
            ->log('membuka halaman ' . $title);
        return view('sppd.form', compact('title', 'data', 'pekerjaan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SppdRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = [
                "Pekerjaan_id" => $request->pekerjaan_id,
                "keterangan" => $request->keterangan,
                "no_sp2d" => $request->no_sp2d,
                "tgl_sp2d" => Carbon::parse($request->tgl_sp2d)->format('Y-m-d'),
                "nilai" => str_replace(',', '.', $request->nilai),
                "created_by" => Auth()->user()->id,
                "created_at" => carbon::now(),
            ];
            Sppd::create($data);
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }

        return redirect(url('sppd'))->with(['status' => $pesan]);
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
            'action' => route('sppd.update', $id),
            'method' => 'PATCH'
        ];
        // $pekerjaan = Pekerjaan::wherenull('deleted_at')->get();
        $pekerjaan = Pekerjaan::wherenull('deleted_at');
        $ppk_id = Auth()->user()->ppk_id;
        if ($ppk_id <> '') {
            $pekerjaan = $pekerjaan->whereraw("ppk_id='" . $ppk_id . "' and deleted_at is null");
        }
        $pekerjaan = $pekerjaan->get();
        $title = "Tambah SP2D";
        $sppd = Sppd::findorfail($id);
        Activity('table')
            ->log('membuka halaman ' . $title);
        return view('sppd.form', compact('title', 'data', 'pekerjaan', 'sppd'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SppdRequest $request, $id)
    {
        //
        DB::beginTransaction();
        try {
            $data = [
                "Pekerjaan_id" => $request->pekerjaan_id,
                "keterangan" => $request->keterangan,
                "no_sp2d" => $request->no_sp2d,
                "tgl_sp2d" => Carbon::parse($request->tgl_sp2d)->format('Y-m-d'),
                "nilai" => str_replace(',', '.', $request->nilai),
                "updated_by" => Auth()->user()->id,
                "updated_at" => carbon::now(),
            ];
            Sppd::findorfail($id)->update($data);
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }

        return redirect(url('sppd'))->with(['status' => $pesan]);
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
                "deleted_at" => carbon::now(),
            ];
            Sppd::findorfail($id)->update($data);
            DB::commit();
            $pesan = "berhasil di hapus";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }

        return redirect(url('sppd'))->with(['status' => $pesan]);
    }
}
