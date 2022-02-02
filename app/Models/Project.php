<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable=['title','body','image','user_id'];

    protected $appends = ['createdDate','excerpt','bodyHtml'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }

    public function excerpt($length)
    {
        return Str::limit(strip_tags($this->bodyHtml()),$length);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title']=$value;
    }
    
    public function getCreatedDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
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
