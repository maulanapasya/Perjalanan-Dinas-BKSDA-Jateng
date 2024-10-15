<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelaksanaDinas extends Model
{
    protected $table = 'Pelaksana_Dinas';
    protected $primaryKey = 'id_pegawai';
    public $timestamps = false;
    protected $fillable = [
        'id_dinas',
        'nama_pegawai',
        'status_pegawai',
        'no_telp',
        'nilai_dibayar'
    ];

    // relasi ke tabel pejalanan dinas (id_dinas sebagai foreign key)
    public function perjalananDinas()
    {
        return $this->belongsTo(PerjalananDinas::class, 'id_dinas');
    }

    // menghapus "." pada inputan nilai_dibayar karena di database tidak support tipe data nominal rupiah
    public function setNilaiDibayarAttribute($value)
    {
        $this->attributes['nilai_dibayar'] = floatval(str_replace('.', '', $value));
    }
}