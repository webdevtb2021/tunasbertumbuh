<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable=['name'];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
