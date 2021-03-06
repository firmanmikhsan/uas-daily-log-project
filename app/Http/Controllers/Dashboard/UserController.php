<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JobPosistion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        $data['users'] = $users;
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $data['roles'] = $roles;

        $jobPosition = JobPosistion::get();
        $data['job_positions'] = $jobPosition;
        return view('admin.user.create', $data);
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
            "email" => ["required", "email"],
            "phone_number" => ["required", "regex:/^([0-9\s\-\+\(\)]*)$/", "min:10"],
            "address" => ["required", "string"],
            "avatar" => ["required", "image"],
            "job_position_id" => ["required", "exists:job_posistions,id"],
            "password" => ["required", "string", "confirmed"],
            "role_names" => ["required", "array", "min:1"],
            "role_names.*" => ["required", "exists:roles,name"]
        ]);
        $validator->validate();

        DB::beginTransaction();
        try {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);
            $image = $request->file('avatar');
            $image = Storage::putFileAs('/images/user/avatar', $image, now()->timestamp."-".Str::slug($request->name).".".$image->guessClientExtension());
            $user->profile()->create([
                "phone_number" => $request->phone_number,
                "address" => $request->address,
                "avatar" => $image,
                "job_position_id" => $request->job_position_id
            ]);
            $user->assignRole($request->role_names);

            DB::commit();
            return redirect()->route('dashboard.users.index')->with('status', 'User created successfuly.');
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
        $roles = Role::all();
        $data['roles'] = $roles;

        $user = User::with('roles')->find($id);
        $data['user'] = $user;

        $jobPosition = JobPosistion::get();
        $data['job_positions'] = $jobPosition;
        return view('admin.user.edit', $data);
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
            "email" => ["required", "email"],
            "phone_number" => ["required", "regex:/^([0-9\s\-\+\(\)]*)$/", "min:10"],
            "address" => ["required", "string"],
            "avatar" => ["nullable", "image"],
            "job_position_id" => ["required", "exists:job_posistions,id"],
            "password" => ["nullable", "string", "confirmed"],
            "role_names" => ["required", "array", "min:1"],
            "role_names.*" => ["required", "exists:roles,name"]
        ]);
        $validator->validate();

        DB::beginTransaction();
        try {
            $user = User::with('profile')->find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password != "") {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            if (!$user->profile()->exists()) {
                $image = "images/default/placeholder.png";
                if ($request->has('avatar')) {
                    $image = $request->file('avatar');
                    $image = Storage::putFileAs('/images/user/avatar', $image, now()->timestamp."-".Str::slug($request->name).".".$image->guessClientExtension());
                }
                $user->profile()->create([
                    "phone_number" => $request->phone_number,
                    "address" => $request->address,
                    "avatar" => $image,
                    "job_position_id" => $request->job_position_id
                ]);
            }else{
                $profileData["phone_number"] = $request->phone_number;
                $profileData["address"] = $request->address;
                if ($request->has('avatar')) {
                    $image = $request->file('avatar');
                    $image = Storage::putFileAs('/images/project', $image, now()->timestamp."-".Str::slug($request->name).".".$image->guessClientExtension());
                    $profileData["avatar"] = $image;
                }
                $user->profile()->update($profileData);
            }

            $user->syncRoles($request->role_names);

            DB::commit();
            return redirect()->route('dashboard.users.index')->with('status', 'User update successfuly.');
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
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('dashboard.users.index')->with('status', 'User successfully deleted.');
    }
}
