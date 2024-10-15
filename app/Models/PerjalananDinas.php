<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PerjalananDinas extends Model
{
    protected $table = 'Perjalanan_Dinas';
    protected $primaryKey = 'id_dinas';
    protected $fillable = [
        'id_kegiatan',
        'id_satker',
        'nomor_surat_tugas',
        'nomor_sp2d',
        'tanggal_surat_tugas',
        'tanggal_mulai_dinas',
        'tanggal_selesai_dinas',
        'tujuan_dinas'
    ];

    // relasi ke tabel pelaksana dinas (id_dinas sebagai foreign key)
    public function pelaksanaDinas()
    {
        return $this->hasMany(PelaksanaDinas::class, 'id_dinas');
    }

    // relasi ke tabel kegiatan (id_kegiatan dan id_satker sebagai foreign key)
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'id_kegiatan');
    }

    // relasi ke tabel satker (id_satker sebagai foreign key)
    public function satuanKerja()
    {
        return $this->belongsTo(SatuanKerja::class, 'id_satker');
    }

    // relasi ke tabel MAK (id_dinas sebagai foreign key)
    public function MAK()
    {
        return $this->hasOne(MAK::class, 'id_dinas'); // sementara dibuat hasOne, bisa diubah jadi hasMany jika dibutuhkan
    }
}