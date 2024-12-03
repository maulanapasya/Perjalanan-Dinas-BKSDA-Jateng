<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PerjalananDinasExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $exportData = [];

        foreach ($this->data as $item) {
            foreach ($item->pelaksanaDinas as $pelaksana) {
                // Format dates
                $tanggalSuratTugas = $item->tanggal_surat_tugas
                    ? Carbon::parse($item->tanggal_surat_tugas)->locale('id')->translatedFormat('j F Y')
                    : '';

                $tanggalMulaiDinas = $item->tanggal_mulai_dinas
                    ? Carbon::parse($item->tanggal_mulai_dinas)->locale('id')->translatedFormat('j F Y')
                    : '';

                $tanggalSelesaiDinas = $item->tanggal_selesai_dinas
                    ? Carbon::parse($item->tanggal_selesai_dinas)->locale('id')->translatedFormat('j F Y')
                    : '';

                $exportData[] = [
                    'Kode Satker' => $item->satuanKerja->kode_satker ?? '',
                    'MAK' => $item->MAK->kode_mak ?? '',
                    'Nomor SP2D' => $item->nomor_sp2d ?? '',
                    'Program' => $item->kegiatan->program->kode_program ?? '',
                    'Kegiatan' => $item->kegiatan->kode_kegiatan ?? '',
                    'Nomor Surat Tugas' => $item->nomor_surat_tugas ?? '',
                    'Tanggal Surat Tugas' => $tanggalSuratTugas,
                    'Tanggal Mulai Dinas' => $tanggalMulaiDinas,
                    'Tanggal Selesai Dinas' => $tanggalSelesaiDinas,
                    'Tujuan Dinas' => $item->tujuan_dinas ?? '',
                    'Nama Pelaksana' => $pelaksana->nama_pegawai ?? '',
                    'Status Pegawai' => $pelaksana->status_pegawai ?? '',
                    'No. Telp Pelaksana' => $pelaksana->no_telp ?? '',
                    'Nilai yang Dibayar' => $pelaksana->nilai_dibayar ?? '',
                ];
            }
        }

        return collect($exportData);
    }

    public function headings(): array
    {
        return [
            'Kode Satker',
            'MAK',
            'Nomor SP2D',
            'Program',
            'Kegiatan',
            'Nomor Surat Tugas',
            'Tanggal Surat Tugas',
            'Tanggal Mulai Dinas',
            'Tanggal Selesai Dinas',
            'Tujuan Dinas',
            'Nama Pelaksana',
            'Status Pegawai',
            'No. Telp Pelaksana',
            'Nilai yang Dibayar',
        ];
    }
}
