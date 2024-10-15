<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MAK extends Model
{
    protected $table = 'MAK';
    protected $primaryKey = 'id_mak';
    protected $fillable = ['id_dinas','kode_mak'];
    public $timestamps = false;
    // relasi ke tabel kegiatan (id_kegiatan sebagai foreign key)
    public function perjalananDinas()
    {
        return $this->belongsTo(PerjalananDinas::class, 'id_dinas');
    }
}