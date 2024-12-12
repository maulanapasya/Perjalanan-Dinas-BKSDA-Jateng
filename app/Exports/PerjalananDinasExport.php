<?php

namespace App\Exports;

use App\Models\PerjalananDinas;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    WithCustomStartCell
};
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PerjalananDinasExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    public function collection()
    {
        $data = [];
        $perjalananDinas = PerjalananDinas::with(['satuanKerja', 'MAK', 'kegiatan.program', 'pelaksanaDinas'])->get();

        $index = 1;
        foreach ($perjalananDinas as $perjalanan) {
            $pelaksanaList = $perjalanan->pelaksanaDinas;
            $firstEntry = true;

            foreach ($pelaksanaList as $pelaksana) {
                $row = [
                    'No' => $firstEntry ? $index : '',
                    'Kode Satker' => $perjalanan->satuanKerja->kode_satker ?? '',
                    'Kode MAK' => $perjalanan->MAK->kode_mak ?? '',
                    'Nomor SP2D' => $perjalanan->nomor_sp2d ?? '',
                    'Program' => $perjalanan->kegiatan->program->kode_program ?? '',
                    'Kegiatan' => $perjalanan->kegiatan->kode_kegiatan ?? '',
                    'Nomor Surat Tugas' => $perjalanan->nomor_surat_tugas ?? '',
                    'Tanggal Surat Tugas' => $perjalanan->tanggal_surat_tugas ? Carbon::parse($perjalanan->tanggal_surat_tugas)->locale('id')->translatedFormat('j F Y') : '',
                    'Tanggal Mulai Dinas' => $perjalanan->tanggal_mulai_dinas ? Carbon::parse($perjalanan->tanggal_mulai_dinas)->locale('id')->translatedFormat('j F Y') : '',
                    'Tanggal Selesai Dinas' => $perjalanan->tanggal_selesai_dinas ? Carbon::parse($perjalanan->tanggal_selesai_dinas)->locale('id')->translatedFormat('j F Y') : '',
                    'Tujuan Dinas' => $perjalanan->tujuan_dinas ?? '',
                    'Nama Pelaksana' => $pelaksana->nama_pegawai ?? '',
                    'Status Pegawai' => $pelaksana->status_pegawai ?? '',
                    'No. Telp Pelaksana' => $pelaksana->no_telp ?? '',
                    'Nilai yang Dibayar' => $pelaksana->nilai_dibayar ?? 0,
                ];

                $data[] = $row;
                $firstEntry = false;
            }

            $index++;
        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Satker',
            'Kode MAK',
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

    // Memulai data dari sel A3
    public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $lastColumn = 'O'; // Sesuaikan dengan kolom terakhir
                $highestRow = $event->sheet->getHighestRow(); // Baris terakhir dengan data

                // Menulis judul di A1 dan menggabungkannya
                $event->sheet->setCellValue('A1', 'Rincian Biaya Perjalanan Dinas Dalam Negeri');
                $event->sheet->mergeCells("A1:{$lastColumn}1");
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

                // Membuat header kolom menjadi bold di baris ke-3
                $event->sheet->getStyle("A3:{$lastColumn}3")->getFont()->setBold(true);

                // Mengatur border mulai dari baris ke-3 hingga data terakhir
                $event->sheet->getStyle("A3:{$lastColumn}{$highestRow}")
                    ->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => ['argb' => 'FF000000'],
                            ],
                        ],
                    ]);

                // Mengatur alignment teks
                $event->sheet->getStyle("A3:{$lastColumn}{$highestRow}")
                    ->getAlignment()->setHorizontal('center')->setVertical('center');

                // Memformat kolom 'Nilai yang Dibayar' sebagai rupiah dengan titik pemisah ribuan
                $event->sheet->getStyle("O4:O{$highestRow}")
                    ->getNumberFormat()
                    ->setFormatCode('#,##0');

                // Menghilangkan border pada baris ke-2
                $event->sheet->getStyle("A2:{$lastColumn}2")->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_NONE,
                        ],
                    ],
                ]);

                // Mengatur lebar kolom otomatis
                foreach (range('A', $lastColumn) as $column) {
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}