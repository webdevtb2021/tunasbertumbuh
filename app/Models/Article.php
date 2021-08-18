<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Article extends Model
{
    use HasFactory;
    protected $fillable=['title','body','user_id'];

    protected $appends = ['createdDate','excerpt','bodyHtml'];

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

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return Str::limit(strip_tags($this->bodyHtml()),$length);
    }
    
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getBodyHtmlAttribute()
    {
        return clean($this->bodyHtml());
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }
}
