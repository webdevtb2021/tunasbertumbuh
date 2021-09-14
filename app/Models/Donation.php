<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable=['category','bukti','jenis_barang_or_jumlah_bayar','notes','address','verification','donator_id'];

    public function donator()
    {
    	return $this->belongsTo(Donator::class);
    }

}
