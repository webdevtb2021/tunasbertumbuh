<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donations = Donation::with('donator')->latest()->paginate(10);
        return response()->json($donations);
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
            'phone' => 'required|string',
            'redirect_page' => 'required|string',
        ]);

        $donator = Donator::create([
            'name' =>  $request->name,
            'phone' => $request->phone,
            'email' =>  $request->email,
            'address' => $request->address,
        ]);

        $image = $request->image;
        $filename = $donator->id.'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/donations/'.$filename,$img);

        return Donation::create([            
            'category' => $request->category,
            'bukti' => $filename,
            'notes_money' => $request->notes_money,
            'notes_barang' => $request->notes_barang,
            'address_donation' => $request->address_donation,
            'donator_id' => $donator->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function show(Donation $donation)
    {
        //
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
