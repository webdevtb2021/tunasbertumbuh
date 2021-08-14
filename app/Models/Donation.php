<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable=['category','bukti','notes_money','notes_barang','address_donation','verification'];

    public function donator()
    {
    	return $this->belongsTo(Donator::class);
    }

}
