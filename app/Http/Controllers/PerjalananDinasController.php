<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use App\Models\SatuanKerja;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\PerjalananDinas;
use App\Models\PelaksanaDinas;
use App\Models\PerjalananDinasExport;
use App\Models\MAK;
use Exception;


class PerjalananDinasController extends Controller
{
    public function store(Request $request)
    {
        $messages = [
            'kodeSatker.required' => 'Kode Satker harus diisi.',
            'MAK.required' => 'MAK harus diisi.',
            'nomorSuratTugas.required' => 'Nomor Surat Tugas harus diisi.',
            'nomorSP2D.required' => 'Nomor SP2D harus diisi.',
            'program.required' => 'Program harus diisi.',
            'kegiatan.required' => 'Kegiatan harus diisi.',
            'tanggalSuratTugas.required' => 'Tanggal Surat Tugas harus diisi.',
            'tanggalMulaiDinas.required' => 'Tanggal Mulai Dinas harus diisi.',
            'tanggalMulaiDinas.before_or_equal' => 'Tanggal Mulai Dinas harus sebelum atau sama dengan Tanggal Selesai Dinas.',
            'tanggalSelesaiDinas.required' => 'Tanggal Selesai Dinas harus diisi.',
            'tanggalSelesaiDinas.after_or_equal' => 'Tanggal Selesai Dinas harus setelah atau sama dengan Tanggal Mulai Dinas.',
            'tujuan.required' => 'Tujuan harus diisi.',
            'pelaksana.required' => 'Data Pelaksana setidaknya terdiri dari minimal 1 pelaksana.',
            'pelaksana.*.nama_pegawai.required' => 'Pelaksana harus diisi.',
            'pelaksana.*.status_pegawai.required' => 'Status Pegawai harus diisi.',
            'pelaksana.*.no_telp.required' => 'Nomor Telepon harus diisi.',
            'pelaksana.*.nilai_dibayar.required' => 'Nilai Dibayar harus diisi.',
        ];

        // Memfilter entri pelaksana yang tidak lengkap
        if ($request->has('pelaksana')) {
            $pelaksana = array_filter($request->input('pelaksana'), function ($pelaksanaEntry) {
                // Cek apakah semua field yang diperlukan telah diisi
                return !empty($pelaksanaEntry['nama_pegawai']) &&
                    !empty($pelaksanaEntry['status_pegawai']) &&
                    !empty($pelaksanaEntry['no_telp']) &&
                    !empty($pelaksanaEntry['nilai_dibayar']);
            });

            // Mengganti input 'pelaksana' dengan data yang sudah difilter
            $request->merge(['pelaksana' => $pelaksana]);
        }

        //validasi input
        $validated = $request->validate([
            'kodeSatker' => 'required|string',
            'MAK' => 'required|string',
            'nomorSuratTugas' => 'required|string',
            'nomorSP2D' => 'required|string',
            'program' => 'required|string',
            'kegiatan' => 'required|string',
            'tanggalSuratTugas' => 'required|date',
            'tanggalMulaiDinas' => 'required|date|before_or_equal:tanggalSelesaiDinas',
            'tanggalSelesaiDinas' => 'required|date|after_or_equal:tanggalMulaiDinas',
            'tujuan' => 'required|string',
            'pelaksana' => 'required|array|min:1',
            'pelaksana.*.nama_pegawai' => 'required|string',
            'pelaksana.*.status_pegawai' => 'required|string',
            'pelaksana.*.no_telp' => 'required|string',
            'pelaksana.*.nilai_dibayar' => 'required|string'
        ], $messages);

        DB::beginTransaction();
        try {
            // input untuk tabel program
            $program = Program::create([
                'kode_program' => $validated['program']
            ]);

            // mendapatkan id program berdasarkan program yang diinputkan
            $idProgram = $program->id_program;

            // input untuk tabel kegiatan
            $kegiatan = Kegiatan::create([
                'id_program' => $idProgram,
                'kode_kegiatan' => $validated['kegiatan'],
            ]);

            // mendapatkan id kegiatan berdasarkan kegiatan yang diinputkan
            $idKegiatan = $kegiatan->id_kegiatan;

            // input untuk tabel satuan kerja
            $satuanKerja = SatuanKerja::create([
                'kode_satker' => $validated['kodeSatker']
            ]);

            // mendapatkan id satker berdasarkan kode satker yang diinputkan
            $idSatker = $satuanKerja->id_satker;

            // simpan data perjalanan dinas
            $perjalananDinas = PerjalananDinas::create([
                'id_kegiatan' => $idKegiatan,
                'id_satker' => $idSatker,
                'nomor_surat_tugas' => $validated['nomorSuratTugas'],
                'nomor_sp2d' => $validated['nomorSP2D'],
                'tanggal_surat_tugas' => $validated['tanggalSuratTugas'],
                'tanggal_mulai_dinas' => $validated['tanggalMulaiDinas'],
                'tanggal_selesai_dinas' => $validated['tanggalSelesaiDinas'],
                'tujuan_dinas' => $validated['tujuan'],
            ]);

            // simpan data pelaksana dinas
            foreach ($validated['pelaksana'] as $pelaksana) {
                PelaksanaDinas::create([
                    'id_dinas' => $perjalananDinas->id_dinas,
                    'nama_pegawai' => $pelaksana['nama_pegawai'],
                    'status_pegawai' => $pelaksana['status_pegawai'],
                    'no_telp' => $pelaksana['no_telp'],
                    'nilai_dibayar' => $pelaksana['nilai_dibayar'],
                ]);
            }

            // input untuk tabel tabel MAK
            MAK::create([
                'id_dinas' => $perjalananDinas->id_dinas,
                'kode_mak' => $validated['MAK']
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data Perjalanan Dinas berhasil disimpan');
        } catch (Exception $e){
            Log::error('Error storing data: '.$e->getMessage());
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // method untuk menampilkan detail perjalanan dinas
    public function show($id)
    {
        $perjalananDinas = PerjalananDinas::with('pelaksanaDinas','kegiatan.program','satuanKerja','MAK')->findOrFail($id);
        // dd($perjalananDinas);
        // return view('show', compact('perjalananDinas'));
        // return "<p>Testing data: " . $perjalananDinas->id_dinas . "</p>";
        return response()->json($perjalananDinas);
    }

    // method untuk menampilkan form edit perjalanan dinas
    public function edit($id)
    {
        try {
            // Log::info('ID received in edit method: '.$id); // debug
            $perjalananDinas = PerjalananDinas::with('pelaksanaDinas','kegiatan.program','satuanKerja','MAK')->findOrFail($id);
            // $perjalananDinas = PerjalananDinas::findOrFail($id);
            // dd($perjalananDinas); // debug
            Log::info('Data found: '.$perjalananDinas);
            return response()->json($perjalananDinas);
        } catch (Exception $e) {
            Log::error('Error in edit method: '.$e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 404);
        }
    }

    // method untuk menyimpan perjalanan dinas yang di-edit
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kodeSatker' => 'required|string',
            'MAK' => 'required|string',
            'program' => 'required|string',
            'kegiatan' => 'required|string',
            'nomorSuratTugas' => 'required|string',
            'nomorSP2D' => 'required|string',
            'tanggalSuratTugas' => 'required|date',
            'tanggalMulaiDinas' => 'required|date',
            'tanggalSelesaiDinas' => 'required|date',
            'tujuan' => 'required|string',
            'pelaksana' => 'required|array',
            'pelaksana.*.id' => 'required|integer|exists:pelaksana_dinas,id_pegawai',
            'pelaksana.*.nama_pegawai' => 'required|string',
            'pelaksana.*.status_pegawai' => 'required|string',
            'pelaksana.*.no_telp' => 'required|string',
            'pelaksana.*.nilai_dibayar' => 'required|string'
        ]);

        try {
            Log::info('Data received in update method: ' . print_r($validated, true));
            DB::beginTransaction();

            // Mencari data perjalanan dinas berdasarkan ID
            $perjalananDinas = PerjalananDinas::findOrFail($id);

            // update data perjalanan dinas
            $perjalananDinas->update([
                'nomor_surat_tugas' => $validated['nomorSuratTugas'],
                'nomor_sp2d' => $validated['nomorSP2D'],
                'tanggal_surat_tugas' => $validated['tanggalSuratTugas'],
                'tanggal_mulai_dinas' => $validated['tanggalMulaiDinas'],
                'tanggal_selesai_dinas' => $validated['tanggalSelesaiDinas'],
                'tujuan_dinas' => $validated['tujuan']
            ]);

            // update program
            $program = Program::where('id_program', $perjalananDinas->kegiatan->id_program)->firstOrFail();
            $program->update(['kode_program' => $validated['program']]);

            // update kegiatan
            $kegiatan = Kegiatan::where('id_kegiatan', $perjalananDinas->id_kegiatan)->firstOrFail();
            $kegiatan->update([
                'id_program' => $program->id_program,
                'kode_kegiatan' => $validated['kegiatan']
            ]);

            // update satuan kerja
            $satuanKerja = SatuanKerja::where('id_satker', $perjalananDinas->id_satker)->firstOrFail();
            $satuanKerja->update(['kode_satker' => $validated['kodeSatker']]);

            // update relasi perjalanan dinas
            $perjalananDinas->update([
                'id_kegiatan' => $kegiatan->id_kegiatan,
                'id_satker' => $satuanKerja->id_satker
            ]);

            foreach ($validated['pelaksana'] as $pelaksana) {
                if (isset($pelaksana['id'])) {
                    $existingPelaksana = PelaksanaDinas::findOrFail($pelaksana['id']);
                    $existingPelaksana->update([
                        'nama_pegawai' => $pelaksana['nama_pegawai'],
                        'status_pegawai' => $pelaksana['status_pegawai'],
                        'no_telp' => $pelaksana['no_telp'],
                        'nilai_dibayar' => $pelaksana['nilai_dibayar']
                    ]);
                }
            }

            // update data MAK
            $mak = MAK::where('id_dinas', $perjalananDinas->id_dinas)->firstOrFail();
            $mak->update(['kode_mak' => $validated['MAK']]);

            // // Log berhasil menyimpan data
            // Log::info('Data updated successfully for ID: '.$id);

            DB::commit();

            return response()->json(['message' => 'Data Perjalanan Dinas berhasil diubah']);
        } catch (Exception $e) {
            DB::rollback();
            // Log error
            Log::error('Error in update method: '.$e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    // method untuk menghapus data perjalanan dinas
    public function destroy($id)
    {
        try {
            $perjalananDinas = PerjalananDinas::findOrFail($id);

            // Mencari data perjalanan dinas berdasarkan ID
            $perjalananDinas = PerjalananDinas::with(['pelaksanaDinas','MAK'])->findOrFail($id);

            // Menghapus data yang berelasi dengan tabel perjalanan dinas
            $perjalananDinas->pelaksanaDinas()->delete();
            $perjalananDinas->MAK()->delete();

            // Menghapus perjalanan dinas setelah relasinya dibersihkan
            $perjalananDinas->delete();

            // redirect ke halaman daftar perjalanan dinas dengan pesan sukses
            return redirect()->route('perjalanan-dinas.index')->with('success', 'Data Perjalanan Dinas berhasil dihapus');
        } catch (Exception $e) {
            // handle error
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}