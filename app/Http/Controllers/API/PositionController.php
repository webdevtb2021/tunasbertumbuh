<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            'jabatan_id' => 'required|numeric',
            'division_id' => 'required|numeric',
            'periode_id' => 'required|numeric',
            'leader' => 'required|numeric',
        ]);

        return Position::create([
            'user_id' =>  $request->user_id,
            'jabatan_id' => $request->jabatan_id,
            'division_id' =>  $request->division_id,
            'periode_id' => $request->periode_id,
            'leader' => $request->leader,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(Position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userid,$id)
    {
        $position = Position::findOrFail($id);
        $this->validate($request,[
            'jabatan_id' => 'required|numeric',
            'division_id' => 'required|numeric',
            'periode_id' => 'required|numeric',
            'leader' => 'required|numeric',
        ]);

        $position->update([
            'user_id' =>  $request->user_id,
            'jabatan_id' => $request->jabatan_id,
            'division_id' =>  $request->division_id,
            'periode_id' => $request->periode_id,
            'leader' => $request->leader,
        ]);
        $position->save();
        return $position;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy($userid, $id)
    {
        $position = Position::findOrFail($id);
        $position->delete();

        return $position;
    }
}
