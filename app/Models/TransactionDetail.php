<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable=['count','total'];

    public function merchandise()
    {
    	return $this->belongsTo(Merchandise::class);
    }

    public function transaction()
    {
    	return $this->belongsTo(Transaction::class);
    }
}
