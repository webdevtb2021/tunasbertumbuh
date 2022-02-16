<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Image;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $volunteers = Volunteer::with('project:id,title')->orderBy('name','ASC')->get();
        $projects = Project::orderBy('created_at','ASC')->select('id','title')->get();
        $data=null;
        $data["volunteers"] = $volunteers;
        $data["projects"] = $projects;
        return response()->json($data);
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
            'status' => 'required|numeric',
            'project_id' => 'required|numeric',
            'image' => 'required'
        ]);
        $image = $request->image;
        $filename = Str::slug($request->name).'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/volunteers/'.$filename,$img);

        return Volunteer::create([      
            'name' => $request->name,
            'url' => $request->url,
            'notes' => $request->notes,            
            'status' => $request->status,
            'project_id' => $request->project_id,
            'image' => $filename
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
            'status' => 'required|numeric',
            'project_id' => 'required|numeric',
        ]);
        if($request->image == 'null'){
            $volunteer->update([
                'name' => $request->name,
                'url' => $request->url,
                'notes' => $request->notes,
                'status' => $request->status,
                'project_id' => $request->project_id,
            ]);
            $volunteer->save();
        }
        else{
            $image = $request->image;
            $filename = Str::slug($request->name).'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->stream();
            Storage::disk('public')->put('/images/volunteers/'.$filename,$img);

            $volunteer->update([
                'name' => $request->name,
                'url' => $request->url,
                'notes' => $request->notes,
                'status' => $request->status,
                'project_id' => $request->project_id,
                'image' => $filename
            ]);
            $volunteer->save();
        }        
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
}
