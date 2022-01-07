<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Partnership;
use Illuminate\Http\Request;

class PartnershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partnerships = Partnership::all();
        return response()->json($partnerships);
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
            'name' => 'required|string',
            'url' => 'required|string',
            'category' => 'required|string',
        ]);

        $image = $request->image;
        $filename = Str::slug($request->title).'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/partnerships/'.$filename,$img);

        return Partnership::create([      
            'name' => $request->name,
            'url' => $request->url,
            'category' => $request->category,
            'notes' => $request->notes,
            'image' => $filename,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Partnership  $partnership
     * @return \Illuminate\Http\Response
     */
    public function show(Partnership $partnership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Partnership  $partnership
     * @return \Illuminate\Http\Response
     */
    public function edit(Partnership $partnership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partnership  $partnership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $partnership = Partnership::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string',
            'url' => 'required|string',
            'category' => 'required|string',
        ]);

        $path = public_path()."/images/partnerships/".$partnership->image;
        unlink($path);

        $image = $request->image;
        $filename = Str::slug($request->title).'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/partnerships/'.$filename,$img);

        $partnership->update([
            'name' => $request->name,
            'url' => $request->url,
            'category' => $request->category,
            'notes' => $request->notes,
            'image' => $filename,
        ]);
        $partnership->save();
        return $partnership;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partnership  $partnership
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partnership = Partnership::findOrFail($id);
        $partnership->delete();

        return $partnership;
    }
}