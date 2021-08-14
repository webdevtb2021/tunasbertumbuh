<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Article extends Model
{
    use HasFactory;
    protected $fillable=['title','body','user_id'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function articleImages()
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title']=$value;
        $this->attributes['slug']=Str::slug($value);
    }
}
