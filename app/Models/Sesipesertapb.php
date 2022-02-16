<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesipesertapb extends Model
{
    use HasFactory;

    protected $fillable=['pesertapb_id','sesipb_id','notes','waktu_absen'];

    public function pesertapb()
    {
    	return $this->belongsTo(Pesertapb::class);
    }

    public function sesipb()
    {
        return $this->belongsTo(Sesipb::class);
    }  

}
