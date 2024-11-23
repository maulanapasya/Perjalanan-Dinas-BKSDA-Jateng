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


// $(document).ready(function () {
//     $('#search-box').on('input', function () {
//         const keyword = $(this).val();
        
//         $.ajax({
//             url: "{{ route('monitoringDinas.search') }}",
//             method: "GET",
//             data: { keyword: keyword },
//             success: function (data) {
//                 let rows = '';
//                 data.forEach(function (item, index) {
//                     rows += `
//                         <tr>
//                             <td>${index + 1}</td>
//                             <td>${item.satuan_kerja?.kode_satker || ''}</td>
//                             <td>${item.m_a_k?.kode_mak || ''}</td>
//                             <td>${item.nomor_sp2d || ''}</td>
//                             <td>${item.kegiatan?.program?.kode_program || ''}</td>
//                             <td>${item.kegiatan?.kode_kegiatan || ''}</td>
//                             <td>${item.nomor_surat_tugas || ''}</td>
//                             <td>${item.tanggal_surat_tugas || ''}</td>
//                             <td>${item.tanggal_mulai_dinas || ''}</td>
//                             <td>${item.tanggal_selesai_dinas || ''}</td>
//                             <td>${item.tujuan_dinas || ''}</td>
//                             <td>
//                                 <button class="btn btn-primary btn-action detail-btn" data-id="${item.id_dinas}">Detail</button>
//                                 <button class="btn btn-warning btn-action edit-btn" data-id="${item.id_dinas}">Ubah</button>
//                                 <form id="deleteForm" action="/perjalanan-dinas/${item.id_dinas}" method="POST">
//                                     @csrf
//                                     @method('DELETE')
//                                     <button type="submit" class="btn btn-danger btn-action delete-button" data-id="${item.id_dinas}">Hapus</button>
//                                 </form>
//                             </td>
//                         </tr>`;
//                 });
//                 $('#monitoringBody').html(rows);
//             },
//             error: function () {
//                 console.error('Pencarian gagal.');
//             }
//         });
//     });
// });

$(document).ready(function () {
    $('#search-box').on('input', function () {
        const keyword = $(this).val();
        const route = $(this).data('route'); // Ambil route dari atribut data-route

        $.ajax({
            url: route, // Gunakan route dari atribut
            method: "GET",
            data: { query: keyword },
            success: function (data) {
                let rows = '';
                data.forEach(function (item, index) {
                    const formatDate = (date) => {
                        if (!date) return ''; // Jika tanggal null atau undefined, kembalikan string kosong
                        const options = { day: '2-digit', month: 'long', year: 'numeric' };
                        return new Intl.DateTimeFormat('id-ID', options).format(new Date(date));
                    };
                    
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
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
                                <form id="deleteForm" action="/perjalanan-dinas/${item.id_dinas}" method="POST">
                                    <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger btn-action delete-button" data-id="${item.id_dinas}">Hapus</button>
                                </form>
                            </td>
                        </tr>`;
                });
                $('#monitoringBody').html(rows);
            },
            error: function () {
                console.error('Pencarian gagal.');
            }
        });
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


// document.addEventListener("DOMContentLoaded", function() {
//     const searchBox = document.getElementById('search-box');
//     const monitoringBody = document.getElementById('monitoringBody');

//     searchBox.addEventListener('input', function() {
//         const query = searchBox.value;

//         fetch(`/search-perjalanan-dinas?query=${query}`)
//             .then(response => response.json())
//             .then(data => {
//                 // Clear the table body
//                 monitoringBody.innerHTML = '';

//                 // Populate the table with the filtered results
//                 data.forEach((item, index) => {
//                     const row = document.createElement('tr');
//                     row.innerHTML = `
//                         <td>${index + 1}</td>
//                         <td>${item.kode_satker}</td>
//                         <td>${item.kode_mak}</td>
//                         <td>${item.nomor_sp2d}</td>
//                         <td>${item.program}</td>
//                         <td>${item.kegiatan}</td>
//                         <td>${item.nomor_surat_tugas}</td>
//                         <td>${item.tanggal_surat_tugas}</td>
//                         <td>${item.tanggal_mulai_dinas}</td>
//                         <td>${item.tanggal_selesai_dinas}</td>
//                         <td>${item.tujuan}</td>
//                         <td>
//                             <button class="btn btn-primary btn-action detail-btn" data-id="${item.id_dinas}">Detail</button>
//                             <button class="btn btn-warning btn-action edit-btn" data-id="${item.id_dinas}">Ubah</button>
//                             <form id="deleteForm" action="/perjalanan-dinas/${item.id_dinas}" method="POST">
//                                 @csrf
//                                 @method('DELETE')
//                                 <button type="submit" class="btn btn-danger btn-action delete-button" data-id="${item.id_dinas}">Hapus</button>
//                             </form>
//                         </td>
//                     `;
//                     monitoringBody.appendChild(row);
//                 });
//             })
//             .catch(error => console.error('Error fetching data:', error));
//     });
// });
