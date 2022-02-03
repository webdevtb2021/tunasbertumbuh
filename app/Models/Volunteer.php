<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

     protected $fillable=['name','image','url', 'status', 'notes', 'project_id'];

    public function project()
    {
    	return $this->belongsTo(Project::class);
    }
}
