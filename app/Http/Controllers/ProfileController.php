<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return view('profile.edit');
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
            "password" => ["nullable", "string", "confirmed"]
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

            DB::commit();
            return redirect()->route('home.')->with('status', 'Profile update successfuly.');
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
        //
    }
}
