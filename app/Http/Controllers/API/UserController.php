<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Periode;
use App\Models\Position;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('dependences')->latest()->paginate(10);
        return response()->json($users);
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
            'permission' => 'required|string',
            'password' => 'sometimes|min:6',
            'status' => 'required|string',
            'testimony' => 'required|string',
            'instagram' => 'required|string',
            'facebook' => 'required|string',
            'twitter' => 'required|string',
        ]);

        $user = User::create([
            'name' =>  $request->name,
            'email' =>  $request->email,
            'permission' => $request->permission,
            'password' => $request->password,
            'status' => $request->status,
        ]);

        $image = $request->image;
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
    public function show(User $user)
    {
        //
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
            'phone' => 'required|string',
            'email' => 'required|string',
            'permission' => 'required|string',
            'password' => 'sometimes|min:6',
            'status' => 'required|string',
            'testimony' => 'required|string',
            'instagram' => 'required|string',
            'facebook' => 'required|string',
            'twitter' => 'required|string',
        ]);

        $path = public_path()."/images/users/".$user->url_image;
        unlink($path);

        $image = $request->image;
        $filename = $user->id.'-'.date('YmdHis').'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->stream();
        Storage::disk('public')->put('/images/users/'.$filename,$img);

        $user->update([
            'name' =>  $request->name,
            'email' =>  $request->email,
            'permission' => $request->permission,
            'password' => $request->password,
            'status' => $request->status,
        ]);
        $user->save();

        $user->dependences()->update([  
            'phone' =>  $request->phone,          
            'testimony' =>  $request->testimony,          
            'instagram' =>  $request->instagram,          
            'facebook' =>  $request->facebook,          
            'twitter' =>  $request->twitter,          
            'url_image' =>  $filename,   
        ]);

        $user->dependences()->save();

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
