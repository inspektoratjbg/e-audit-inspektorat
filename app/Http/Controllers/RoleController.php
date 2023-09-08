<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Datatables;
use DB;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!userCan('role.list')) {
            \abort(403);
        }

        if ($request->ajax()) {
            $role = Role::query();
            return Datatables::of($role)
                ->order(function ($query) {
                    $query->orderByRaw("id desc");
                })
                ->addColumn('permission', function ($role) {
                    $res = '';
                    foreach ($role->getAllPermissions() as $rr) {
                        $res .= '<code>' . $rr->name . '</code><br>';
                    }
                    // $res = implode(',', $res);
                    return $res;
                })
                ->addColumn('action', function ($role) {
                    $btn = '<a href="' . route('role.edit', $role->id) . '" class="badge badge-primary"><i class=" fas fa-pencil-alt"></i> </a>';
                    $btn .= '<a href="#"   data-url="' . route('role.hapus', $role->id) . '" class="hapus badge badge-danger"><i class="fas fa-trash-alt"></i> </a>';
                    return $btn;
                })
                ->rawColumns(['action', 'permission'])
                ->make(true);
        }
        $title = "Role";
        return view('Role.Index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!userCan('role.create')) {
            \abort(403);
        }
        $data = [
            'action' => route('role.store'),
            'method' => 'POST',
            'permission' => Permission::pluck('name')->toarray()
        ];
        return view('Role.form', \compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!userCan('role.create')) {
            \abort(403);
        }
        DB::beginTransaction();
        try {

            $this->validate($request, [
                'name' => ['required', 'string', 'max:255', 'unique:roles'],
            ]);

            Role::insert(['name' => $request->name, 'guard_name' => 'web']);

            $role = Role::where(['name' => $request->name])->first();
            $vr = !empty($request->permission) ? $request->permission : [];
            foreach ($vr as $vr) {
                $permission = Permission::where('name', $vr)->first();
                $role->givePermissionTo($permission);
                $permission->assignRole($role);
            }
            $pesan = "berhasil di tambahkan";
            $type = "success";
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = $e->getMessage();
            $type = "warning";
            // return false;
        }
        // dd($pesan);
        return redirect()->route('role.index')->with(['status' => $pesan, 'type' => $type]);
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
        if (!userCan('role.edit')) {
            \abort(403);
        }
        $role = Role::find($id);
        // dd($role->hasPermissionTo('Beranda'));
        $data = [
            'action' => route('role.update', $id),
            'method' => 'PATCH',
            'permission' => Permission::pluck('name')->toarray(),
            'role' => $role
        ];
        return view('Role.form', \compact('data'));
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
        if (!userCan('role.edit')) {
            \abort(403);
        }
        DB::beginTransaction();
        try {

            $role = Role::find($id);
            $role->name = $request->name;
            $role->save();

            // revoke permission
            foreach ($role->getAllPermissions() as $rr) {
                $role->revokePermissionTo($rr->name);
            }

            // assign permission
            $vr = !empty($request->permission) ? $request->permission : [];
            foreach ($vr as $vr) {
                $permission = Permission::where('name', $vr)->first();
                $role->givePermissionTo($permission);
                $permission->assignRole($role);
            }

            $pesan = "berhasil di update";
            $type = "success";
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $pesan = $e->getMessage();
            $type = "warning";
            // return false;
        }

        // dd();
        return redirect()->route('role.index')->with(['status' => $pesan, 'type' => $type]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!userCan('role.delete')) {
            \abort(403);
        }
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('role.index')->with(['pesan' => 'Data telah di hapus', 'type' => 'success']);
    }
}
