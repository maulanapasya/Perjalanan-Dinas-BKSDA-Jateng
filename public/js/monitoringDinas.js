/* JavaScript blade view monitoringDinas */

// untuk mengambil data perjalanan dinas berdasarkan ID
document.addEventListener("DOMContentLoaded", function() {
    // Tombol Detail
    document.querySelectorAll('.detail-btn').forEach(button => {
        button.addEventListener('click', function() {
            const idDinas = this.getAttribute('data-id');
            fetch(`/perjalanan-dinas/${idDinas}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json(); // Mengubah respons menjadi JSON
                })
                .then(data => {
                    // Memastikan data JSON diterima dengan benar, debug only (comment if not needed)
                    console.log('API Response: ',data);

                    // Check if MAK and kode_mak exist, debug only (comment if not needed)
                    // if (!data.MAK) {
                    //     console.error('MAK is undefined');
                    // } else if (!data.m_a_k.kode_mak) {
                    //     console.error('kode_mak is undefined');
                    // } else {
                    //     console.log('kode_mak:', data.m_a_k.kode_mak);
                    // }

                    const modalBody = document.querySelector('#detailModal .modal-body');
                    modalBody.innerHTML = `
                        <p><strong>Kode Satker:</strong> ${data.satuan_kerja.kode_satker}</p>
                        <p><strong>MAK:</strong> ${data.m_a_k.kode_mak}</p>
                        <p><strong>Nomor SP2D:</strong> ${data.nomor_sp2d}</p>
                        <p><strong>Program:</strong> ${data.kegiatan.program.kode_program}</p>
                        <p><strong>Kegiatan:</strong> ${data.kegiatan.kode_kegiatan}</p>
                        <p><strong>Nomor Surat Tugas:</strong> ${data.nomor_surat_tugas}</p>
                        <p><strong>Tanggal Surat Tugas:</strong> ${data.tanggal_surat_tugas}</p>
                        <p><strong>Tanggal Mulai Dinas:</strong> ${data.tanggal_mulai_dinas}</p>
                        <p><strong>Tanggal Selesai Dinas:</strong> ${data.tanggal_selesai_dinas}</p>
                        <p><strong>Tujuan:</strong> ${data.tujuan_dinas}</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Pelaksana</th>
                                    <th>No. Telp Pelaksana</th>
                                    <th>Status Pegawai Pelaksana</th>
                                    <th>Nilai yang dibayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.pelaksana_dinas.map(pelaksana => `
                                    <tr>
                                        <td>${pelaksana.nama_pegawai}</td>
                                        <td>${pelaksana.no_telp}</td>
                                        <td>${pelaksana.status_pegawai}</td>
                                        <td>${pelaksana.nilai_dibayar}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                    $('#detailModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data. Cek console.');
                });
        });
    });
});

// fungsi entri per page pagination
function updateEntriesPerPage() {
    const entries = document.getElementById('entriesPerPage').value;
    window.location.href = `?entries=${entries}`;
}

$(document).ready(function () {
    let currentPage = 1;
    const entriesPerPage = $('#entriesPerPage').val() || 10;

    // Initial load
    loadData(currentPage);
    
    function loadData(page = 1) {
        const keyword = $('#search-box').val();
        const route = $('#search-box').data('route');
        const entriesPerPage = $('#entriesPerPage').val() || 10;

        $.ajax({
            url: route,
            method: "GET",
            data: { 
                query: keyword,
                page: page,
                entries: entriesPerPage
            },
            success: function (response) {
                renderTable(response);
                updatePagination(response.pagination);
                attachEventHandlers();
            },
            error: function () {
                console.error('Pencarian gagal.');
            }
        });
    }

    function renderTable(response) {
        let rows = '';
        const startIndex = ((response.pagination.current_page - 1) * response.pagination.per_page);
        
        if (Array.isArray(response.data)) {
            response.data.forEach(function (item, index) {
                const formatDate = (date) => {
                    if (!date) return '';
                    const options = { day: '2-digit', month: 'long', year: 'numeric' };
                    return new Intl.DateTimeFormat('id-ID', options).format(new Date(date));
                };
                
                rows += `<tr>
                    <td>${startIndex + index + 1}</td>
                    <td>${item.satuan_kerja?.kode_satker || ''}</td>
                    <td>${item.m_a_k?.kode_mak || ''}</td>
                    <td>${item.nomor_sp2d || ''}</td>
                    <td>${item.kegiatan?.program?.kode_program || ''}</td>
                    <td>${item.kegiatan?.kode_kegiatan || ''}</td>
                    <td>${item.nomor_surat_tugas || ''}</td>
                    <td>${formatDate(item.tanggal_surat_tugas)}</td>
                    <td>${formatDate(item.tanggal_mulai_dinas)}</td>
                    <td>${formatDate(item.tanggal_selesai_dinas)}</td>
                    <td class="text-justify">${item.tujuan_dinas || ''}</td>
                    <td>
                        <button class="btn btn-primary btn-action detail-btn" data-id="${item.id_dinas}">Detail</button>
                        <button class="btn btn-warning btn-action edit-btn" data-id="${item.id_dinas}">Ubah</button>
                        <form class="deleteForm d-inline" action="/perjalanan-dinas/${item.id_dinas}" method="POST">
                            <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-action delete-button" data-id="${item.id_dinas}">Hapus</button>
                        </form>
                    </td>
                </tr>`;
            });
        }
        $('#monitoringBody').html(rows);
    }

    function updatePagination(pagination) {
        let paginationHtml = '';
        
        if (pagination.last_page > 1) {
            paginationHtml += '<ul class="pagination justify-content-center">';
            
            // Previous button
            paginationHtml += `
                <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${pagination.current_page - 1}" ${pagination.current_page === 1 ? 'tabindex="-1" aria-disabled="true"' : ''}>
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`;
            
            // Page numbers
            for (let i = 1; i <= pagination.last_page; i++) {
                paginationHtml += `
                    <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
            }
            
            // Next button
            paginationHtml += `
                <li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${pagination.current_page + 1}" ${pagination.current_page === pagination.last_page ? 'tabindex="-1" aria-disabled="true"' : ''}>
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`;
            
            paginationHtml += '</ul>';
        }
        
        $('#pagination-links').html(paginationHtml);
    }

    function attachEventHandlers() {
        // Detail button handler
        $('.detail-btn').on('click', function() {
            const idDinas = $(this).data('id');
            fetch(`/perjalanan-dinas/${idDinas}`)
                .then(response => response.json())
                .then(data => {
                    const modalBody = document.querySelector('#detailModal .modal-body');
                    modalBody.innerHTML = `
                        <p><strong>Kode Satker:</strong> ${data.satuan_kerja.kode_satker}</p>
                        <p><strong>MAK:</strong> ${data.m_a_k.kode_mak}</p>
                        <p><strong>Nomor SP2D:</strong> ${data.nomor_sp2d}</p>
                        <p><strong>Program:</strong> ${data.kegiatan.program.kode_program}</p>
                        <p><strong>Kegiatan:</strong> ${data.kegiatan.kode_kegiatan}</p>
                        <p><strong>Nomor Surat Tugas:</strong> ${data.nomor_surat_tugas}</p>
                        <p><strong>Tanggal Surat Tugas:</strong> ${data.tanggal_surat_tugas}</p>
                        <p><strong>Tanggal Mulai Dinas:</strong> ${data.tanggal_mulai_dinas}</p>
                        <p><strong>Tanggal Selesai Dinas:</strong> ${data.tanggal_selesai_dinas}</p>
                        <p><strong>Tujuan:</strong> ${data.tujuan_dinas}</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Pelaksana</th>
                                    <th>No. Telp Pelaksana</th>
                                    <th>Status Pegawai Pelaksana</th>
                                    <th>Nilai yang dibayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.pelaksana_dinas.map(pelaksana => `
                                    <tr>
                                        <td>${pelaksana.nama_pegawai}</td>
                                        <td>${pelaksana.no_telp}</td>
                                        <td>${pelaksana.status_pegawai}</td>
                                        <td>${pelaksana.nilai_dibayar}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                    $('#detailModal').modal('show');
                })
                .catch(error => console.error('Error:', error));
        });

        // Edit button handler
        $('.edit-btn').on('click', function() {
            const idDinas = $(this).data('id');
            fetch(`/perjalanan-dinas/${idDinas}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Populate form fields
                    $('#editForm').attr('action', `/perjalanan-dinas/${idDinas}`);
                    $('#kodeSatker').val(data.satuan_kerja.kode_satker);
                    $('#MAK').val(data.m_a_k.kode_mak);
                    $('#program').val(data.kegiatan.program.kode_program);
                    $('#kegiatan').val(data.kegiatan.kode_kegiatan);
                    $('#nomorSuratTugas').val(data.nomor_surat_tugas);
                    $('#nomorSP2D').val(data.nomor_sp2d);
                    $('#tanggalSuratTugas').val(data.tanggal_surat_tugas);
                    $('#tanggalMulaiDinas').val(data.tanggal_mulai_dinas);
                    $('#tanggalSelesaiDinas').val(data.tanggal_selesai_dinas);
                    $('#tujuan').val(data.tujuan_dinas);
        
                    // Clear and populate pelaksana fields
                    const pelaksanaContainer = $('#pelaksanaContainer');
                    pelaksanaContainer.empty();
        
                    if (data.pelaksana_dinas && Array.isArray(data.pelaksana_dinas)) {
                        data.pelaksana_dinas.forEach((pelaksana, index) => {
                            pelaksanaContainer.append(`
                                <div class="pelaksana-entry border p-3 mb-3">
                                    <h5>Pelaksana ${index + 1}</h5>
                                    <input type="hidden" name="pelaksana[${index}][id]" value="${pelaksana.id}">
                                    <div class="form-group">
                                        <label>Nama Pegawai</label>
                                        <input type="text" class="form-control" name="pelaksana[${index}][nama_pegawai]" value="${pelaksana.nama_pegawai}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Status Pegawai</label>
                                        <input type="text" class="form-control" name="pelaksana[${index}][status_pegawai]" value="${pelaksana.status_pegawai}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>No. Telp</label>
                                        <input type="text" class="form-control" name="pelaksana[${index}][no_telp]" value="${pelaksana.no_telp}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Nilai yang Dibayar</label>
                                        <input type="text" class="form-control" name="pelaksana[${index}][nilai_dibayar]" value="${pelaksana.nilai_dibayar}" required>
                                    </div>
                                </div>
                            `);
                        });
                    }
        
                    $('#editModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data');
                });
        });
    
        // Edit form submit handler
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const url = form.attr('action');
            
            // Get pelaksana data
            const pelaksanaData = [];
            $('.pelaksana-entry').each(function(index) {
                pelaksanaData.push({
                    id: $(this).find('input[name^="pelaksana["][name$="[id]"]').val(),
                    nama_pegawai: $(this).find('input[name^="pelaksana["][name$="[nama_pegawai]"]').val(),
                    status_pegawai: $(this).find('input[name^="pelaksana["][name$="[status_pegawai]"]').val(),
                    no_telp: $(this).find('input[name^="pelaksana["][name$="[no_telp]"]').val(),
                    nilai_dibayar: $(this).find('input[name^="pelaksana["][name$="[nilai_dibayar]"]').val()
                });
            });
        
            // Create data object matching controller expectations
            const formData = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                _method: 'PUT',
                kodeSatker: $('#kodeSatker').val(),
                MAK: $('#MAK').val(),
                program: $('#program').val(),
                kegiatan: $('#kegiatan').val(),
                nomorSuratTugas: $('#nomorSuratTugas').val(),
                nomorSP2D: $('#nomorSP2D').val(),
                tanggalSuratTugas: $('#tanggalSuratTugas').val(),
                tanggalMulaiDinas: $('#tanggalMulaiDinas').val(),
                tanggalSelesaiDinas: $('#tanggalSelesaiDinas').val(),
                tujuan: $('#tujuan').val(),
                pelaksana: pelaksanaData
            };
        
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(response) {
                    $('#editModal').modal('hide');
                    alert('Data berhasil diupdate');
                    loadData(currentPage);
                },
                error: function(xhr) {
                    console.error('Error response:', xhr.responseJSON);
                    alert('Terjadi kesalahan: ' + (xhr.responseJSON?.message || 'Unknown error'));
                }
            });
        });

        // Delete form handler
        $('.deleteForm').on('submit', function(e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                this.submit();
            }
        });
    }

    // Search input handler with debouncing
    let searchTimer;
    $('#search-box').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            currentPage = 1;
            loadData(currentPage);
        }, 300);
    });

    // Pagination click handler
    $(document).on('click', '.pagination .page-link', function(e) {
        e.preventDefault();
        if (!$(this).parent().hasClass('disabled')) {
            currentPage = $(this).data('page');
            loadData(currentPage);
        }
    });

    // Entries per page handler
    $('#entriesPerPage').on('change', function() {
        currentPage = 1;
        loadData(currentPage);
    });
});

// Event delegation untuk tombol dinamis
$(document).on('click', '.detail-btn', function () {
    const id = $(this).data('id');
    console.log(`Detail clicked for ID: ${id}`);
    // Tambahkan logika untuk tombol detail
});

$(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    console.log(`Edit clicked for ID: ${id}`);
    // Tambahkan logika untuk tombol edit
});

$(document).on('submit', '.deleteForm', function (e) {
    e.preventDefault();
    const id = $(this).find('.delete-button').data('id');
    console.log(`Delete submitted for ID: ${id}`);
    // Tambahkan logika untuk tombol hapus
});
