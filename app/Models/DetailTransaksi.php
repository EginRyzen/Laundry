<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksi extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_transaksi',
        'id_paket',
        'qty',
        'keterangan',
    ];


    // public function transaksi()
    // {
    //     return $this->belongsTo(Transaksi::class, 'id_transaksi');
    // }

    // public function paket()
    // {
    //     return $this->belongsTo(Paket::class, 'id_paket');
    // }
}
