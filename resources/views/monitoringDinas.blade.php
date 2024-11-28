{{-- @include('headerMain') --}}
{{-- <head>
    <title>Daftar Perjalanan Dinas</title>
</head> --}}

@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.8/umd/popper.min.js"></script>
<link href="{{ asset('css/monitoringDinas.css') }}" rel="stylesheet">
<script src="{{ asset('js/monitoringDinas.js') }}"></script>

<body>
    <div class="container card monitoring-Dinas">
        {{-- <div class="card-header" id="monitoringHeader">Daftar Rincian Perjalanan Dinas</div> --}}
        <div class="card-body">

            <div class="header-container">
                <h2 class="text-center" id="monitoringHeader">Daftar Rincian Perjalanan Dinas</h2>
                <div id="filterSection">
                    <div class="button-group">
                        <button class="btn btn-light">Ekspor ke .xlsx</button>
                        {{-- <button class="btn btn-light">Sudah Terlaksana</button>
                        <button class="btn btn-light">Belum Terlaksana</button>
                        <button class="btn btn-light">30 hari terakhir</button>
                        <button class="btn btn-light">60 hari terakhir</button> --}}
                    </div>
                    <div class="search-group">
                        <label for="search-box" class="search-label">Cari berdasarkan:</label>
                        <input type="text" id="search-box" class="search-box" placeholder="Kode Satker / MAK / Nomor SP2D / Program / Kegiatan / Nomor Surat Tugas / Tujuan" data-route="{{ route('monitoringDinas.search') }}">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="monitoringTable" class="table">
                    <thead>
                        <tr>
                            <th class="col-1">No.</th>
                            <th class="col-2">Kode Satker</th>
                            <th class="col-2">MAK</th>
                            <th class="col-2">Nomor SP2D</th>
                            <th class="col-2">Program</th>
                            <th class="col-2">Kegiatan</th>
                            <th class="col-3">Nomor Surat Tugas</th>
                            <th class="col-2">Tanggal Surat Tugas</th>
                            <th class="col-2">Tanggal Mulai Dinas</th>
                            <th class="col-2">Tanggal Selesai Dinas</th>
                            <th class="col-3">Tujuan</th>
                            <th class="col-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="monitoringBody">
                        {{-- isi tabel dari database --}}
                        @foreach ($perjalananDinas as $index => $pd)
                            <tr>
                                <td>{{ ($perjalananDinas->currentPage() - 1) * $perjalananDinas->perPage() + $index + 1 }}</td>
                                <td>{{ $pd->satuanKerja->kode_satker}}</td>
                                <td>{{ $pd->MAK->kode_mak}}</td>
                                <td>{{ $pd->nomor_sp2d }}</td>
                                <td>{{ $pd->kegiatan->program->kode_program }}</td>
                                <td>{{ $pd->kegiatan->kode_kegiatan }}</td>
                                <td>{{ $pd->nomor_surat_tugas}}</td>
                                <td>{{ \Carbon\Carbon::parse($pd->tanggal_surat_tugas)->translatedFormat('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pd->tanggal_mulai_dinas)->translatedFormat('d F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($pd->tanggal_selesai_dinas)->translatedFormat('d F Y') }}</td>
                                <td class="text-justify">{{ $pd->tujuan_dinas }}</td>
                                <td>
                                    <button class="btn btn-primary btn-action detail-btn" data-id="{{ $pd->id_dinas }}">Detail</button>
                                    <button class="btn btn-warning btn-action edit-btn" data-id="{{ $pd->id_dinas }}">Ubah</button>
                                    <form id="deleteForm" action="{{ route('perjalanan-dinas.destroy', $pd->id_dinas) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action delete-button" data-id="{{ $pd->id_dinas }}">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pagination-links" class="d-flex justify-content-center mt-3">
                    {{-- {{ $perjalananDinas->links() }} --}}
                </div>   
            </div>         
        </div>
    </div>

    {{-- modal untuk detail perjalanan dinas --}}
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="detailModalLabel">Detail Perjalanan Dinas</h5>
                    <button type="button" class="close position-absolute" style="right: 1em;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- isi modal dari database --}}
                </div>
            </div>
        </div>
    </div>

    {{-- modal untuk edit perjalanan dinas --}}
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="editModalLabel">Edit Perjalanan Dinas</h5>
                    <button type="button" class="close position-absolute" style="right: 1em;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="kodeSatker">Kode Satker</label>
                            <input type="text" class="form-control" id="kodeSatker" name="kodeSatker" required>
                        </div>
                        <div class="form-group">
                            <label for="MAK">MAK</label>
                            <input type="text" class="form-control" id="MAK" name="MAK" required>
                        </div>
                        <div class="form-group">
                            <label for="program">Program</label>
                            <input type="text" class="form-control" id="program" name="program" required>
                        </div>
                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <input type="text" class="form-control" id="kegiatan" name="kegiatan" required>
                        </div>
                        <div class="form-group">
                            <label for="nomorSuratTugas">Nomor Surat Tugas</label>
                            <input type="text" class="form-control" id="nomorSuratTugas" name="nomorSuratTugas" required>
                        </div>
                        <div class="form-group">
                            <label for="nomorSP2D">Nomor SP2D</label>
                            <input type="text" class="form-control" id="nomorSP2D" name="nomorSP2D" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggalSuratTugas">Tanggal Surat Tugas</label>
                            <input type="date" class="form-control" id="tanggalSuratTugas" name="tanggalSuratTugas" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggalMulaiDinas">Tanggal Mulai Dinas</label>
                            <input type="date" class="form-control" id="tanggalMulaiDinas" name="tanggalMulaiDinas" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggalSelesaiDinas">Tanggal Selesai Dinas</label>
                            <input type="date" class="form-control" id="tanggalSelesaiDinas" name="tanggalSelesaiDinas" required>
                        </div>
                        <div class="form-group">
                            <label for="tujuan">Tujuan</label>
                            <textarea class="form-control" id="tujuan" name="tujuan" required></textarea>
                        </div>
                        <div id="pelaksanaContainer">
                            <!-- Pelaksana fields will be dynamically added here -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- modal untuk konfirmasi batal edit --}}
    <div class="modal fade" id="confirmCancelModal" tabindex="-1" role="dialog" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCancelModalLabel">Batalkan Perubahan?</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <button class="btn btn-primary" id="confirmCancel">Ya</button>
                    <button class="btn btn-danger" data-dismiss="modal">Tidak</button>
                </div>
            </div>
        </div>
    </div>
    
</body>

@endsection