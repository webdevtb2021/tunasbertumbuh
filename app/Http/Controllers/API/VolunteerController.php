<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $volunteers = Volunteer::all();
        return response()->json($volunteers);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexVolunteer()
    {
        $volunteers = Volunteer::all();
        // $project = Project::all();
        return response()->json($volunteers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'name' => 'required|string',
            'url' => 'required|string',
            'notes' => 'required|string',
            'status' => 'required|numeric',
            'project_id' => 'required|numeric',
        ]);

        // $image = $request->image;
        // $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
        // $img = Image::make($image->getRealPath());
        // $img->stream();
        // Storage::disk('public')->put('/images/volunteers/'.$filename,$img);

        return Volunteer::create([      
            'name' => $request->name,
            'url' => $request->url,
            'notes' => $request->notes,            
            'status' => $request->status,
            'project_id' => $request->project_id,
            // 'image' => $filename,
            // 'project_id' => $project_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function show(Volunteer $volunteer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function edit(Volunteer $volunteer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string',
            'url' => 'required|string',
            'notes' => 'required|string',
            'status' => 'required|numeric',
            'project_id' => 'required|numeric',
        ]);

        // $path = public_path()."/images/volunteers/".$volunteer->image;
        // unlink($path);

        // $image = $request->image;
        // $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
        // $img = Image::make($image->getRealPath());
        // $img->stream();
        // Storage::disk('public')->put('/images/volunteers/'.$filename,$img);

        $volunteer->update([
            'name' => $request->name,
            'url' => $request->url,
            'notes' => $request->notes,
            'status' => $request->status,
            'project_id' => $request->project_id,
            // 'image' => $filename,
            // 'project_id' => $project_id,
        ]);
        $volunteer->save();
        return $volunteer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->delete();

        return $volunteer;
    }

    public function getProject()
    {
        $data = Project::get();
        
        return response()->json($data);
    }
}
