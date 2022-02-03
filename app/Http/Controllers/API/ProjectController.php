<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Image;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('user:id,name')->withCount('volunteers')->orderBy('id', 'DESC')->get();
        return response()->json($projects);
    }/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProjects()
    {
        $projects = Project::with('user:id,name')->withCount('volunteers')->latest()->paginate(3);
        return response()->json($projects);
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
        $this->validate($request,[
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $image = $request->image;
        $filename = Str::slug($request->title).'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/projects/'.$filename,$img);

        return Project::create([            
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user_id,
            'image' => $filename,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
       $project = Project::with('user:id,name')->withCount('volunteers')->findOrFail($id);
        return $project;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->validate($request,[
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        if($request->imagesExist)
            $filename = $request->imagesExist;
        else{
            if($request->images){
                $image = $request->images;
                $filename = Str::slug($request->title).'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $img->stream();
                Storage::disk('public')->put('/images/projects/'.$filename,$img);
            }
            else
                $filename = null;
        }
            
        
        $project->update([
            'title' => $request->title,
            'body' => $request->body,
            'image' => $filename,
        ]);
        $project->save();
        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return $project;
    }
}
