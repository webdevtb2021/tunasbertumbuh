<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fundreport;
use Illuminate\Http\Request;

class FundreportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fundreports = Fundreport::all();
        return response()->json($fundreports);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexFinance()
    {
        $fundreports = Fundreport::all();
        return response()->json($fundreports);
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
            'date' => 'required|date|max:191',
            'notes' => 'required|string|max:191',
            'debit' => 'required|numeric',
            'source' => 'required|string|max:191',
            'kredit' => 'required|numeric',
            'saldo' => 'required|numeric',
        ]);

        return Fundreport::create([
            'date' =>$request->date,
            'notes' =>$request->notes,
            'debit' =>$request->debit,
            'source' =>$request->source,
            'kredit' =>$request->kredit,
            'saldo' =>$request->saldo,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fundreport  $fundreport
     * @return \Illuminate\Http\Response
     */
    public function show(Fundreport $fundreport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fundreport  $fundreport
     * @return \Illuminate\Http\Response
     */
    public function edit(Fundreport $fundreport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fundreport  $fundreport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fundreport = Fundreport::findOrFail($id);
        $this->validate($request,[
            'date' => 'required|date|max:191',
            'notes' => 'required|string|max:191',
            'debit' => 'required|numeric',
            'source' => 'required|string|max:191',
            'kredit' => 'required|numeric',
            'saldo' => 'required|numeric',
        ]);

        $fundreport->update($request->all());
        return $fundreport;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fundreport  $fundreport
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fundreport = Fundreport::findOrFail($id);
        $fundreport->delete();

        return $fundreport;
    }
}
