<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pesertapb;
use App\Models\Sesipb;
use App\Models\Sesipesertapb;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Image;
use Carbon\Carbon;

class PesertapbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesertapbs = Pesertapb::with('sesipesertapbs')->orderBy('id', 'DESC')->get();
        $sesipbs = Sesipb::all();

        $data['pesertapbs'] = $pesertapbs;
        $data['sesipbs'] = $sesipbs;
        return response()->json($data);
    }
    public function indexFilter($id)
    {
        $pesertapbs = Pesertapb::join('sesipesertapbs','sesipesertapbs.pesertapb_id','=','pesertapbs.id')
                                ->select('pesertapbs.*')
                                ->whereIn('sesipesertapbs.sesipb_id', explode(",",$id))
                                ->distinct()->with(['sesipesertapbs' => function ($query) use ($id) {
                                    $query->whereIn('sesipesertapbs.sesipb_id',explode(",",$id));
                                }])->get();
        return response()->json($pesertapbs); 
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
            'phone' => 'required|numeric',
        ]);

        if($request->ssfollow){
            $image = $request->ssfollow;
            $ssfollow = Str::slug($request->name).'-ssfollow-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->stream();
            Storage::disk('public')->put('/images/pekanbeasiswas/'.$ssfollow,$img);
        }
        else
            $ssfollow = null;

        if($request->sslikeig){
            $image = $request->sslikeig;
            $sslikeig = Str::slug($request->name).'-sslikeig-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->stream();
            Storage::disk('public')->put('/images/pekanbeasiswas/'.$sslikeig,$img);
        }
        else
            $sslikeig = null;

        if($request->sslikefb){
            $image = $request->sslikefb;
            $sslikefb = Str::slug($request->name).'-sslikefb-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->stream();
            Storage::disk('public')->put('/images/pekanbeasiswas/'.$sslikefb,$img);
        }
        else
            $sslikefb = null;
        

        $pesertapb = Pesertapb::create([            
            'nama' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'info' => $request->info,
            'instansi' => $request->instansi,
            'ssfollow' => $ssfollow,
            'sslikeig' => $sslikeig,
            'sslikefb' => $sslikefb,
        ]);
        if($request->sesi){
            $sesis = explode(',', $request->sesi);
            foreach ($sesis as $sesi) {
                $pesertapb->sesipesertapbs()->create(['pesertapb_id'=>$pesertapb->id,'sesipb_id'=>$sesi]);
            }
        }

        return $pesertapb;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pesertapb::with('sesipesertapbs')->findOrFail($id);
        return response()->json($data);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $pesertaId = Pesertapb::where('Nama',$request->nama)->where('email',$request->email)->first()->id;
            try{
                $sesipesertapbId = Sesipesertapb::where('pesertapb_id',$pesertaId)->where('sesipb_id',$request->sesi)->first()->id;
                $sesipesertapb = Sesipesertapb::findOrFail($sesipesertapbId);
                $sesipesertapb->update([
                                        'notes'=>$request->notes,
                                        'waktu_absen'=>Carbon::now(),
                                    ]);
                $sesipesertapb->save();
                $response = $sesipesertapb; 
            }
            catch(\Exception $e) {
                return "Peserta tidak terdaftar pada sesi yang dipilih";
            }
        }
        catch(\Exception $e) {
           return "Nama dan email peserta tidak valid atau cocok";            
        }

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
