<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $applicants = Applicant::with('application')->latest()->paginate(10);
        return response()->json($applicants);
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string|email',
            'address' => 'required|string',
            'ipk' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'education' => 'required|string',
            'biography' => 'required|string',
            'summary' => 'required|string',

        ]);

        return Applicant::create([
            'name' =>  $request->name,
            'phone' => $request->phone,
            'email' =>  $request->email,
            'address' => $request->address,
            'ipk' => $request->ipk,
            'education' => $request->education,
            'biography' => $request->biography,
            'summary' => $request->summary,
            'application_id' => $request->application_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function show(Applicant $applicant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function edit(Applicant $applicant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $applicant = Applicant::findOrFail($id);
        $this->validate($request,[
            'scores' => 'required|numeric',
            'other_notes' => 'required|string',
        ]);

        $applicant->update($request->all());
        $applicant->save();
        return $applicant;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();

        return $applicant;
    }
}
