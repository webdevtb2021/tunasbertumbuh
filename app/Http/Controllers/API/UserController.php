<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Periode;
use App\Models\Jabatan;
use App\Models\Division;
use App\Models\Position;
use App\Models\Dependence;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Storage;
use Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = User::with('latestDependences','latestPositions')->orderBy('name','ASC')->get();
        return response()->json($member);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMembers($period=null)
    {
        if($period==null)
            $period = Periode::max('id');
        $periodes = Periode::all();
        $member = Position::with('user:id,name','jabatan','periode','division:id,name')->where('periode_id',$period)->orderBy('jabatan_id','ASC')->get();
        $data=null;
        $data["member"] = $member;
        $data["period"] = $periodes;
        $data["periodInt"] = $period;
        return response()->json($data);

    }

    public function indexTestimonies()
    {
       $data = User::with('dependences:user_id,testimony,created_at')->select(['id','name'])->latest()->paginate(10);
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
            'phone' => 'required|string',
            'email' => 'required|string',
        ]);

        $user = User::create([
            'name' =>  $request->name,
            'email' =>  $request->email,
            'permission' => $request->permission,
            'status' => $request->status,
            'password'=> Hash::make('admin@2021'),
        ]);

        $image = $request->url_image;
        $filename = $user->id.'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/users/'.$filename,$img);

        $user->dependences()->create([  
            'phone' =>  $request->phone,          
            'testimony' =>  $request->testimony,          
            'instagram' =>  $request->instagram,          
            'facebook' =>  $request->facebook,          
            'twitter' =>  $request->twitter,          
            'url_image' =>  $filename,          
            
        ]);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = User::findOrFail($id);
        $member->positions;
        $member->latestDependences;
        $period = Periode::all();
        $jabatan = Jabatan::all();
        $division = Division::all();
        $leader = User::where('status','=','1')->orderBy('name','ASC')->select('id','name')->get();
        $data=null;
        $data["member"] = $member;
        $data["period"] = $period;
        $data["jabatan"] = $jabatan;
        $data["division"] = $division;
        $data["leader"] = $leader;
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string',
        ]);

        $dependences = $user->latestDependences()->where('user_id',$id)->exists()? $user->latestDependences()->where('user_id',$id)->get() : new Dependence;
        if($request->url_image!='null'){
            if($dependences[0]->url_image){
                if($dependences[0]->url_image == $request->url_image) {
                     $filename=$dependences[0]->url_image;
                }
                else{
                    $path = "'\storage\public\images\users\'".$dependences[0]->url_image;
                    try{
                        unlink($path);
                    }
                    catch (\Exception $e) {
                        //$e->getMessage();
                    } 
                    $image = $request->url_image;
                    $filename = $user->id.'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
                    $img = Image::make($image->getRealPath());
                    $img->stream();
                    Storage::disk('public')->put('/images/users/'.$filename,$img);
                }
            }
            else{
                $image = $request->url_image;
                $filename = $user->id.'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $img->stream();
                Storage::disk('public')->put('/images/users/'.$filename,$img);
            }
        }
        else{
            if($dependences[0]->url_image)
                $filename=$dependences[0]->url_image;
            else
                $filename=null;
        }

        $user->update([
            'name' =>  $request->name,
        ]);
        $user->save();

        $user->dependences()->updateOrCreate(
            ['user_id'=>$id],
            [  
            'phone' =>  $request->phone,          
            'testimony' =>  $request->testimony,          
            'instagram' =>  $request->instagram,          
            'facebook' =>  $request->facebook,          
            'twitter' =>  $request->twitter,          
            'url_image' =>  $filename,
            ]
        );

        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return $user;
    }
}
