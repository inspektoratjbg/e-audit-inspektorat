<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddedumRequest;
use App\Pekerjaan;
use App\Rencana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddedumController extends Controller
{

    //
    public function __construct()
    {

        $this->middleware('permission:addedum.create')->only(['create', 'store']);
    }

    public function create($id)
    {
        $pekerjaan = Pekerjaan::findorfail($id);
        $data = [
            'method' => 'post',
            'action' => url('addedum', $id)
        ];
        $title = "Addedum Pekerjaan";

        return view('pekerjaan.addedum', compact('title', 'data', 'pekerjaan'));
    }

    public function store(AddedumRequest $request, $id)
    {
        // 
        // dd($request->all());
        DB::beginTransaction();
        try {

            $pekerjaan = [
                "no_sk_addedum" => $request->no_sk_addedum,
                "tanggal_sk_addedum" => carbon::parse($request->tanggal_sk_addedum)->format('Y-m-d'),
                "nilai_kontrak_addedum" => str_replace(',', '.', $request->nilai_kontrak_addedum),
                "tanggal_mulai_addedum" => carbon::parse($request->tanggal_mulai_addedum)->format('Y-m-d'),
                "tanggal_selesai_addedum" => carbon::parse($request->tanggal_selesai_addedum)->format('Y-m-d'),
                "updated_by" => Auth()->user()->id,
                "updated_at" => Carbon::now()
            ];

            // dd($pekerjaan);
            Pekerjaan::findorfail($id)->update($pekerjaan);

            Rencana::where('pekerjaan_id', $id)->wherenull('deleted_at')->update(['deleted_at' => Carbon::now(), 'deleted_by' => Auth()->user()->id]);

            foreach ($request->minggu_ke as $i => $jd) {
                $rencana = [
                    'pekerjaan_id' => $id,
                    'jenis' => '2',
                    'minggu_ke' => $request->minggu_ke[$i],
                    'tanggal_mulai' => Carbon::parse($request->tanggal_mulai_minggu[$i])->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::parse($request->tanggal_selesai_minggu[$i])->format('Y-m-d'),
                    'target' => str_replace(',', '.', $request->target[$i]),
                    "created_by" => Auth()->user()->id
                ];
                Rencana::create($rencana);
            }

            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $pesan = 'Message: ' . $e->getMessage();
        }

        // dd($pesan);
        return redirect(url('pekerjaan', $id))->with(['status' => $pesan]);
    }
}
