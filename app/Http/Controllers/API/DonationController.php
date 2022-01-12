<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Donator;
use Illuminate\Http\Request;
use Storage;
use Image;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donations = Donation::with('donator:id,name,phone,email')->select('id','created_at','donator_id','category','verification','jenis_barang_or_jumlah_bayar')->get();
        return response()->json($donations);
    }


    public function indexDonations()
    {
        $maxId = Donation::max('id');
        $data["nextId"] = $maxId + 1;
        return response()->json($data);
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
            'email' => 'required|string',
        ]);

        $donator = Donator::updateOrCreate(
            ['email' =>  $request->email],
            ['name' =>  $request->name,
            'phone' => $request->phone,
            'address' => $request->address]
        );

        $image = $request->image;
        $filename = $donator->id.'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/donations/'.$filename,$img);

        return Donation::create([            
            'category' => $request->category,
            'bukti' => $filename,
            'jenis_barang_or_jumlah_bayar' => $request->jenis_jumlah,
            'notes' => $request->notes,
            'donator_id' => $donator->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        

        $donations = Donation::findOrFail($id);
        $donations->donator;
        return response()->json($donations);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);
        $this->validate($request,[
            'verification' => 'required|numeric',
        ]);

        $donation->update($request->all());
        $donation->save();
        return $donation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $donation = Donation::findOrFail($id);
        $donation->delete();

        return $donation;
    }
}
