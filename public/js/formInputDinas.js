/* JavaScript blade view formInputDinas */

// fungsi untuk menghapus dan mengedit form input pegawai pelaksana
function handleDeleteClick(event) {
    var row = event.target.closest('tr');
    if(row){
        row.remove();
        togglePelaksanaInstruction();
    }
}
    

// fungsi untuk mengedit form input pegawai pelaksana
function handleEditClick(event) {
    var editBtn = event.target;
    var row = editBtn.closest('tr');
    var inputs = row.querySelectorAll('input.form-control');
    var isEditing = editBtn.textContent === 'Ubah';

    if (isEditing) {
        inputs.forEach(input => input.removeAttribute('readonly'));
        editBtn.textContent = 'Simpan';
    } else {
        inputs.forEach(input => {
            input.setAttribute('readonly', true);
        });
        editBtn.textContent = 'Ubah';
    }
}

// fungsi untuk menampilkan atau menyembuyikan instruksi tambah pegawai pelaksana
function togglePelaksanaInstruction() {
    var pelaksanaBody = document.getElementById('pelaksana-body');
    var instructionDiv = document.getElementById('pelaksana-instruction');
    //Jika tidak ada baris di dalam tabel, tampilkan instruksi
    if (pelaksanaBody.rows.length === 0) {
        instructionDiv.style.display = 'block';
    } else { //Jika ada baris di dalam tabel, sembunyikan instruksi
        instructionDiv.style.display = 'none';
    }
}

// memanggil form tambah pegawai pelaksana sebelum menambahkan form input pegawai pelaksana
document.addEventListener('DOMContentLoaded', (event) => {
    togglePelaksanaInstruction();
});

document.addEventListener("DOMContentLoaded", function() {
    /* Validasi realtime jika form sudah diisi, tetapi kembali dikosongi */

    // menemukan semua form input dalam .form-group
    var inputs = document.querySelectorAll(".form-group input, .form-group textarea, .pelaksana-box input");

    // pemanggilan kembali pesan error jika form kembali kosong setelah pengetikan
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            // Dapatkan id error berdasarkan name input
            var errorId = this.getAttribute('data-error-id');
            var errorMessageElement = document.getElementById(errorId);
            if (errorMessageElement) {
                if (this.value === ''){
                    var message = this.getAttribute('data-error') !== '' ? this.getAttribute('data-error') : 'Tidak boleh dikosongi.';
                    errorMessageElement.innerHTML = message;
                } else {
                    errorMessageElement.innerHTML = '';
                }
            }
        });
    });

    /* Mengatur tambah pegawai pelaksana */

    // inisialisasi untuk menambahkan form input pegawai pelaksana
    var pelaksanaTableBody = document.querySelector('#pelaksana-table tbody');
    // indeks awal untuk form input pegawai pelaksana
    let indexPelaksana = 0;

    // method untuk menambahkan form input pegawai pelaksana
    document.getElementById('tambahBtn').addEventListener('click', function(event) {
        // mengambil nilai dari form input pegawai pelaksana
        var namaPelaksana = document.getElementById('namaPelaksana').value.trim();
        var telponPelaksana = document.getElementById('telponPelaksana').value.trim();
        var nilaiDibayar = document.getElementById('nilaiDibayar').value.trim();
        var statusPegawaiPelaksana = document.getElementById('statusPegawaiPelaksana').value.trim();

        // Reset pesan error
        document.getElementById('error_namaPelaksana').textContent = '';
        document.getElementById('error_telponPelaksana').textContent = '';
        document.getElementById('error_nilaiDibayar').textContent = '';
        document.getElementById('error_statusPegawaiPelaksana').textContent = '';

        let isFormValid = true;

        if(!namaPelaksana){
            document.getElementById('error_namaPelaksana').textContent = 'Tidak boleh dikosongi.';
            console.log('Validasi nama pelaksana gagal')
            isFormValid = false;
        }
        if(!telponPelaksana){
            document.getElementById('error_telponPelaksana').textContent = 'Tidak boleh dikosongi.';
            isFormValid = false;
        }
        if(!nilaiDibayar){
            document.getElementById('error_nilaiDibayar').textContent = 'Tidak boleh dikosongi. Jika tidak ada nilai yang dibayar, isikan "0".';
            isFormValid = false;
        }
        if(!statusPegawaiPelaksana){
            document.getElementById('error_statusPegawaiPelaksana').textContent = 'Tidak boleh dikosongi.';
            isFormValid = false;
        }

        if (!isFormValid) {
            event.preventDefault();
            return;
        } else {
            // membuat baris baru untuk form input pegawai pelaksana
            var newRow = pelaksanaTableBody.insertRow();
            newRow.innerHTML = `<tr>
            <td><input type="text" name="pelaksana[${indexPelaksana}][nama_pegawai]" value="${namaPelaksana}" class="form-control" readonly /></td>
            <td><input type="text" name="pelaksana[${indexPelaksana}][no_telp]" value="${telponPelaksana}" class="form-control" readonly /></td>
            <td><input type="text" name="pelaksana[${indexPelaksana}][nilai_dibayar]" value="${nilaiDibayar}" class="form-control" readonly /></td>
            <td><input type="text" name="pelaksana[${indexPelaksana}][status_pegawai]" value="${statusPegawaiPelaksana}" class="form-control" readonly /></td>
            <td class="d-flex">
                <button type="button" class="edit-btn btn btn-warning btn-sm mr-2">Ubah</button>
                <button type="button" class="delete-btn btn btn-danger btn-sm">Hapus</button>
            </td>
            </tr>`;

            // indeks untuk form input pegawai pelaksana
            indexPelaksana++;

            // Membersihkan input form ketika sudah ditambahkan
            document.getElementById('namaPelaksana').value = '';
            document.getElementById('telponPelaksana').value = '';
            document.getElementById('nilaiDibayar').value = '';
            document.getElementById('statusPegawaiPelaksana').value = '';

            // perbarui tampilan instruksi tambah pegawai pelaksana
            togglePelaksanaInstruction();

            // menambahkan event listener untuk tombol edit dan hapus
            newRow.querySelector('.delete-btn').addEventListener('click', handleDeleteClick);
            newRow.querySelector('.edit-btn').addEventListener('click', handleEditClick);
        }
    })
    
    /* Mengatur agar form nilai dibayar hanya dapat ditulis dengan format mata uang rupiah */

    // pemanggilan form nilaidibayar agar isian diformatkan sesuai mata uang rupiah
    var nilaiDibayarInput = document.getElementById('nilaiDibayar');
    nilaiDibayarInput.addEventListener('input', function (e) {
        var input = e.target.value;
        var cleanInput = input.replace(/\D/g,''); //menghapus karakter yang bukan angka secara otomatis

        if(cleanInput.match(/^0[0-9].*/)){
            cleanInput = cleanInput.replace(/^0+/, "");
        }

        var formattedInput = formatRupiah(cleanInput); //format input ke rupiah
        e.target.value = formattedInput;
    });

    // fungsi agar form nilai dibayar diformatkan sesuai mata uang rupiah
    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0,sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);
        
        //titik sebagai pemisah pada format mata uang rupiah
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return rupiah;
    }

    /* Mengatur agar form input kode satker dan mak hanya bisa ditulis angka sebanyak 6 digit */

    // fungsi agar form MAK dan satker hanya dapat diisi 6 digit angka
    function inputNumericSatkerMAK(event){
        var value = event.target.value;
        var numericValue = value.replace(/\D/g, ''); // regex untuk memastikan input hanya angka
        numericValue = numericValue.substring(0,6); // membatasi agar hanya bisa diisi oleh 6 digit
        event.target.value = numericValue;
    }

    // pemanggilan form input kodeSatker dan MAK
    var kodeSatkerInput = document.getElementById("kodeSatker");
    var makInput = document.getElementById("MAK");

    // event listener untuk validasi ketika mengetik
    kodeSatkerInput.addEventListener("input", inputNumericSatkerMAK);
    makInput.addEventListener("input", inputNumericSatkerMAK);

    /* Mengatur agar form yang hanya berupa angka hanya dapat diisi dengan angka */

    // fungsi agar form hanya bisa diisi angka
    function inputNumericForm(event){
        var value = event.target.value;
        var numericValue = value.replace(/\D/g, '');
        event.target.value = numericValue;
    }

    // pemanggilan form yang hanya bisa diisi angka
    var telponPelaksanaInput = document.getElementById("telponPelaksana");
    var nomorSP2DInput = document.getElementById("nomorSP2D")

    // event listener validasi untuk validasi ketika mengetik
    telponPelaksanaInput.addEventListener("input", inputNumericForm);
    nomorSP2DInput.addEventListener("input", inputNumericForm);

    /* Mengatur agar program ditulis dengan format XXX.XX.XX */

    // pemanggilan form program
    var programInput = document.getElementById("program");
    var submitButton = document.getElementById("submit");

    // method untuk mengatur form program agar sesuai format XXX.XX.XX
    programInput.addEventListener("input", function(event){
        var value = event.target.value.replace(/[^0-9a-zA-Z]/g, '').toUpperCase(); //hapus karakter selain angka dan huruf, jadikan semua huruf menjadi kapital semua
        var programFormattedValue = value.split('').reduce(function(acc, char, index){
            // tambah titik sebagai pemisah
            if (index === 3 || index === 5) acc += '.';
            return acc + char;
        }, '');
        
        // membatasi karakter hanya bisa diisi sesuai format XXX.XX.XX, tidak lebih
        programFormattedValue = programFormattedValue.substring(0,9);

        // menetap nilai ke input
        programInput.value = programFormattedValue;
    });

    // method validasi submit ketika form program belum diisi lengkap
    submitButton.addEventListener("click", function(event){
        var value = programInput.value;
        var formatProgram = /^[0-9a-zA-Z]{3}.[0-9a-zA-Z]{2}.[0-9a-zA-Z]{2}$/;

        if (!formatProgram.test(value)){ // jika user tidak menuliskan program dengan lengkap
            message.textContent = "Lengkapi kode program sesuai format \"XXX.XX.XX\"";
        }
    });

    /* Pesan agar form program tidak diisi dengan titik */

    // method validasi ketika user mencoba mengetik "." pada form program
    programInput.addEventListener("keydown", function(event){
        // memanggil form program
        var message = document.getElementById('inputErrorProgram');
        var error_program = document.getElementById('error_program');

        // Mengecek jika user mengetik titik
        if (event.key === '.') {
            event.preventDefault(); // mencegah titik ditulis
            if (error_program) {
                error_program.textContent = '';
            }
            message.textContent = "Tidak perlu mengetikkan titik (\".\"). Cukup isi huruf atau angka pada Kode Program. Titik (\".\") pada Kode Program akan otomatis tertulis.";
        } else {
            message.textContent = ''; // pesan hilang ketika user mengetik selain titik
        }
    });

    /* Pesan agar form nomorsp2d tidak diisi selain angka */

    // memanggil form nomorsp2d dan pesan error jika dikosongi
    var nomorSP2DInput = document.getElementById('nomorSP2D');
    var error_nomorSP2D = document.getElementById('error_nomorSP2D');

    // menambahkan event listener untuk validasi ketika user mengetik
    nomorSP2DInput.addEventListener('keydown', function(event) {
        // Mengecek jika user mengetik selain angka
        var nomorSP2DMessage = document.getElementById('inputErrorNomorSP2D');
        if (event.key.match(/^[a-zA-Z]$/)) {
            event.preventDefault(); // mencegah user mengetik selain angka
            if (error_nomorSP2D) {
                error_nomorSP2D.textContent = '';
            }
            nomorSP2DMessage.textContent = "Nomor SP2D harus berisi angka.";
        } else {
            nomorSP2DMessage.textContent = ''; // pesan hilang ketika user mengetik angka
        }
    });

    /* Mengatur form kegiatan agar ditulis dengan format XXXX.XXX */

    /* Memanggil form kegiatan */
    var kegiatanInput = document.getElementById('kegiatan');

    // Method agar form kegiatan diformatkan sesuai format XXXX.XXX
    kegiatanInput.addEventListener('input', function(event){
        var value = event.target.value.replace(/[^0-9a-zA-Z]/g, '').toUpperCase(); //hapus karakter selain angka dan huruf, jadikan semua huruf menjadi kapital semua
        var kegiatanFormattedValue = value.split('').reduce(function(acc, char, index){
            // tambah titik sebagai pemisah
            if (index === 4) acc += '.';
            return acc + char;
        }, '');
        
        // membatasi karakter hanya bisa diisi sesuai format XXXX.XXX, tidak lebih
        kegiatanFormattedValue = kegiatanFormattedValue.substring(0,8);

        // menetap nilai ke input
        kegiatanInput.value = kegiatanFormattedValue;
    });

    // Method agar form kegiatan tidak diisi dengan titik
    kegiatanInput.addEventListener("keydown", function(event){
        // memanggil form kegiatan
        var message = document.getElementById('inputErrorKegiatan');
        var error_kegiatan = document.getElementById('error_kegiatan');

        // Mengecek jika user mengetik titik
        if (event.key === '.') {
            event.preventDefault(); // mencegah titik ditulis
            if (error_kegiatan) {
                error_kegiatan.textContent = '';
            }
            message.textContent = "Tidak perlu mengetikkan titik (\".\"). Cukup isi huruf atau angka pada Kode Kegiatan. Titik (\".\") pada Kode Kegiatan akan otomatis tertulis.";
        } else {
            message.textContent = ''; // pesan hilang ketika user mengetik selain titik
        }
    });

    // mematikan form tambah pelaksana ketika submit
    document.getElementById('submit').addEventListener('click', function(event) {
        const pelaksanaInputs = document.querySelectorAll('input[name^="pelaksana"]');
        pelaksanaInputs.forEach(input => {
            if (input.value === '') {
                input.disabled = true;
            }
        });
    });
});

// // fungsi notifikasi data berhasil dimasukkan
// $(document).ready(function(){
//     setTimeout(function(){
//         $('#flash-message').fadeOut('slow');
//     }, 3000);
// });