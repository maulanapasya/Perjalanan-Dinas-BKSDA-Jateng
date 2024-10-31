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
                    // console.log('API Response: ',data);

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
