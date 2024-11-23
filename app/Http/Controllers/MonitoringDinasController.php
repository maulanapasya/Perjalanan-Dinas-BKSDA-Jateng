<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerjalananDinas;
use App\Models\MAK;
use App\Models\Kegiatan;
use App\Models\SatuanKerja;

class monitoringDinasController extends Controller {
    public function index(Request $request)
    {
        $entriesPerPage = $request->input('entries', 10);
        $perjalananDinas = PerjalananDinas::with(['pelaksanaDinas','kegiatan','kegiatan.program','satuanKerja','MAK'])->paginate($entriesPerPage);
        return view('monitoringDinas', compact('perjalananDinas'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $result = PerjalananDinas::with(['satuanKerja', 'MAK', 'kegiatan.program'])
            ->whereHas('satuanKerja', function ($q) use ($query) {
                $q->where('kode_satker', 'like', '%' . $query . '%');
            })
            ->orWhereHas('MAK', function ($q) use ($query) {
                $q->where('kode_mak', 'like', '%' . $query . '%');
            })
            ->orWhereHas('kegiatan', function ($q) use ($query) {
                $q->where('kode_kegiatan', 'like', '%' . $query . '%')
                ->orWhereHas('program', function ($q2) use ($query) {
                    $q2->where('kode_program', 'like', '%' . $query . '%');
                });
            })
            ->orWhere('nomor_sp2d', 'like', '%' . $query . '%')
            ->orWhere('nomor_surat_tugas', 'like', '%' . $query . '%')
            ->orWhere('tujuan_dinas', 'like', '%' . $query . '%')
            ->get();

        return response()->json($result);
    }

    // public function search(Request $request)
    // {
    //     $query = $request->input('query');

    //     $results = PerjalananDinas::where('kode_satker', 'LIKE', "%{$query}%")
    //         ->orWhere('kode_mak', 'LIKE', "%{$query}%")
    //         ->orWhere('nomor_sp2d', 'LIKE', "%{$query}%")
    //         ->orWhere('program', 'LIKE', "%{$query}%")
    //         ->orWhere('kegiatan', 'LIKE', "%{$query}%")
    //         ->orWhere('nomor_surat_tugas', 'LIKE', "%{$query}%")
    //         ->orWhere('tujuan', 'LIKE', "%{$query}%")
    //         ->get();

    //     return response()->json($results);
    // }
}