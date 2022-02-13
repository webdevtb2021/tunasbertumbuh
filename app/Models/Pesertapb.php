<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pesertapb extends Model
{
    use HasFactory;

    protected $fillable=['id','nama','instansi','email','phone','gender','ssfollow','sslikeig','sslikefb','info'];

    public function sesipesertapbs()
    {
    	return $this->hasMany(Sesipesertapb::class)->with('sesipb');
    }

}
