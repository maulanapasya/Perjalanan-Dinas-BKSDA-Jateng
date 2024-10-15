@include('headerMain')
<head>
    <title>Daftar Perjalanan Dinas</title>
</head>

<script src="{{ asset('js/monitoringDinas.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudfare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<link href="{{ asset('css/monitoringDinas.css') }}" rel="stylesheet">
<body>
    <div class="card">
        {{-- <div class="card-header" id="monitoringHeader">Daftar Rincian Perjalanan Dinas</div> --}}
        <div class="card-body">
            <h2 id="monitoringHeader">Daftar Rincian Perjalanan Dinas</h2>
            <table id="monitoringTable" class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Kode Satker</th>
                        <th>MAK</th>
                        <th>Nomor SP2D</th>
                        <th>Program</th>
                        <th>Kegiatan</th>
                        <th>Nomor Surat Tugas</th>
                        <th>Tanggal Surat Tugas</th>
                        <th>Tanggal Mulai Dinas</th>
                        <th>Tanggal Selesai Dinas</th>
                        <th>Tujuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="monitoringBody">
                    {{-- isi tabel dari database --}}
                    @foreach ($perjalananDinas as $pd)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pd->satuanKerja->kode_satker}}</td>
                            <td>{{ $pd->MAK->kode_mak}}</td>
                            <td>{{ $pd->nomor_sp2d }}</td>
                            <td>{{ $pd->kegiatan->program->kode_program }}</td>
                            <td>{{ $pd->kegiatan->kode_kegiatan }}</td>
                            <td>{{ $pd->nomor_surat_tugas}}</td>
                            <td>{{ $pd->tanggal_surat_tugas }}</td>
                            <td>{{ $pd->tanggal_mulai_dinas }}</td>
                            <td>{{ $pd->tanggal_selesai_dinas }}</td>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {{-- isi modal dari database --}}
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