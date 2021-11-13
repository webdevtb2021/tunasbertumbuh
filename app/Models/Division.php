<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Division extends Model
{
    use HasFactory;

    protected $fillable=['name','description','task', 'parent_id'];
    protected $appends=['excerptTask','excerptDesc'];

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

    public function excerpt($paragraph, $length)
    {
        return Str::limit(strip_tags($paragraph),$length);
    }

    public function getExcerptTaskAttribute()
    {
        return $this->excerpt($this->task,100);
    }

    public function getExcerptDescAttribute()
    {
        return $this->excerpt($this->description,100);
    }
}
