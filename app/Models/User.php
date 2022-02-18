<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permission',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAttribute()
    {
        if (!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAttribute()
    {
        if (!is_null($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }

    public function positions()
    {
        return $this->hasMany(Position::class,'user_id','id')->with('division:id,name','periode:id,name','jabatan:id,name','leader:id,name')->orderBy('id', 'DESC');
    }

    public function latestPositions()
    {
        return $this->hasOne(Position::class)->with('division:id,name','periode:id,name','jabatan:id,name')->orderBy('periode_id', 'DESC');
    }

    public function managers()
    {
        return $this->hasMany(Position::class, 'manager_id');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function dependences()
    {
        return $this->hasMany(Dependence::class);
    }

    public function latestDependences()
    {
        return $this->hasOne(Dependence::class)->orderBy('created_at', 'DESC');
    }
}
