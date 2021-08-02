<?php

namespace App\Http\Controllers;

use App\Models\Project\AssignedProject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $projects = Auth::user()->projects;
        $data['projects'] = $projects;

        $timelines = Auth::user()->reports()->whereDate('created_at', Carbon::today()->format('Y-m-d'))->get()->groupBy('project.name');
        $data['user_timelines'] = $timelines;
        
        return view('home', $data);
    }
}
