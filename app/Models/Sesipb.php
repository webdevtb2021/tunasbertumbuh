<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sesipb extends Model
{
    use HasFactory;

    protected $fillable=['name','detail_waktu','pemateri','url_pemateri'];

    public function sesipesertapbs()
    {
        return $this->hasMany(Sesipesertapb::class);
    }

}
