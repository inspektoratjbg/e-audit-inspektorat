<?php

namespace App\Http\Controllers;

use App\Pekerjaan;
use App\Progres;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Contracts\Activity;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //jumlah pekerjaan
        $tahun = date('Y');
        /* 
        $jp = Pekerjaan::wherenull('pekerjaan.deleted_at')->where('tahun_anggaran', $tahun);
        if (!userRole('Administrator')) {
            $jp = $jp->where('pekerjaan.created_by', Auth()->user()->id);
        }


        $telat = Pekerjaan::select(DB::raw("distinct pekerjaan.*"))->where('tahun_anggaran', $tahun)->Telat();
        if (!userRole('Administrator')) {
            $telat = $telat->where('pekerjaan.created_by', Auth()->user()->id);
        } */
        // $telat = $telat->telat()->get()->count();

        /* $telat = $telat->leftjoin('pekerjaan_rencana', 'pekerjaan_rencana.pekerjaan_id', '=', 'pekerjaan.id')->leftjoin('pekerjaan_progres', function ($sql) {
            $sql->on('pekerjaan_progres.pekerjaan_id', '=', 'pekerjaan_rencana.id')
                ->on('pekerjaan_progres.minggu_ke', '=', 'pekerjaan_rencana.minggu_ke');
        })->whereraw("pekerjaan_rencana.deleted_at IS NULL  AND pekerjaan_progres.deleted_at IS NULL
        AND pekerjaan_rencana.tanggal_selesai <DATE(NOW())
        AND pekerjaan_progres.id IS  NULL
        AND pekerjaan.deleted_at IS NULL"); */

        // $verifikasi = "";
        /* if (userRole('PPK')) {
            $ppk_id = Auth()->user()->ppk_id;
            $verifikasi = Progres::select(Db::raw("pekerjaan_progres.*,nama_kegiatan,no_sk,tahun_anggaran,konsultan_nama"))->join('pekerjaan', 'pekerjaan.id', '=', 'pekerjaan_progres.pekerjaan_id')
                ->whereraw("pekerjaan_progres.deleted_at is null and ppk_id='" . $ppk_id . "' and verifikasi_at is null")->get()->count();
        }
 */
        $ppk_id = Auth()->user()->ppk_id;
        
        // $ppk_id=60;
        $verifikasi = DB::select("SELECT nama_pekerjaan,ppk_id, konsultan_nama nama_konsultan,nama_penyedia,realisasi,minggu_ke,pekerjaan_progres.created_at
        FROM PEKERJAAN_PROGRES
        JOIN PEKERJAAN ON PEKERJAAN.ID=PEKERJAAN_PROGRES.PEKERJAAN_ID
        WHERE PEKERJAAN_PROGRES.DELETED_AT IS NULL 
        AND PEKERJAAN_PROGRES.VERIFIKASI_AT IS NULL
        AND PEKERJAAN.DELETED_AT IS NULL
        AND PPK_ID='$ppk_id'
        ORDER BY PEKERJAAN_PROGRES.CREATED_BY ASC");


        /* $pekerjaan = $jp->count();
        $telat = $telat->get()->count(); */
        /* Activity('view')
            ->withProperties(['pekerjaan' => $pekerjaan, 'telat_progres' => $telat])
            ->log('membuka halaman dashboard'); */

        // $deviasi=
        $pekerjaan = 0;
        $telat = 0;
        $tgl = date('Y-m-d');
        $deviasi = DB::select("SELECT nama_pekerjaan,nama_penyedia,pekerjaan_rencana.pekerjaan_id,pekerjaan_rencana.minggu_ke,pekerjaan_rencana.target,realisasi, realisasi-pekerjaan_rencana.target  deviasi
        FROM pekerjaan_rencana
        JOIN pekerjaan ON pekerjaan.id=pekerjaan_rencana.pekerjaan_id
        JOIN ( SELECT pekerjaan_id,minggu_ke -1  minggu
        FROM pekerjaan_rencana
        JOIN pekerjaan ON pekerjaan.id=pekerjaan_rencana.pekerjaan_id
        WHERE pekerjaan_rencana.tanggal_mulai <='$tgl' 
        AND pekerjaan_rencana.tanggal_selesai>='$tgl'
        AND pekerjaan_rencana.deleted_at IS NULL
        AND pekerjaan.deleted_at is null
        AND (minggu_ke -1)>=1) c ON c.pekerjaan_id=pekerjaan_rencana.pekerjaan_id AND c.minggu=pekerjaan_rencana.minggu_ke
        JOIN (SELECT pekerjaan_id,MAX(realisasi) realisasi
        FROM pekerjaan_progres
        WHERE deleted_at IS NULL AND verifikasi_at IS NOT null
        GROUP BY pekerjaan_id) d ON d.pekerjaan_id=pekerjaan_rencana.pekerjaan_id
        AND pekerjaan_rencana.deleted_at IS NULL
        AND pekerjaan.deleted_at is NULL
        AND (realisasi-pekerjaan_rencana.target) < 0
        ORDER BY deviasi asc");

    // $time=Carbon::parse('202105251120')->format('h:i:s');
    // dd($time);

        // dd($deviasi);
        return view('home', compact('verifikasi', 'deviasi'));
        // return 'asdasf';
    }
}
