<?php

namespace App\Http\Controllers;

use App\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class LaporanController extends Controller
{
    //

    public function belumMethod(Request $request)
    {

        if ($request->ajax()) {
            $tahun = date('Y');
            $data = Pekerjaan::distinct()->wherenull('pekerjaan.deleted_at')->select(DB::raw("pekerjaan.*"))->where('tahun_anggaran', $tahun)->Telat();
            if (!userRole('Administrator')) {
                $data = $data->where('pekerjaan.created_by', Auth()->user()->id);
            }
            $row = DataTables::of($data)
                ->addColumn('nama_unit', function ($data) {
                    return $data->Ppk->nama_unit;
                })
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    $btn .= '<a href="' . route('pekerjaan.show', $role->id) . '" class="badge badge-info"><i class=" fas fa-search"></i> </a>';
                    $btn .= "</div>";
                    return $btn;
                })
				->addColumn('nilai_kon', function ($data) {
                    return number_format($data->nilai_kontrak, 2, ',', '.') . "<br><span class='text-muted'>HPS: " . number_format($data->harga_perkiraan, 2, ',', '.') . "</span>";
                })
                ->rawColumns(['action', 'nama_unit', 'nilai_kon'])
                ->make(true);

            Activity('data')
                ->withProperties($row)
                ->log('Akses data laporan belum update pekerjaan');
            return $row;
        }
        $title = "Pekerjaan yang belum update";
        return view('laporan.belum', compact('title'));
    }

    public function deviasiMethod(Request $request)
    {

        if ($request->ajax()) {
            $tahun = date('Y');
            $data = Pekerjaan::wherenull('pekerjaan.deleted_at')->select(DB::raw("pekerjaan.*,pekerjaan_rencana.minggu_ke,pekerjaan_rencana.tanggal_mulai as tm ,pekerjaan_rencana.tanggal_selesai ts,pekerjaan_peringatan.rencana, pekerjaan_peringatan.realisasi,pekerjaan_peringatan.deviasi,peringatan_nama"))->where('tahun_anggaran', $tahun)->Deviasi();
            if (!userRole('Administrator')) {
                $data = $data->where('pekerjaan.created_by', Auth()->user()->id);
            }
            $row = DataTables::of($data)
                ->make(true);
            Activity('data')
                ->withProperties($row)
                ->log('Akses data laporan deviasi');
            return $row;
        }
        $title = "Deviasi pekerjaan";
        return view('laporan.deviasi', compact('title'));
    }

    public function HpsMethod(Request $request)
    {

        if ($request->ajax()) {
            $tahun = date('Y');
            $data = Pekerjaan::wherenull('pekerjaan.deleted_at')->whereraw("(cast(0.8 AS DECIMAL(18,4)) * harga_perkiraan) > nilai_kontrak");
            if (!userRole('Administrator')) {
                $data = $data->where('pekerjaan.created_by', Auth()->user()->id);
            }
            $row = DataTables::of($data)
                ->addColumn('nama_unit', function ($data) {
                    return $data->Ppk->nama_unit;
                })
                ->addColumn('persen', function ($data) {
                    return  number_format(($data->nilai_kontrak / $data->harga_perkiraan *100),2,',','.')." %";
                })
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    $btn .= '<a href="' . route('pekerjaan.show', $role->id) . '" class="badge badge-info"><i class=" fas fa-search"></i> </a>';
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action', 'nama_unit','persen'])
                ->make(true);
            return $row;
        }
        $title = "Nilai kontrak di bawah 80% HPS";
        Activity('data')->log('Akses' . $title);

        return view('laporan.hps', compact('title'));
    }
}
