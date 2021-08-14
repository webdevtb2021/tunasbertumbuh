<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable=['name','phone','email', 'address', 'ipk','education','biography','summary','application_id','scores','other_notes'];

    public function application()
    {
    	return $this->belongsTo(Application::class);
    }

}
