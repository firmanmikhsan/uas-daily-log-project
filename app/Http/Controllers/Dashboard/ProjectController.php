<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        $data['projects'] = $projects;
        return view('admin.project.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.project.create');
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
            "description" => ["required", "string", "max:250"],
            "image" => ["required", "image"]
        ]);
        $validator->validate();

        DB::beginTransaction();
        try {
            $image = $request->file('image');
            $image = Storage::putFileAs('/images/project', $image, now()->timestamp."-".Str::slug($request->name).".".$image->guessClientExtension());
            
            Project::create([
                "name" => $request->name,
                "description" => $request->description,
                "image" => $image
            ]);

            DB::commit();
            return redirect()->route('dashboard.projects.index')->with('status', 'Project successfully created.');
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
        $project = Project::findOrFail($id);
        $data['project'] = $project;
        return view('admin.project.edit', $data);
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
            "description" => ["required", "string", "max:250"],
            "image" => ["nullable", "image"]
        ]);
        $validator->validate();

        DB::beginTransaction();
        try {
            $project = Project::findOrFail($id);
            if ($request->has('image')) {
                $image = $request->file('image');
                $image = Storage::putFileAs('/images/project', $image, now()->timestamp."-".Str::slug($request->name).".".$image->guessClientExtension());
                $project->image = $image;
            }
            $project->name = $request->name;
            $project->description = $request->description;
            $project->save();

            DB::commit();
            return redirect()->route('dashboard.projects.index')->with('status', 'Project successfully updated.');
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
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('dashboard.projects.index')->with('status', 'Project successfully deleted.');
    }
}
