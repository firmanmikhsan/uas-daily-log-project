<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectReportController extends Controller
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
        $validator = Validator::make($request->all(), [
            "project_id" => ["required", "exists:projects,id"],
            "hours" => ["required", "numeric", "min:1", "max:12"],
            "report" => ["required", "string"]
        ]);
        $validator->validate();

        DB::beginTransaction();
        try {
            $user = Auth::user();

            $totalHoursToday = $user->reports()->whereDate('created_at', Carbon::today()->format('Y-m-d'))->sum('hours');

            if ($totalHoursToday+$request->houres >= 12) {
                return back()->with('time_limit', 'Anda tidak bisa bekerja lebih dari 12 jam sehari ya :). harap jangan bekerja berlebihan')->withInput($request->all());
            }

            $user->reports()->create([
                "project_id" => $request->project_id,
                "hours" => $request->hours,
                "description" => $request->report,
            ]);

            DB::commit();
            return redirect()->route('home.')->with('status', 'Report successfully created');
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
        //
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
