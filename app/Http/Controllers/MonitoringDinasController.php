<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerjalananDinas;
use App\Models\MAK;
use App\Models\Kegiatan;
use App\Models\SatuanKerja;

class monitoringDinasController extends Controller {
    public function index()
    {
        $perjalananDinas = PerjalananDinas::with(['pelaksanaDinas','kegiatan','kegiatan.program','satuanKerja','MAK'])->get();
        return view('monitoringDinas', compact('perjalananDinas'));
    }
}