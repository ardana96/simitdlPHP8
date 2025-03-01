<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Variabel global untuk menyimpan total halaman, diinisialisasi dengan 1
let totalPagesGlobal = 1;
// Variabel global untuk menyimpan jumlah data per halaman, diinisialisasi dengan 10 (default)
let recordsPerPage = 10;

$(document).ready(function() {
    // Ketika dokumen selesai dimuat, jalankan fungsi-fungsi berikut

    // Buat dropdown untuk memilih jumlah data per halaman secara dinamis
    const recordsDropdown = `
        <div style="display: inline-block; margin-left: 20px;">
            <label for="recordsPerPage">Records per page: </label>
            <select id="recordsPerPage" class="form-control" style="display: inline-block; width: auto;">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="250">250</option>
            </select>
        </div>
    `;
    // Masukkan dropdown ke elemen dengan ID 'recordsPerPageContainer' di HTML
    $('#recordsPerPageContainer').html(recordsDropdown);

    // Set nilai awal dropdown sesuai dengan recordsPerPage default
    $('#recordsPerPage').val(recordsPerPage);

    // Event listener untuk perubahan pada dropdown records per page
    $('#recordsPerPage').on('change', function() {
        // Ambil nilai baru dari dropdown dan konversi ke integer
        recordsPerPage = parseInt($(this).val());
        // Simpan recordsPerPage dan reset ke halaman 1 ke session
        $.ajax({
            url: 'aplikasi/stockopname/actionstop/save_page.php',
            method: 'POST',
            data: { 
                recordsPerPage: recordsPerPage,
                page: 1 // Reset ke halaman 1 saat mengubah records per page
            },
            success: function() {
                console.log("Records per page dan halaman disimpan ke session");
            },
            error: function(xhr, status, error) {
                console.error("Gagal menyimpan records per page ke session:", error);
            }
        });
        // Muat ulang data dengan halaman pertama
        loadData(1);
    });

    // Fungsi untuk memuat data dari server via AJAX berdasarkan halaman dan limit
    function loadData(page = 1) {
        console.log("Mengambil data halaman:", page, "dengan records per page:", recordsPerPage);

        $.ajax({
            url: 'aplikasi/stockopname/fect_stockopname.php', // URL endpoint PHP untuk mengambil data
            method: "GET", // Metode HTTP GET
            dataType: "json", // Harapkan respons dalam format JSON
            data: {
                page: page, // Halaman yang diminta
                limit: recordsPerPage // Jumlah data per halaman
            },
            success: function(response) {
                console.log("Data diterima:", response);

                var html = "";
                // Jika tidak ada data, tampilkan pesan "Tidak ada data"
                if (response.data.length === 0) {
                    html = "<tr><td colspan='17' class='text-center'>Tidak ada data yang ditemukan.</td></tr>";
                } else {
                    // Loop melalui data yang diterima dan buat baris tabel
                    $.each(response.data, function(index, row) {
                        html += "<tr>";
                        // Nomor urut berdasarkan halaman dan indeks
                        html += "<td>" + ((page - 1) * recordsPerPage + index + 1) + "</td>";
                        html += "<td>" + (row.ippc || '') + "</td>"; // IP PC, gunakan string kosong jika null
                        html += "<td>" + (row.idpc || '') + "</td>"; // ID PC
                        html += "<td>" + (row.user || '') + "</td>"; // User
                        html += "<td>" + (row.namapc || '') + "</td>"; // Nama PC
                        html += "<td>" + (row.bagian || '') + "</td>"; // Bagian
                        html += "<td>" + (row.subbagian || '') + "</td>"; // Sub Bagian
                        html += "<td>" + (row.lokasi || '') + "</td>"; // Lokasi
                        html += "<td>" + (row.prosesor || '') + "</td>"; // Prosesor
                        html += "<td>" + (row.mobo || '') + "</td>"; // Motherboard
                        html += "<td>" + (row.ram || '') + "</td>"; // RAM
                        html += "<td>" + (row.harddisk || '') + "</td>"; // Harddisk
                        html += "<td>" + (row.bulan || '') + "</td>"; // Bulan
                        html += "<td>" + (row.tgl_perawatan ? row.tgl_perawatan : '') + "</td>"; // Tanggal Perawatan, gunakan string kosong jika null
                        // Formulir untuk tombol "Perawatan"
                        html += '<td class="center"><form action="user.php?menu=fupdate_pemakaipc2" method="post">';
                        html += '<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />';
                        html += '<button class="btn btn-primary" type="submit">Perawatan</button></form></td>';
                        // Formulir untuk tombol "Update"
                        html += '<td class="center"><form action="user.php?menu=fupdate_kerusakanpc2" method="post">';
                        html += '<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />';
                        html += '<button class="btn btn-primary" type="submit">Update</button></form></td>';
                        // Formulir untuk tombol "Hapus" dengan konfirmasi
                        html += '<td class="center"><form action="aplikasi/stockopname/actionstop/stc_deletdatas.php" method="post">'
                                + '<input type="hidden" name="id" value="' + (row.id || '') + '" />'
                                + '<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />'
                                + '<button class="btn btn-danger" type="submit">X</button></form></td>';
                        html += "</tr>";
                    });
                }

                // Masukkan HTML ke dalam tbody tabel dengan ID 'dataBody'
                $("#dataBody").html(html);

                // Simpan totalPages ke variabel global untuk digunakan di tempat lain
                totalPagesGlobal = response.totalPages;

                // Generate HTML untuk pagination dengan batasan nomor halaman (maksimal 5 nomor ditampilkan)
                var totalPages = response.totalPages;
                var maxVisiblePages = 5; // Jumlah maksimum nomor halaman yang ditampilkan
                var paginationHTML = '<div class="pagination">';
                var startPage, endPage;

                // Logika untuk menentukan rentang nomor halaman yang akan ditampilkan
                if (totalPages <= maxVisiblePages) {
                    startPage = 1;
                    endPage = totalPages;
                } else {
                    var half = Math.floor(maxVisiblePages / 2);
                    if (page <= half + 1) {
                        startPage = 1;
                        endPage = maxVisiblePages;
                    } else if (page + half >= totalPages) {
                        startPage = totalPages - maxVisiblePages + 1;
                        endPage = totalPages;
                    } else {
                        startPage = page - half;
                        endPage = page + half;
                    }
                }

                // Tambahkan tombol "Previous"
                paginationHTML += '<button class="btn btn-secondary prev-btn' + (page === 1 ? ' disabled' : '') + '" data-page="' + (page - 1) + '">Previous</button>';

                // Tambahkan nomor halaman dengan tanda "..."
                if (totalPages > 3) {
                    if (startPage > 1) {
                        paginationHTML += '<button class="btn btn-secondary dots-btn" data-action="start">...</button>';
                    }
                    for (var i = startPage; i <= endPage; i++) {
                        paginationHTML += '<button class="btn btn-secondary page-btn' + (i === page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                    }
                    if (endPage < totalPages) {
                        paginationHTML += '<button class="btn btn-secondary dots-btn" data-action="end">...</button>';
                    }
                } else {
                    for (var i = 1; i <= totalPages; i++) {
                        paginationHTML += '<button class="btn btn-secondary page-btn' + (i === page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                    }
                }

                // Tambahkan tombol "Next"
                paginationHTML += '<button class="btn btn-secondary next-btn' + (page === totalPages ? ' disabled' : '') + '" data-page="' + (page + 1) + '">Next</button>';

                paginationHTML += '</div>';
                // Masukkan HTML pagination ke elemen dengan ID 'pagination'
                $("#pagination").html(paginationHTML);

                // Re-bind event listeners untuk pagination setelah pembaruan
                bindPaginationEvents();
            },
            error: function(xhr, status, error) {
                // Tangani error dari AJAX request
                console.error("AJAX Error:", status, error);
                console.log("Response:", xhr.responseText);
                alert("Terjadi kesalahan: " + (xhr.responseText || "Koneksi gagal, coba lagi nanti."));
            }
        });
    }

    // Fungsi untuk mengikat event listener ke tombol pagination
    function bindPaginationEvents() {
            // Hapus event listener lama untuk mencegah duplikasi
            $(document).off("click", ".page-btn, .prev-btn, .next-btn").on("click", ".page-btn, .prev-btn, .next-btn", function() {
                console.log("Clicked pagination button:", $(this).data("page"));
                if (!$(this).hasClass('disabled')) {
                    var page = $(this).data("page");
                    // Muat data untuk halaman yang dipilih
                    loadData(page);
                    // Simpan halaman saat ini ke session
                    $.ajax({
                        url: 'aplikasi/stockopname/actionstop/save_page.php',
                        method: 'POST',
                        data: { 
                            page: page,
                            recordsPerPage: recordsPerPage
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log("Halaman disimpan ke session:", page, "Response:", data);
                        },
                        error: function(xhr, status, error) {
                            console.error("Gagal menyimpan halaman ke session:", error);
                            console.log("Response dari save_page.php:", xhr.responseText);
                            alert("Gagal menyimpan status halaman. Silakan coba lagi.");
                        }
                    });
                }
            });

            // Event listener untuk tombol "..." (tetap sama)
            $(document).off("click", ".dots-btn").on("click", ".dots-btn", function(e) {
                console.log("Clicked dots button");
                showPageInput(e); // Tampilkan popup untuk input nomor halaman
            });
    }

    // Fungsi untuk menampilkan popup input nomor halaman saat tombol "..." diklik
    function showPageInput(position) {
        // Buat elemen popup untuk input nomor halaman
        var popup = $('<div id="pageInputPopup" style="position: absolute; background: white; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 1000;"></div>');
        var input = $('<input type="number" id="pageNumber" min="1" style="padding: 5px; width: 100px; margin-right: 5px;">');
        var submitBtn = $('<button style="padding: 5px 10px; cursor: pointer;">Go</button>');

        popup.append(input).append(submitBtn);

        // Posisikan popup di atas tombol "..." yang diklik
        var $dotsBtn = $(position.target);
        var offset = $dotsBtn.offset();
        popup.css({
            top: offset.top - 50, // Popup muncul 50px di atas tombol
            left: offset.left
        });

        // Tambahkan popup ke body
        $('body').append(popup);

        // Event listener untuk submit via Enter
        input.on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                var page = parseInt($(this).val());
                console.log("Enter pressed, page:", page);
                if (page >= 1 && page <= totalPagesGlobal) {
                    loadData(page); // Muat data untuk halaman yang dimasukkan
                    $('#pageInputPopup').remove(); // Hapus popup
                    bindPaginationEvents(); // Re-bind event listeners
                } else {
                    alert('Masukkan nomor halaman yang valid (1-' + totalPagesGlobal + ')');
                }
            }
        });

        // Event listener untuk tombol "Go"
        submitBtn.on('click', function() {
            var page = parseInt(input.val());
            console.log("Go button clicked, page:", page);
            if (page >= 1 && page <= totalPagesGlobal) {
                loadData(page); // Muat data untuk halaman yang dimasukkan
                $('#pageInputPopup').remove(); // Hapus popup
                bindPaginationEvents(); // Re-bind event listeners
            } else {
                alert('Masukkan nomor halaman yang valid (1-' + totalPagesGlobal + ')');
            }
        });

        // Event listener untuk menutup popup jika klik di luar
        $(document).off("click", "#pageInputPopupClose").on("click", function(e) {
            if (!popup.is(e.target) && popup.has(e.target).length === 0) {
                console.log("Popup closed by clicking outside");
                popup.remove(); // Hapus popup
                bindPaginationEvents(); // Re-bind event listeners
                $(document).off("click", "#pageInputPopupClose"); // Hapus event listener setelah digunakan
            }
        });
    }

    // Event listener untuk formulir penghapusan data (tombol "Hapus")
    $('#dataBody').on('submit', 'form[action="aplikasi/stockopname/actionstop/stc_deletdatas.php"]', function(e) {
        e.preventDefault(); // Hentikan submit default untuk menghindari reload halaman

        if (confirm('Apakah Anda yakin akan menghapus data ini?')) {
            var form = $(this);
            $.ajax({
                url: form.attr('action'), // URL untuk menghapus data (stc_deletdatas.php)
                method: 'POST', // Metode HTTP POST
                data: form.serialize(), // Data dari formulir (id dan nomor)
                dataType: 'json', // Harapkan respons dalam format JSON
                success: function(response) {
    console.log("Respons dari penghapusan:", response);
                        if (response.status === "success") {
                            alert(response.message);
                            // Muat ulang data pada halaman yang dikembalikan oleh server
                            loadData(response.currentPage);
                            // Simpan halaman saat ini ke session
                            $.ajax({
                                url: 'aplikasi/stockopname/actionstop/save_page.php',
                                method: 'POST',
                                data: { 
                                    page: response.currentPage,
                                    recordsPerPage: recordsPerPage
                                },
                                dataType: 'json', // Harapkan respons JSON
                                success: function(data) {
                                    console.log("Halaman dan records per page disimpan ke session:", data);
                                },
                                error: function(xhr, status, error) {
                                    console.error("Gagal menyimpan halaman ke session:", error);
                                    console.log("Response dari save_page.php:", xhr.responseText);
                                    alert("Gagal menyimpan status halaman. Silakan coba lagi.");
                                }
                            });
                        } else {
                            alert("Gagal menghapus data: " + (response.error || "Error tidak diketahui"));
                        }
                    },
                error: function(xhr, status, error) {
                    // Tangani error dari AJAX request penghapusan
                    console.error("Error saat menghapus:", error);
                    console.log("Response:", xhr.responseText);
                    alert("Terjadi kesalahan saat menghapus data: " + (xhr.responseText || "Koneksi gagal, coba lagi nanti."));
                }
            });
        }
    });

    // Muat data pertama kali dan bind event listeners saat dokumen siap
    loadData();
    bindPaginationEvents();
});
</script>