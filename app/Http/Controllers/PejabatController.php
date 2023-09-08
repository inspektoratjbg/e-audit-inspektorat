<?php

namespace App\Http\Controllers;

use App\Http\Requests\PejabatRequest;
use App\Pejabat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PejabatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Daftar Email Pejabat";
        $pejabat = Pejabat::get();
        return view('pejabat/index', compact('title', 'pejabat'));
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
        $pejabat = Pejabat::findorfail($id);
        $title = "Form Edit Pejabat";
        $data = [
            'action' => route('pejabat.update', $id),
            'method' => 'PATCH'
        ];
        return view('pejabat.form', compact('title', 'data', 'pejabat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PejabatRequest $request, $id)
    {
        //
        DB::beginTransaction();
        try {
            $data = $request->except(['_token', '_method']);
            // dd($data);

            $data['updated_by'] = Auth()->user()->id;
            $pejabat = Pejabat::findorfail($id);
            $pejabat->update($data);


           
            DB::commit();
            $pesan = "berhasil di proses";
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $pesan = 'Message: ' . $e->getMessage();
        }
        // dd($pesan);
        return redirect(url('pejabat'))->with(['status' => $pesan]);
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
