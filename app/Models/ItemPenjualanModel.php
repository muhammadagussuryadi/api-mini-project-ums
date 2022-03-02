<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPenjualanModel extends Model
{
    protected $table = 'tb_item_penjualan';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nota',
        'kode_barang',
        'qty',
    ];
}
