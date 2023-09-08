<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use app\User;
use DB;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!userCan('user.list')) {
            \abort(403, 'Anda tidak memiliki hak ases');
        }

        if ($request->ajax()) {
            $user = User::query();
            return Datatables::of($user)
                ->addColumn('roles', function ($user) {
                    $res = "";
                    foreach ($user->getRoleNames() as $rr) {
                        $res .= $rr . ", ";
                    }
                    return "<code>" . substr($res, 0, -2) . "</code>";
                })
                ->addColumn('kantor', function ($user) {
                    return   '';
                })
                ->addColumn('divisi', function ($user) {
                    return  '';
                })
                ->addColumn('action', function ($role) {
                    $btn = "<div class='btn-group'>";
                    $btn .= '<a href="' . route('account.edit', $role->id) . '" class="badge badge-primary"><i class=" fas fa-cog"></i></a>';

                    $btn .= '<a href="' . url('resetpassword', $role->id) . '" class="badge badge-warning"><i class=" fas fa-exchange-alt"></i></a>';
                    // 
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['roles', 'action',])
                ->make(true);
        }

        return view('Account.Index');
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
            'action' => route('account.store'),
            'method' => 'POST',
            // 'user' => $user,
            'role' => Role::get(),
            // 'ar' => $user->getRoleNames()->toarray()
        ];

        return view('Account.form', \compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {

            $data = $request->all();
            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $user->syncRoles($request->role);
            $pesan = "berhasil di tambahkan";
            $type = "success";
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = $e->getMessage();
            $type = "warning";
        }
        // dd($pesan);
        return redirect()->route('account.index')->with(['pesan' => 'Berhasil di proses', 'type' => 'success']);
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
        if (!userCan('user.role')) {
            \abort(403, 'Anda tidak memiliki hak ases');
        }
        $user = User::find($id);
        $data = [
            'action' => route('account.update', $id),
            'method' => 'PATCH',
            'user' => $user,
            'role' => Role::get(),
            'ar' => $user->getRoleNames()->toarray()
        ];

        return view('Account.form', \compact('data'));
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
        if (!userCan('user.role')) {
            \abort(403, 'Anda tidak memiliki hak ases');
        }
        //
        DB::beginTransaction();
        try {

            $update = $request->only(['name', 'username']);
            $user = User::find($id);
            $user->update($update);
            $user->syncRoles($request->role);

            $pesan = "berhasil di update";
            $type = "success";
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = $e->getMessage();
            $type = "warning";
        }
        // dd($pesan);
        

        return redirect()->route('account.index')->with(['pesan' => 'Berhasil di proses', 'type' => 'success']);
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
