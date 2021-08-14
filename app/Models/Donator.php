<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donator extends Model
{
    use HasFactory;

    protected $fillable=['name','phone','email','address'];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
