<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JobPosistion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JobPositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $positions = JobPosistion::get();
        $data['positions'] = $positions;
        return view('admin.jobs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jobs.create');
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
            "name" => ["required", "string", "unique:job_posistions,name"]
        ]);
        $validator->validate();
        DB::beginTransaction();
        try {
            $positions = JobPosistion::create(['name' => $request->name]);
            DB::commit();
            return redirect()->route('dashboard.positions.index')->with('status', 'Position successfuly created.');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $position = JobPosistion::findOrFail($id);
        $data['position'] = $position;
        return view('admin.jobs.edit', $data);
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
            "name" => ["required", "string", "unique:job_posistions,name,$id"]
        ]);
        $validator->validate();
        DB::beginTransaction();
        try {
            $positions = JobPosistion::findOrFail($id)->update(['name' => $request->name]);
            DB::commit();
            return redirect()->route('dashboard.positions.index')->with('status', 'Position successfuly updated.');
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
        $job = JobPosistion::findorFail($id);
        $job->delete();
        return redirect()->route('dashboard.positions.index')->with('status', 'Position successfuly deleted.');
    }
}
