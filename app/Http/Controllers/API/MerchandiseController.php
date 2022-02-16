<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Merchandise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Image;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMerchandise()
    {
        // $merchandises = Merchandise::all();

        $merchandisesFree = Merchandise::where('price',0)->get();
        $merchandisesPremium = Merchandise::where('price','<>',0)->get();
        $marchendise['free']=$merchandisesFree;
        $marchendise['premium']=$merchandisesPremium;

        return response()->json($marchendise);
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
            'price' => 'required|numeric',
        ]);
        if($request->image!='null'){
            $image = $request->image;
            $filename = Str::slug($request->title).'.'.$image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->stream();
            Storage::disk('public')->put('/images/merchandises/'.$filename,$img);
        }
        else{
            $filename=null;
        }
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
            'price' => 'required|numeric',
        ]);


        if($request->image!='null'){
            if($merchandise->image){
                $path = "'\storage\public\images\merchandises\'".$merchandise->image;
                try{
                    unlink($path);
                }
                catch (\Exception $e) {
                    //$e->getMessage();
                }            
            }                
            $image = $request->image;
            $filename = Str::slug($request->title).'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->stream();
            Storage::disk('public')->put('/images/merchandises/'.$filename,$img);
        }
        else{
            if($merchandise->image)
                $filename=$merchandise->image;
            else
                $filename=null;
        }

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
