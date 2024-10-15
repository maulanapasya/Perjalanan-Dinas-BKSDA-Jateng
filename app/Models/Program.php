<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'Program';
    protected $primaryKey = 'id_program';
    protected $fillable = ['kode_program'];
    public $timestamps = false;

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'id_program');
    }
}