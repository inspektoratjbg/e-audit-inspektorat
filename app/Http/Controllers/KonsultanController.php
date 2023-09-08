<?php

namespace App\Http\Controllers;

use App\Http\Requests\Konsultanrequest;
use App\Konsultan;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class KonsultanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:konsultan.list')->only('index');
        $this->middleware('permission:konsultan.create')->only(['create', 'store']);
        $this->middleware('permission:konsultan.edit')->only(['edit', 'update']);
        $this->middleware('permission:konsultan.delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Konsultan::whereNull('deleted_at');
            if (!userRole('Administrator')) {
                #$data = $data->where('created_by', Auth()->user()->id);
            }
            return DataTables::of($data)
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    if (userCan('konsultan.edit')) {
                        $btn = '<a href="' . route('konsultan.edit', $role->id) . '" class="badge badge-primary"><i class=" fas fa-pencil-alt"></i> </a>';
                    }
                    if (userCan('konsultan.delete')) {
                        $btn .= '<a href="#"   data-url="' . route('konsultan.hapus', $role->id) . '" class="hapus badge badge-danger"><i class="fas fa-trash-alt"></i> </a>';
                    }
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $title = "Daftar Konsultan Pengawas";
        return view('konsultan/index', compact('title'));
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
            'method' => 'POST',
            'action' => url('konsultan'),
        ];
        $title = "Tambah Konsultan Pengawas";
        return view('konsultan.form', \compact('data', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Konsultanrequest $request)
    {
        //
        // dd($request->all());
        DB::beginTransaction();
        try {

            $data = $request->except(['_token', '_method']);
            $data['created_by'] = Auth()->user()->id;
            $konsultan = Konsultan::create($data);

            $max=Konsultan::where('email',$request->email)->first();

            User::create(
                [
                    'konsultan_id' => $max->id,
                    'email' => $konsultan->email,
                    'name' => $konsultan->nama_konsultan,
                    'password' => \bcrypt('sipil')
                ]
            )->assignRole('Konsultan');

            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $pesan = 'Message: ' . $e->getMessage();
        }
        // dd($pesan);
        return redirect(url('konsultan'))->with(['status' => $pesan]);
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
            'method' => 'PATCH',
            'action' => route('konsultan.update', $id),
        ];
        $konsultan = Konsultan::find($id);
        $title = "Edit Konsultan Pengawas";
        return view('konsultan.form', \compact('data', 'title','konsultan'));
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


            $data = $request->except(['_token', '_method']);
            $data['updated_by'] = Auth()->user()->id;
            $konsultan = Konsultan::findorfail($id);
            $konsultan->update($data);


            User::where('ppk_id', $konsultan->id)->update(
                [
                    'email' => $konsultan->email,
                    'name' => $konsultan->nama_konsultan
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
        return redirect(url('konsultan'))->with(['status' => $pesan]);
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

            Konsultan::find($id)->update(
                [
                    'deleted_by' => Auth()->user()->id,
                    'deleted_at'=> Carbon::now()
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
        return redirect(url('konsultan'))->with(['status' => $pesan]);
    }
}
