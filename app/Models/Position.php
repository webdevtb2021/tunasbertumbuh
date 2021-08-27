<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable=['division_id','jabatan_id','periode_id','user_id','leader'];

    public function user()
    {
    	return $this->belongsTo(User::class)->with('dependences:user_id,instagram,facebook,twitter,created_at,url_image');
    }

     public function leader()
    {
        return $this->belongsTo(User::class,'leader');
    }

    public function division()
    {
    	return $this->belongsTo(Division::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }  

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

}
