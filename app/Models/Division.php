<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable=['name','description','task', 'parent_id'];

    public function parent()
    {
    	return $this->belongsTo(Division::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Division::class,'parent_id');
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
