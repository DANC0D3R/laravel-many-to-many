<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $project = new Project();
        
        if (array_key_exists('image', $data)){
            $img_url = Storage::put('projects', $data['image']);
            $data['image'] = $img_url;
        };

        $project->name = $data['name'];
        $project->completion_date = $data['completion_date'];
        if ($project->image) $project->image = $data['image'];
        $project->author = $data['author'];
        $project->type_id = $data['type_id'];

        $project->save();

        return to_route('dashboard')->with('created-allert', "Il progetto $project->name è stato aggiunto");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view("admin.projects.show", compact("project"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        
        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $old_p_name = $project->name;
        $data = $request->all();

        if (array_key_exists('image', $data)){
            if ($project->image) Storage::delete($project->image);
            $img_url = Storage::put('projects', $data['image']);
            $data['image'] = $img_url;

            $project->image = $data['image'];
        };

        $project->name = $data['name'];
        $project->completion_date = $data['completion_date'];
        $project->author = $data['author'];
        $project->type_id = $data['type_id'];

        $project->save();

        return to_route('dashboard')->with('updated-allert', "Il progetto $old_p_name è stato modificato");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('dashboard')->with('deleted-allert', "Il progetto $project->name è stato eliminato");
    }
}