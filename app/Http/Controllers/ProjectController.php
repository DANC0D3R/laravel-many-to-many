<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $technologies = Technology::select('id', 'label')->get();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'completion_date' => 'nullable|date',
            'author' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'type_id' => 'nullable|exists:type,id',
            'technologies' => 'nullable|exists:technologies,id'
        ], [
            'name.required' => 'Il nome del progetto è obbligatorio.',
            'author.required' => "L'autore del progetto è obbligatorio.",
            'completion_date.date' => 'La data inserita non è valida.',
            'image.image' => 'L\'immagine deve essere un file di tipo immagine',
            'image.mimes' => 'L\'immagine deve essere un file png, jpg o jpeg',
            'type_id' => 'La tipologia scelta non è valida',
            'technologies' => 'Le tecnologie scelte non sono valide'
        ]);

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

        if (Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);

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
        $technologies = Technology::select('id', 'label')->get();

        $project_technologies = $project->technologies->pluck('id')->toArray();
        
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string',
            'completion_date' => 'nullable|date',
            'author' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png',
            'type_id' => 'nullable|exists:types,id',
            'technologies' => 'nullable|exists:technologies,id'
        ], [
            'name.required' => 'Il nome del progetto è obbligatorio.',
            'author.required' => "L'autore del progetto è obbligatorio.",
            'completion_date.date' => 'La data inserita non è valida.',
            'image.image' => 'L\'immagine deve essere un file di tipo immagine',
            'image.mimes' => 'L\'immagine deve essere un file png, jpg o jpeg',
            'type_id' => 'La tipologia scelta non è valida',
            'technologies' => 'Le tecnologie scelte non sono valide'
        ]);
        
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

        if (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        else $project->technologies()->detach();
        
        return to_route('dashboard')->with('updated-allert', "Il progetto $old_p_name è stato modificato");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->image) Storage::delete($project->image);

        if (count($project->technologies)) $project->technologies()->detach();

        $project->delete();
        return to_route('dashboard')->with('deleted-allert', "Il progetto $project->name è stato eliminato");
    }
}