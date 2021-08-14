<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CarouselController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carousels = Carousel::where('status','=','1')->get();
        return response()->json($carousels);
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
        $this->validate($request,[
            'title' => 'required|string',
            'status' => 'required|string',
            'redirect_page' => 'required|string',
        ]);

        
        $image = $request->image;
        $filename = Str::slug($request->title).'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/carousels/'.$filename,$img);

        return  Carousel::create([
            'title' =>  $request->title,
            'redirect_page' => $request->redirect_page,
            'status' =>  1,
            'url_image' => $filename,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function edit(Carousel $carousel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carousel = Carousel::findOrFail($id);
        
        $this->validate($request,[
            'title' => 'required|string',
            'status' => 'required|string',
            'redirect_page' => 'required|string',
        ]);


        $path = public_path()."/images/carousels/".$carousel->url_image;
        unlink($path);

        $image = $request->image;
        $filename = Str::slug($request->title)'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/carousels/'.$filename,$img);

        $carousel->update([
            'title' =>  $request->title,
            'redirect_page' => $request->redirect_page,
            'status' =>  1,
            'url_image' => $filename,
        ]);

        $carousel->save();
        
        return $carousel;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carousel  $carousel
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carousel = Carousel::findOrFail($id);
        $carousel->delete();

        return $carousel;
    }
}

