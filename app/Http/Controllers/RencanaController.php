<?php

namespace App\Http\Controllers;

use App\Pekerjaan;
use App\Rencana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RencanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:rencana.list')->only('index');
        $this->middleware('permission:rencana.create')->only(['show', 'store']);
        // $this->middleware('permission:pekerjaan.edit')->only(['edit', 'update']);
        /* $this->middleware('permission:pekerjaan.delete')->only(['destroy']);
        $this->path = 'app/public/pekerjaan'; */
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pekerjaan::wherenull('deleted_at')->where('status', 1);
            if (!userRole('Administrator')) {
                if (userRole('Konsultan')) {
                    $data = $data->where('konsultan_id', Auth()->user()->konsultan_id);
                } else {
                    $data = $data->where('created_by', Auth()->user()->id);
                }
            }

            $row = DataTables::of($data)
                ->addColumn('nama_unit', function ($data) {
                    return $data->Ppk->nama_unit;
                })
                ->addColumn('nilai_kon', function ($data) {
                    return number_format($data->nilai_kontrak, 2, ',', '.') . "<br><span class='text-muted'>HPS: " . number_format($data->harga_perkiraan, 2, ',', '.') . "</span>";
                })
                ->addColumn('status_name', function ($data) {
                    switch ($data->status) {
                        case 2:
                            $status = "Pekerjaan berjalan";
                            break;
                        case 3:
                            $status = "Pekerjaan selesai";
                            break;
                        case 4:
                            $status = "Pekerjaan putus kontrak";
                            break;
                        default:
                            $status = "Rencana Realisasi belum di input";
                            break;
                    }
                    return $status;
                })
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    $btn .= '<a href="' . route('perencanaan.show', $role->id) . '" class="badge badge-info"><i class=" fas fa-calendar"></i> </a>';
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action', 'nama_unit', 'nilai_kon', 'status_name'])
                ->make(true);


            return $row;
        }
        $title = "Perencaan progres pekerjaan";
        Activity('table')
            ->log($title);
        return view('rencana.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            foreach ($request->minggu_ke as $i => $jd) {
                $rencana = [
                    'pekerjaan_id' => $request->pekerjaan_id,
                    'jenis' => 1,
                    'minggu_ke' => $request->minggu_ke[$i],
                    'tanggal_mulai' => Carbon::parse($request->tanggal_mulai_minggu[$i])->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::parse($request->tanggal_selesai_minggu[$i])->format('Y-m-d'),
                    'target' => str_replace(',', '.', $request->target[$i]),
                    "created_by" => Auth()->user()->id
                ];
                Rencana::create($rencana);
            }

            Pekerjaan::find($request->pekerjaan_id)->update(['status'=>'2']);

            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }

        return redirect(url('pekerjaan',$request->pekerjaan_id))->with(['status' => $pesan]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $pekerjaan = Pekerjaan::findorfail($id);
        $title = 'Input perencanaan pekerrjaaan';
        $data = [
            'action' => route('perencanaan.store'),
            'method' => 'post'
        ];
        Activity('view')
            ->withProperties($pekerjaan)
            ->log('Form perencaan pekerjaan ' . $pekerjaan->nama_kegiatan);
        return view('rencana/detail', compact('pekerjaan', 'title', 'data'));
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
    }
}
