<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'Kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $fillable = ['kode_kegiatan','id_program'];
    public $timestamps = false;
    // relasi ke tabel program (id_program sebagai foreign key)
    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }
    public function perjalananDinas()
    {
        return $this->hasMany(PerjalananDinas::class, 'id_kegiatan');
    }
}