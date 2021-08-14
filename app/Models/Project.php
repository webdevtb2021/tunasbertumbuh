<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable=['title','body','datetime','image'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }
}
