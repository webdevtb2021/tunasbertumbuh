<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable=['count','notes','datetime', 'jabatan_id','division_id','periode_id'];

    public function division()
    {
    	return $this->belongsTo(Division::class);
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }  

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}
