<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable=['category','bukti','jenis_barang_or_jumlah_bayar','notes','address','verification','donator_id'];
    protected $appends = ['createdDate'];

    public function donator()
    {
    	return $this->belongsTo(Donator::class);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('d M Y H:i:s');
    }

}
