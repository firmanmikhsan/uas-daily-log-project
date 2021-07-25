<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $data['roles'] = $roles;
        return view('admin.role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        $data['permissions'] = $permissions;
        return view('admin.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "role_permissions" => ["required", "array", "min:1"],
            "role_permissions.*" => ["required", "exists:permissions,name"]
        ]);
        $validator->validate();

        DB::beginTransaction();
        try {
            $role = Role::create(["name" => $request->name]);
            $role->givePermissionTo($request->role_permissions);

            DB::commit();
            return redirect()->route('dashboard.roles.index')->with('status', "Role succesfully created.");
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
        $role = Role::with('permissions')->find($id);
        $data['role'] = $role;

        $permissions = Permission::get();
        $data['permissions'] = $permissions;
        return view('admin.role.edit', $data);
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
        $validator = Validator::make($request->all(), [
            "name" => ["required", "string"],
            "role_permissions" => ["required", "array", "min:1"],
            "role_permissions.*" => ["required", "exists:permissions,name"]
        ]);
        $validator->validate();

        DB::beginTransaction();
        try {
            $role = Role::findOrFail($id);
            $role->update(["name" => $request->name]);
            $role->syncPermissions($request->role_permissions);

            DB::commit();
            return redirect()->route('dashboard.roles.index')->with('status', "Role succesfully update.");
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('dashboard.roles.index')->with('status', "Role succesfully deleted.");
    }
}
