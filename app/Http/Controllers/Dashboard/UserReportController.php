<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date)->format('Y-m-d') : Carbon::today()->format('Y-m-d');
        $userReports = User::whereHas('roles', function($role){
            $role->where('name', 'employee');
        })
        ->with('profile.position')
        ->with(['reports' => function($reports) use($date){
            $reports->with('project')->whereDate('created_at', $date);
        }])
        ->withSum(['reports' => function($reports) use($date){
            $reports->whereDate('created_at', $date);
        }], 'hours')->withCount(['reports' => function($reports) use($date){
            $reports->whereDate('created_at', $date);
        }])
        ->get();
        $data['user_reports'] = $userReports;
        $data['date'] = $date;
        return view('admin.reports.index', $data);
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
    public function show($id, Request $request)
    {
        $date = $request->date ? Carbon::parse($request->date)->format('Y-m-d') : Carbon::today()->format('Y-m-d');
        $user = User::with('profile.position')
        ->withSum(['reports' => function($reports) use($date){
            $reports->whereDate('created_at', $date);
        }], 'hours')->withCount(['reports' => function($reports) use($date){
            $reports->whereDate('created_at', $date);
        }])->find($id);
        $userReports = $user->reports()->whereDate('created_at', $date)->get()->groupBy('project.name');
        $data['user_timelines'] = $userReports;
        $data['user'] = $user;
        // return $data;
        return view('admin.reports.detail', $data);
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
