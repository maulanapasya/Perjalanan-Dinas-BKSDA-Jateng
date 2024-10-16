@extends('headerMain')
<head>
    <title>Form Input Perjalanan Dinas</title>
</head>

@section('formInputDinas')
    <link href="{{ asset('css/formInputDinas.css') }}" rel="stylesheet">
    <script src="<?php echo asset('js/formInputDinas.js') ?>"></script>
    <div class="container" id="formContainer">
        <div class="card shadow-sm">
            <div class="card-header text-center bg-light" id="formInputHeader">
                <h5>Form Input Rincian Biaya Perjalanan Dinas<h5>
            </div>
            <div class="card-body">
                <form name="daftar" method="POST" action="{{ route('perjalanan-dinas.store') }}">
                    @csrf
                    {{-- Debug --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="kodeSatker">Kode Satker</label>
                        <input type="text" name="kodeSatker" id="kodeSatker" class="form-control" data-error-id="error_kodeSatker" value="{{ old('kodeSatker') }}" data-error="{{ $error_kodeSatker ?? '' }}">
                        <div id="error_kodeSatker" style="color: red;">
                            @if ($errors->has('kodeSatker')) {{ $errors->first('kodeSatker') }} @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="MAK">MAK</label>
                        <input type="text" name="MAK" id="MAK" class="form-control" data-error-id="error_MAK" value="{{ old('MAK') }}"  data-error="{{ $error_MAK ?? '' }}">
                        <div id="error_MAK" style="color: red;">
                            @if ($errors->has('MAK')) {{ $errors->first('MAK') }} @endif
                        </div>
                    </div>

                    <div id="pelaksana-container">
                        <h5 id="pelaksana-title">Pelaksana Perjalanan Dinas</h5>
                        <table id="pelaksana-table" class="table">
                            <thead>
                                <tr>
                                    <th>Nama Pelaksana</th>
                                    <th>Nomor Telepon Pelaksana</th>
                                    <th>Nilai yang Dibayarkan</th>
                                    <th>Status Pegawai Pelaksana</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="pelaksana-body">
                                <!-- Tempat mengisi nama pelaksana -->
                            </tbody>
                        </table>
                        <div id="pelaksana-instruction" style="display:none;">
                                <p>Silahkan isi form di bawah dan pilih "+ Tambah" untuk menambahkan pelaksana perjalanan dinas yang berpartisipasi.</p>
                        </div>

                        <div id="pelaksana-box" class ="pelaksana-box form">
                            <div class="single-pelaksana">
                                {{-- <label for="namaPelaksana">Nama Pelaksana</label> --}}
                                <label for="pelaksana[nama_pegawai][]">Nama Pelaksana</label>
                                <input type="text" name="pelaksana[nama_pegawai][]" id="namaPelaksana" class="form-control" value="{{ $errors->first('pelaksana.nama_pegawai') }}" data-error-id="error_namaPelaksana" data-error="{{ $error_namaPelaksana ?? '' }}">
                                <div id="error_namaPelaksana" style="color: red;"></div>

                                {{-- <label for="telponPelaksana">Nomor Telepon Pelaksana</label> --}}
                                <label for="pelaksana[no_telp][]">Nomor Telepon Pelaksana</label>
                                <input type="text" name="pelaksana[no_telp][]" id="telponPelaksana" class="form-control" value="{{ $errors->first('pelaksana.no_telp') }}" data-error-id="error_telponPelaksana" data-error="{{ $error_telponPelaksana ?? '' }}">
                                <div id="error_telponPelaksana" style="color: red;"></div>
                            
                                <label for="pelaksana[nilai_dibayar][]">Nilai yang Dibayarkan</label>
                                <input type="text" name="pelaksana[nilai_dibayar][]" id="nilaiDibayar" placeholder="Jika tidak ada yang dibayarkan, isikan &quot;0&quot;" class="form-control" value="{{ $errors->first('pelaksana.nilai_dibayar') }}" data-error-id="error_nilaiDibayar" data-error="{{ $error_nilaiDibayar ?? '' }}">
                                <div id="error_nilaiDibayar" style="color: red;"></div>

                                <label for="pelaksana[status_pegawai][]">Status Pegawai Pelaksana</label>
                                <input type="text" name="pelaksana[status_pegawai][]" id="statusPegawaiPelaksana" class="form-control" value="{{ $errors->first('pelaksana.status_pegawai') }}" data-error-id="error_statusPegawaiPelaksana" data-error="{{ $error_statusPegawaiPelaksana ?? '' }}">
                                <div id="error_statusPegawaiPelaksana" style="color: red;"></div>
                            </div>
                        </div>
                        
                    </div>

                    <button type="button" class="btn btn-primary" id="tambahBtn">+ Tambah</button>
                    
                    <div class="form-group">
                        <label for="nomorSP2D">Nomor SP2D</label>
                        <input type="text" name="nomorSP2D" id="nomorSP2D" class="form-control" value="{{ old('nomorSP2D') }}" data-error-id="error_nomorSP2D" data-error="{{ $error_nomorSP2D ?? '' }}">
                        <span id="inputErrorNomorSP2D" style="color: red;"></span>
                        <div id="error_nomorSP2D" style="color: red;">
                            @if ($errors->has('nomorSP2D')) {{ $errors->first('nomorSP2D') }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="program">Kode Program</label>
                        <input type="text" name="program" id="program" pattern="[a-zA-Z0-9]{3}\.[a-zA-Z0-9]{2}\.[a-zA-Z0-9]{2}" placeholder="___.__.__" title="XXX.XX.XX" class="form-control" value="{{ old('program') }}" data-error-id="error_program" data-error="{{ $error_program ?? '' }}">
                        <span id="inputErrorProgram" style="color: red;"></span>
                        <div id="error_program" style="color: red;">
                            @if ($errors->has('program')) {{ $errors->first('program') }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="kegiatan">Kode Kegiatan</label>
                        <input type="text" name="kegiatan" id="kegiatan" pattern="\d{4}\.\d{2}\" class="form-control" placeholder="____.___" title="XXXX.XXX" value="{{ old('kegiatan') }}" data-error-id="error_kegiatan" data-error="{{ $error_kegiatan ?? '' }}">
                        <div id="inputErrorKegiatan" style="color: red;"></div>
                        <div id="error_kegiatan" style="color: red;">
                            @if ($errors->has('kegiatan')) {{ $errors->first('kegiatan') }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nomorSuratTugas">Nomor Surat Tugas</label>
                        <div id="nomorSuratTugas-format">
                            <input type="text" name="nomorSuratTugas" id="nomorSuratTugas" class="form-control" value="{{ old('nomorSuratTugas') }}" data-error-id="error_nomorSuratTugas" data-error="{{ $error_nomorSuratTugas ?? '' }}">
                        </div>
                            <div id="error_nomorSuratTugas" style="color: red;">
                            @if ($errors->has('nomorSuratTugas')) {{ $errors->first('nomorSuratTugas') }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggalSuratTugas">Tanggal Surat Tugas</label>
                        <input type="date" name="tanggalSuratTugas" id="tanggalSuratTugas" class="form-control" value="{{ old('tanggalSuratTugas') }}" data-error-id="error_tanggalSuratTugas" data-error="{{ $error_tanggalSuratTugas ?? '' }}">
                        <div id="error_tanggalSuratTugas" style="color: red;">
                            @if ($errors->has('tanggalSuratTugas')) {{ $errors->first('tanggalSuratTugas') }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggalMulaiDinas">Tanggal Mulai Dinas</label>
                        <input type="date" name="tanggalMulaiDinas" id="tanggalMulaiDinas" class="form-control" value="{{ old('tanggalMulaiDinas') }}" data-error-id="error_tanggalMulaiDinas" data-error="{{ $error_tanggalMulaiDinas ?? '' }}">
                        <div id="error_tanggalMulaiDinas" style="color: red;">
                            @if ($errors->has('tanggalMulaiDinas')) {{ $errors->first('tanggalMulaiDinas') }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tanggalSelesaiDinas">Tanggal Selesai Dinas</label>
                        <input type="date" name="tanggalSelesaiDinas" id="tanggalSelesaiDinas" class="form-control" value="{{ old('tanggalSelesaiDinas') }}" data-error-id="error_tanggalSelesaiDinas" data-error="{{ $error_tanggalSelesaiDinas ?? '' }}">
                        <div id="error_tanggalSelesaiDinas" style="color: red;">
                            @if ($errors->has('tanggalSelesaiDinas')) {{ $errors->first('tanggalSelesaiDinas') }} @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <textarea name="tujuan" id="tujuan" rows="3" class="form-control" value="{{ old('tujuan') }}" data-error-id="error_tujuan" data-error="{{ $error_tujuan ?? '' }}"></textarea>
                        <div id="error_tujuan" style="color: red;">
                            @if ($errors->has('tujuan')) {{ $errors->first('tujuan') }} @endif
                        </div>
                    </div>

                    <button id ="submit" type="submit" name="submit" value="submit" class="btn btn-primary container-fluid">Input Perjalanan Dinas</button>
                
                </form>
            </div>
        </div>


