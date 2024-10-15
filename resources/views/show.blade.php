<table class="table table-bordered">
    <tr>
        <th>Kode Satker</th>
        <td>{{ $perjalananDinas->satuanKerja->kode_satker }}</td>
    </tr>
    <tr>
        <th>MAK</th>
        <td>{{ $perjalananDinas->MAK->kode_mak }}</td>
    </tr>
    <tr>
        <th>Nomor SP2D</th>
        <td>{{ $perjalananDinas->nomor_sp2d }}</td>
    </tr>
    <tr>
        <th>Program</th>
        <td>{{ $perjalananDinas->kegiatan->program->kode_program }}</td>
    </tr>
    <tr>
        <th>Kegiatan</th>
        <td>{{ $perjalananDinas->kegiatan->kode_kegiatan }}</td>
    </tr>
    <tr>
        <th>Nomor Surat Tugas</th>
        <td>{{ $perjalananDinas->nomor_surat_tugas }}</td>
    </tr>
    <tr>
        <th>Tanggal Surat Tugas</th>
        <td>{{ $perjalananDinas->tanggal_surat_tugas }}</td>
    </tr>
    <tr>
        <th>Tanggal Mulai Dinas</th>
        <td>{{ $perjalananDinas->tanggal_mulai_dinas }}</td>
    </tr>
    <tr>
        <th>Tanggal Selesai Dinas</th>
        <td>{{ $perjalananDinas->tanggal_selesai_dinas }}</td>
    </tr>
    <tr>
        <th>Tujuan</th>
        <td>{{ $perjalananDinas->tujuan_dinas }}</td>
    </tr>
    {{-- <tr>
        <th>Nama Pelaksana</th>
        <td>
            <ul>
                @foreach ($perjalananDinas->pelaksanaDinas as $pelaksana)
                    <li>{{ $pelaksana->nama_pegawai }} - {{ $pelaksana->status_pegawai }} - {{ $pelaksana->no_telp }} - Rp{{ number_format($pelaksana->nilai_dibayar, 0, ',',',') }}</li>
                @endforeach
            </ul>
        </td>
    </tr> --}}
</table>

<h5 class="text-center">Daftar Pelaksana</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Pelaksana</th>
            <th>No. Telp</th>
            <th>Status Pegawai</th>
            <th>Nilai Dibayar</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($perjalananDinas->pelaksanaDinas as $pelaksana)
            <tr>
                <td>{{ $pelaksana->nama_pegawai }}</td>
                <td>{{ $pelaksana->no_telp }}</td>
                <td>{{ $pelaksana->status_pegawai }}</td>
                <td>Rp{{ number_format($pelaksana->nilai_dibayar, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>