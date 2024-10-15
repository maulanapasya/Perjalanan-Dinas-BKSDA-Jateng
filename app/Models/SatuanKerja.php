<?php  

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanKerja extends Model
{
    protected $table = 'Satuan_Kerja';
    protected $primaryKey = 'id_satker';
    protected $fillable = ['kode_satker'];
    public $timestamps = false;

    public function perjalananDinas()
    {
        return $this->hasMany(PerjalananDinas::class, 'id_satker');
    }
}