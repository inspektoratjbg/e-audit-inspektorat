<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgresRequest;
use App\Jobs\SendEmailJob;
use App\KirimEmail;
use App\Mail\SendEmailTest;
use App\Pejabat;
use App\Pekerjaan;
use App\PeringatanPekerjaan;
use App\Progres;
use App\ProgresFile;
use App\Rencana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Yajra\DataTables\DataTables;

class ProgresController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:progres.create')->only(['create', 'store', 'delete']);
        $this->middleware('permission:progres.verifikasi')->only(['index']);
        $this->path = 'app/public/progres';
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ppk_id = Auth()->user()->ppk_id;

            $data = Progres::select(Db::raw("target, target-realisasi deviasi,pekerjaan_progres.*,nama_kegiatan,no_sk,tahun_anggaran,konsultan_nama,nama_penyedia"))
                ->join('pekerjaan', 'pekerjaan.id', '=', 'pekerjaan_progres.pekerjaan_id')
                ->join('pekerjaan_rencana',function($join){
                    $join->on('pekerjaan_rencana.pekerjaan_id', '=', 'pekerjaan_progres.pekerjaan_id')  
                    ->on('pekerjaan_rencana.minggu_ke', '=', 'pekerjaan_progres.minggu_ke');
                })
                ->whereraw(" pekerjaan_rencana.deleted_at is null and pekerjaan_progres.deleted_at is null and ppk_id='" . $ppk_id . "' and pekerjaan_progres.verifikasi_at is null");
            return DataTables::of($data)

                ->filterColumn('nama_kegiatan', function ($query, $keyword) {
                    $sql = "pekerjaan.nama_kegiatan  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('no_sk', function ($query, $keyword) {
                    $sql = "pekerjaan.no_sk  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('konsultan_nama', function ($query, $keyword) {
                    $sql = "pekerjaan.konsultan_nama  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('no_sk', function ($query, $keyword) {
                    $sql = "pekerjaan.no_sk  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    $btn .= "<a class='btn text-white btn-sm btn-info' onclick='return confirm(\"Apakah anda yakin ?\")' href='" . url('progresverifikasi', $role->id) . "'><i class='fas fa-check'></i> Verifikasi</a>";
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = "Verifikasi progres pekerjaan";
        return view('pekerjaan.verifikasi', compact('title'));
    }

    public function prosesverifikasi($id)
    {

        if (!userCan('progres.verifikasi')) {
            abort(403);
        }
        DB::beginTransaction();
        try {
            $progres = Progres::find($id);
            $rencana = Rencana::wherenull('deleted_at')->where('pekerjaan_id', $progres->pekerjaan_id)->where('minggu_ke', $progres->minggu_ke)->first();
            $deviasi = $rencana->target - $progres->realisasi;
            $pekerjaan = Pekerjaan::find($progres->pekerjaan_id);

            $pejabat = Pejabat::where('jabatan', 'IRBAN PEMBANGUNAN')->first();
            $email_to = [];
            $email_to[] = [
                'jabatan' => $pejabat->jabatan,
                'email' => $pejabat->email,
                'nama' => $pejabat->nama_pejabat
            ];

            $email_to[] = [
                'jabatan' => 'PPK',
                'email' => $pekerjaan->ppk->email,
                'nama' => $pekerjaan->ppk_nama
            ];

            $notif = "";
            if ($rencana->taget <= 70) {
                // tahap 1
                if ($deviasi > 5 && $deviasi <= 10) {
                    // pra kritis
                    $notif = 1;
                    $notif_nama = 'Pekerjaan Pra Kritis';
                    $boleh = 5;
                }

                if ($deviasi > 10) {
                    // kritis
                    $notif = 2;
                    $notif_nama = 'Pekerjaan Kritis';
                    $boleh = 10;
                }
            } else {
                // tahap 2
                if ($deviasi > 3 && $deviasi <= 5) {
                    // pra kritis
                    $notif = 3;
                    $notif_nama = 'Pekerjaan Pra Kritis';
                    $boleh = 3;
                }

                if ($deviasi > 5) {
                    // pra kritis
                    $notif = 4;
                    $notif_nama = 'Pekerjaan Kritis';
                    $boleh = 5;
                }
            }

            if ($notif != '') {
                // cek sebelumnya
                $cp = PeringatanPekerjaan::where('pekerjaan_id', $progres->pekerjaan_id)->orderby('id', 'desc')->first();
                if ($cp != null) {
                    if ($cp->peringatan_id == $notif && $cp->minggu_ke == ($progres->minggu_ke - 1)) {
                        $pe = Pejabat::where('jabatan', 'PA')->orWhere('jabatan', 'SEKDA')->get();
                        foreach ($pe as $rpe) {
                            $email_to[] = [
                                'jabatan' => $rpe->jabatan,
                                'email' => $rpe->email,
                                'nama' => $rpe->nama_pejabat
                            ];
                        }
                    }
                }

                $peringatan = [
                    'pekerjaan_id' => $progres->pekerjaan_id,
                    'minggu_ke'  => $progres->minggu_ke,
                    'rencana' => $rencana->target,
                    'realisasi' => $progres->realisasi,
                    'deviasi' => $deviasi,
                    'peringatan_id' => $notif,
                    'peringatan_nama' => $notif_nama,
                ];


                PeringatanPekerjaan::create($peringatan);

                foreach ($email_to as $to) {
                    $email = [
                        'email_to' => $to['email'],
                        'subject' => $notif_nama,
                        'body' => "<p>Kepada Yth Bpk/Ibu " . $to['nama'] . " selaku " .  $to['jabatan'] . " </p><p>Berdasarkan hasil laporan di sistem E-Audit ada keterlambatan pekerjaan " . $pekerjaan->nama_kegiatan . " oleh konsultan " . $pekerjaan->konsultan_nama . " ( SK : " . $pekerjaan->no_sk . ") dengan prestasi " . number_format($progres->realisasi, 2, ',', '.') . " % yang seharusnya sesuai rencana adalah " . number_format($rencana->target, 2, ',', '.') . " % dengan keterlambatan sebesar " . number_format($deviasi, 2, ',', '.') . "% , dengan keterlambatan melebihi ambang yang diperbolehkan dari prestasi yang direncanakan yang harus dicapai " . number_format($boleh, 2, ',', '.') . "% .</p>"
                    ];
                    KirimEmail::create($email);

                    /* $body_email = [
                        'rencana' => $rencana->target,
                        'realisasi' => $progres->realisasi,
                        'pekerjaan' => $pekerjaan->nama_kegiatan,
                        'deviasi' => $deviasi,
                        'konsultan' => $pekerjaan->konsultan_nama,
                        'no_sk' => $pekerjaan->no_sk,
                        'peringatan_nama' => $notif_nama,
                        'boleh' => $boleh,
                        'jabatan' => $to['jabatan'],
                        'kepada' => $to['nama']
                    ]; */
                    // Mail::to($to['email'])->send(new SendEmailTest($body_email));

                }
            }

            $progres->update([
                'verifikasi_at' => Carbon::now(),
                'verifikasi_by' => Auth()->user()->id
            ]);

            DB::commit();
            $pesan = "berhasil di verifikasi";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }
        return redirect(url('progresverifikasi'))->with(['status' => $pesan]);
    }

    public function create($id, $minggu)
    {
        $progres = Progres::wherenull('deleted_at')->where('pekerjaan_id', $id)->where('minggu_ke', $minggu)->first();
        if ($progres == null) {
            $pekerjaan = Pekerjaan::findorfail($id);
            $rencana = Rencana::wherenull('deleted_at')->where('pekerjaan_id', $id)->where('minggu_ke', $minggu)->first();
            $title = "Update progres kegiatan pada minggu ke " . $minggu;
            $data = [
                'action' => url('progres', [$id, $minggu]),
                'method' => 'post'
            ];
            return view('pekerjaan.progres', compact('title', 'rencana', 'pekerjaan', 'data'));
        } else {
            abort(404);
        }
    }

    public function delete($id, $minggu)
    {
        DB::beginTransaction();
        try {

            $progres = Progres::wherenull('deleted_at')->where('pekerjaan_id', $id)->where('minggu_ke', $minggu)->first();
            $progres->update([
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth()->user()->id
            ]);

            DB::commit();
            $pesan = "berhasil di hapus";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }
        return redirect(url('pekerjaan', $id))->with(['status' => $pesan]);
    }

    public function store(ProgresRequest $request, $id, $minggu)
    {
        $progres = Progres::wherenull('deleted_at')->where('pekerjaan_id', $id)->where('minggu_ke', $minggu)->first();
        if ($progres == null) {
            // dd($request->all());
            DB::beginTransaction();
            try {
                $prog = [
                    'pekerjaan_id' => $id,
                    'minggu_ke' => $minggu,
                    'tanggal_mulai' => Carbon::parse($request->tanggal_mulai)->format('Y-m-d'),
                    'tanggal_selesai' => Carbon::parse($request->tanggal_selesai)->format('Y-m-d'),
                    'realisasi' => str_replace(',', '.', $request->realisasi),
                    'created_by' => Auth()->user()->id,
                ];
                $progres = Progres::create($prog);

                if (!File::isDirectory(storage_path($this->path))) {
                    File::makeDirectory(storage_path($this->path));
                }


                if ($request->hasFile('file_lampiran')) {
                    foreach ($request->file_lampiran as $kf => $rf) {

                        $file = $request->file('file_lampiran')[$kf];
                        $file_name = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                        $fullpath = 'progres/' . $file_name;
                        $file->move(storage_path($this->path), $file_name);

                        $dokumen['pekerjaan_progres_id'] = $progres->id;
                        $dokumen['path_file'] = $fullpath;
                        $dokumen['nama_file'] = $file_name;
                        $dokumen['ext_file'] = $file->getClientOriginalExtension();
                        $dokumen['created_by'] = Auth()->user()->id;
                        ProgresFile::create($dokumen);
                    }
                }

                DB::commit();
                $pesan = "berhasil di proses";
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                $pesan = 'Message: ' . $e->getMessage();
            }
            return redirect(url('pekerjaan', $id))->with(['status' => $pesan]);
        } else {
            abort(404);
        }
    }

    public function getFile($files)
    {
        // return $files;
        $path = storage_path('app/public/progres/') . $files;
        // return $path;
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = FacadesResponse::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
