<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependence extends Model
{
    use HasFactory;

    protected $fillable=['phone','testimony','instagram','facebook','twitter','url_image'];
    protected $primaryKey = "user_id"; // anggap user id menjadi primary key, karena beberapa fungsi kyk updateOrCreate gk bisa jalan tanpa adanya primary key
    protected $appends=["createdDate"];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function getCreatedDateAttribute()
    {
        // return $this->created_at->diffForHumans();
        return Carbon::parse($this->created_at)->format('Y-m-d H:i:s');
    }
}
