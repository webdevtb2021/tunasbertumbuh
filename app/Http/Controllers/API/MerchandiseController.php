<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MerchandiseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchandises = Merchandise::all();
        return response()->json($merchandises);
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
            'description' => 'required|string',
            'price' => 'required|string',
        ]);

        $image = $request->image;
        $filename = Str::slug($request->title).'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/merchandises/'.$filename,$img);

        return Merchandise::create([            
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $filename,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function show(Merchandise $merchandise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchandise $merchandise)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $merchandise = Merchandise::findOrFail($id);
        $this->validate($request,[
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
        ]);

        $path = public_path()."/images/merchandises/".$merchandise->image;
        unlink($path);

        $image = $request->image;
        $filename = Str::slug($request->title).'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/merchandises/'.$filename,$img);

        $merchandise->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $filename,
        ]);
        $merchandise->save();
        return $merchandise;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merchandise  $merchandise
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $merchandise = Merchandise::findOrFail($id);
        $merchandise->delete();

        return $merchandise;
    }
}
