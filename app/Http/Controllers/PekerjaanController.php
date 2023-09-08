<?php

namespace App\Http\Controllers;

use App\Http\Requests\PekerjaanRequest;
use App\Konsultan;
use App\Pekerjaan;
use App\PekerjaanFile;
use App\Ppk;
use App\Rencana;
use Carbon\Carbon;
use Illuminate\Http\Request;
// use DataTables;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use File;
use Response;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:pekerjaan.list')->only('index');
        $this->middleware('permission:pekerjaan.create')->only(['create', 'store']);
        $this->middleware('permission:pekerjaan.edit')->only(['edit', 'update']);
        $this->middleware('permission:pekerjaan.delete')->only(['destroy']);
        $this->path = 'app/public/pekerjaan';
    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Pekerjaan::wherenull('deleted_at');
            if (!userRole('Administrator')) {
                if (userRole('Konsultan')) {
                    $data = $data->where('konsultan_id', Auth()->user()->konsultan_id);
                } else {
                    $data = $data->where('created_by', Auth()->user()->id);
                }
            }

            $row = DataTables::of($data)
                ->addColumn('terkini', function ($data) {
                    return number_format(terkini($data->id)->hasil,2,',','.').' %' ;
                })
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
                    $btn .= '<a href="' . route('pekerjaan.show', $role->id) . '" class="badge badge-info"><i class=" fas fa-search"></i> </a>';
                    if (userCan('pekerjaan.edit')) {
                        $btn .= '<a href="' . route('pekerjaan.edit', $role->id) . '" class="badge badge-success"><i class=" fas fa-pencil-alt"></i> </a>';
                    }
                    if (userCan('pekerjaan.delete') && $role->status == 1) {
                        $btn .= '<a href="#"   data-url="' . route('pekerjaan.hapus', $role->id) . '" class="hapus badge badge-danger"><i class="fas fa-trash-alt"></i> </a>';
                    }
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action', 'nama_unit', 'nilai_kon', 'status_name','terkini'])
                ->make(true);

            Activity('data')
                ->withProperties($row)
                ->log('akses list data pekerjaan');
            return $row;
        }
        $title = "Daftar Pekerjaan";
        Activity('table')
            ->log('membuka halaman pekerjaan');
        return view('pekerjaan.index', compact('title'));
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
            'method' => 'post',
            'action' => url('pekerjaan')
        ];
        $title = "Tambah Pekerjaan";
        #$konsultan = Konsultan::wherenull('deleted_at')->where('created_by', Auth()->user()->id)->get();
		$konsultan = Konsultan::wherenull('deleted_at')->get();
		

        $ppk = Ppk::wherenull('deleted_at');
        if (!userRole('Administrator')) {
            $ppk = $ppk->where('id', Auth()->user()->ppk_id)->first();
        } else {
            $ppk = $ppk->get();
        }
        return view('pekerjaan.form', compact('title', 'data', 'konsultan', 'ppk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PekerjaanRequest $request)
    {

        DB::beginTransaction();
        try {
            $ppk_nama = "";
            if (!empty($request->ppk_nama)) {
                $ppk_nama = $request->ppk_nama;
            } else {
                $ppk = Ppk::find($request->ppk_id);
                $ppk_nama = $ppk->nama;
            }

            $kons = Konsultan::find($request->konsultan_id);
            $kn = $kons->nama_konsultan;

            $pekerjaan = [
                "ppk_id" => $request->ppk_id,
                "ppk_nama" => $ppk_nama,
                "tahun_anggaran" => $request->tahun_anggaran,
                "nama_kegiatan" => $request->nama_kegiatan,
                "nama_pekerjaan" => $request->nama_pekerjaan,
                "nama_penyedia" => $request->nama_penyedia,
                "pagu_anggaran" => str_replace(',', '.', $request->pagu_anggaran),
                "harga_perkiraan" => str_replace(',', '.', $request->harga_perkiraan),
                "konsultan_id" => $request->konsultan_id,
                "konsultan_nama" => $kn,
                "no_sk" => $request->no_sk,
                "status" => 1,
                "tanggal_sk" => carbon::parse($request->tanggal_sk)->format('Y-m-d'),
                "nilai_kontrak" => str_replace(',', '.', $request->nilai_kontrak),
                "tanggal_mulai" => carbon::parse($request->tanggal_mulai)->format('Y-m-d'),
                "tanggal_selesai" => carbon::parse($request->tanggal_selesai)->format('Y-m-d'),
                "created_by" => Auth()->user()->id
            ];
            $pk = Pekerjaan::create($pekerjaan);
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }

        return redirect(url('pekerjaan'))->with(['status' => $pesan]);
    }

    /* Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pekerjaan = Pekerjaan::findorfail($id);
        $title = 'Detail Pekerjaan';
        $data = [
            'action' => url('pekerjaanFile'),
            'method' => 'POST'
        ];
        Activity('view')
            ->withProperties($pekerjaan)
            ->log('Membuka detail pekerjaan ' . $pekerjaan->nama_kegiatan);
        return view('pekerjaan/detail', compact('pekerjaan', 'title', 'data'));
        // dd($pekerjaan);
    }
    public function getFile($files)
    {
        // return $files;
        $path = storage_path('app/public/pekerjaan/') . $files;
        // return $path;
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
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
            'method' => 'patch',
            'action' => route('pekerjaan.update', $id)
        ];
        $title = "Edit Pekerjaan";
        $konsultan = Konsultan::wherenull('deleted_at');
        $konsultan = $konsultan->get();
        $ppk = Ppk::wherenull('deleted_at');
        if (!userRole('Administrator')) {
            $ppk = $ppk->where('id', Auth()->user()->ppk_id)->first();
        } else {
            $ppk = $ppk->get();
        }
        $pekerjaan = Pekerjaan::find($id);
        return view('pekerjaan.form', compact('title', 'data', 'konsultan', 'ppk', 'pekerjaan'));
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

            $ppk_nama = "";
            if (!empty($request->ppk_nama)) {
                $ppk_nama = $request->ppk_nama;
            } else {
                $ppk = Ppk::find($request->ppk_id);
                $ppk_nama = $ppk->nama;
            }

            $kons = Konsultan::find($request->konsultan_id);
            $kn = $kons->nama_konsultan;

            $pekerjaan = [
                "ppk_id" => $request->ppk_id,
                "ppk_nama" => $ppk_nama,
                "tahun_anggaran" => $request->tahun_anggaran,
                "nama_kegiatan" => $request->nama_kegiatan,
                "nama_pekerjaan" => $request->nama_pekerjaan,
                "nama_penyedia" => $request->nama_penyedia,
                "pagu_anggaran" => str_replace(',', '.', $request->pagu_anggaran),
                "harga_perkiraan" => str_replace(',', '.', $request->harga_perkiraan),
                "konsultan_id" => $request->konsultan_id,
                "konsultan_nama" => $kn,
                "no_sk" => $request->no_sk,
                "tanggal_sk" => carbon::parse($request->tanggal_sk)->format('Y-m-d'),
                "nilai_kontrak" => str_replace(',', '.', $request->nilai_kontrak),
                "tanggal_mulai" => carbon::parse($request->tanggal_mulai)->format('Y-m-d'),
                "tanggal_selesai" => carbon::parse($request->tanggal_selesai)->format('Y-m-d'),
                "updated_by" => Auth()->user()->id,
                "updated_at" => Carbon::now()
            ];
            $pk = Pekerjaan::findorfail($id)->update($pekerjaan);

            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }
        return redirect(url('pekerjaan', $id))->with(['status' => $pesan]);
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

    public function deleteFile($id)
    {
        $pekerjaanFile = PekerjaanFile::find($id);
        $pekerjaanFile->update([
            'deleted_at' => Carbon::now(),
            'deleted_by' => Auth()->user()->id
        ]);
        return redirect()->back()->with(['status' => 'Berhasil Hapus File']);
    }
    public function storeFile(Request $request)
    {
        // dd($request->file_lampiran);
        if ($request->hasFile('file_lampiran')) {
            foreach ($request->file_lampiran as $kf => $rf) {
                $file = $request->file('file_lampiran')[$kf];
                $file_name = Carbon::now()->timestamp . '_' . $file->getClientOriginalName();
                $fullpath = 'pekerjaan/' . $file_name;
                $file->move(storage_path($this->path), $file_name);

                $dokumen['pekerjaan_id'] = $request->pekerjaan_id;
                $dokumen['path_file'] = $fullpath;
                $dokumen['minggu_ke'] = $request->minggu_ke[$kf];
                $dokumen['nama_file'] = $file_name;
                $dokumen['keterangan_file'] = $request->keterangan_file[$kf];
                $dokumen['ext_file'] = $file->getClientOriginalExtension();
                $dokumen['created_by'] = Auth()->user()->id;
                PekerjaanFile::create($dokumen);
            }
        }
        return redirect()->back()->with(['status' => 'Berhasil Upload']);
    }

    public function PekerjaanSelesai($id)
    {
        DB::beginTransaction();
        try {
            $pekerjaan = [
                "status" => 3,
                "updated_by" => Auth()->user()->id,
                "updated_at" => Carbon::now()
            ];
            Pekerjaan::findorfail($id)->update($pekerjaan);
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }
        return redirect()->back()->with(['status' => $pesan]);
    }
    public function PekerjaanPutusKontrak($id)
    {
        DB::beginTransaction();
        try {
            $pekerjaan = [
                "status" => 4,
                "updated_by" => Auth()->user()->id,
                "updated_at" => Carbon::now()
            ];
            Pekerjaan::findorfail($id)->update($pekerjaan);
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = 'Message: ' . $e->getMessage();
        }
        return redirect()->back()->with(['status' => $pesan]);
    }
}
