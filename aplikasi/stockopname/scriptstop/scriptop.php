<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Variabel global untuk menyimpan total halaman, diinisialisasi dengan 1
    let totalPagesGlobal = 1;
    // Variabel global untuk menyimpan jumlah data per halaman, diinisialisasi dengan 10 (default)
    let recordsPerPage = 10;

    $(document).ready(function() {
        // Ambil data awal dari session via AJAX
        $.ajax({
            url: 'aplikasi/stockopname/actionstop/save_page.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log("Respons dari save_page.php:", response);
                const initialPage = response.current_page ? parseInt(response.current_page) : 1;
                const initialLimit = response.records_per_page ? parseInt(response.records_per_page) : 10;

                recordsPerPage = initialLimit;
                $('#recordsPerPage').val(recordsPerPage);
                loadData(initialPage); // Muat data dengan halaman dari session
                console.log("Initial load with page:", initialPage, "limit:", initialLimit);
            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil session:", error, "Response:", xhr.responseText);
                recordsPerPage = 10;
                $('#recordsPerPage').val(recordsPerPage);
                loadData(1); // Fallback ke halaman 1 jika session gagal
            }
        });

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
        $('#recordsPerPageContainer').html(recordsDropdown);

        // Set nilai awal dropdown sesuai dengan recordsPerPage default
        $('#recordsPerPage').val(recordsPerPage);

        // Event listener untuk perubahan pada dropdown records per page
        $('#recordsPerPage').on('change', function() {
            recordsPerPage = parseInt($(this).val());
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
            loadData(1);
        });

        // Fungsi untuk memuat data dari server via AJAX berdasarkan halaman dan limit
        function loadData(page = 1) {
            console.log("Mengambil data halaman:", page, "dengan records per page:", recordsPerPage);

            $.ajax({
                url: 'aplikasi/stockopname/fect_stockopname.php',
                method: "GET",
                dataType: "json",
                data: {
                    page: page,
                    limit: recordsPerPage
                },
                success: function(response) {
                    console.log("Data diterima:", response);

                    var html = "";
                    if (response.data.length === 0) {
                        html = "<tr><td colspan='17' class='text-center'>Tidak ada data yang ditemukan.</td></tr>";
                    } else {
                        $.each(response.data, function(index, row) {
                            html += "<tr>";
                            html += "<td>" + ((page - 1) * recordsPerPage + index + 1) + "</td>";
                            html += "<td>" + (row.ippc || '') + "</td>";
                            html += "<td>" + (row.idpc || '') + "</td>";
                            html += "<td>" + (row.user || '') + "</td>";
                            html += "<td>" + (row.namapc || '') + "</td>";
                            html += "<td>" + (row.bagian || '') + "</td>";
                            html += "<td>" + (row.subbagian || '') + "</td>";
                            html += "<td>" + (row.lokasi || '') + "</td>";
                            html += "<td>" + (row.prosesor || '') + "</td>";
                            html += "<td>" + (row.mobo || '') + "</td>";
                            html += "<td>" + (row.ram || '') + "</td>";
                            html += "<td>" + (row.harddisk || '') + "</td>";
                            html += "<td>" + (row.bulan || '') + "</td>";
                            html += "<td>" + (row.tgl_perawatan ? row.tgl_perawatan : '') + "</td>";
                            html += '<td class="center"><form action="user.php?menu=fupdate_pemakaipc2" method="post">';
                            html += '<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />';
                            html += '<button class="btn btn-primary" type="submit">Perawatan</button></form></td>';
                            html += '<td class="center"><form action="user.php?menu=updatestockop" method="post">';
                            html += '<input type="hidden" name="id" value="' + (row.id || '') + '" />';
                            html += '<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />';
                            html += '<button class="btn btn-primary" type="submit">Update</button></form></td>';
                            html += '<td class="center"><form action="aplikasi/stockopname/actionstop/stc_deletdatas.php" method="post">';
                            html += '<input type="hidden" name="id" value="' + (row.id || '') + '" />';
                            html += '<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />';
                            html += '<button class="btn btn-danger" type="submit">X</button></form></td>';
                            html += "</tr>";
                        });
                    }

                    // Masukkan HTML ke dalam tbody tabel dengan ID 'dataBody'
                    $("#dataBody").html(html);

                    // Simpan totalPages ke variabel global untuk digunakan di tempat lain
                    totalPagesGlobal = response.totalPages;

                    // Generate HTML untuk pagination dengan batasan nomor halaman (maksimal 5 nomor ditampilkan)
                    var totalPages = response.totalPages;
                    var maxVisiblePages = 5;
                    var paginationHTML = '<div class="pagination">';
                    var startPage, endPage;

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

                    paginationHTML += '<button class="btn btn-secondary prev-btn' + (page === 1 ? ' disabled' : '') + '" data-page="' + (page - 1) + '">Previous</button>';
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
                    paginationHTML += '<button class="btn btn-secondary next-btn' + (page === totalPages ? ' disabled' : '') + '" data-page="' + (page + 1) + '">Next</button>';
                    paginationHTML += '</div>';
                    $("#pagination").html(paginationHTML);
                    bindPaginationEvents();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error, "Response:", xhr.responseText);
                    $("#pagination").html('<div class="pagination"><p>Error: Gagal memuat pagination.</p></div>');
                    alert("Terjadi kesalahan: " + (xhr.responseText || "Koneksi gagal, coba lagi nanti."));
                }
            });
        }

        // Fungsi untuk mengikat event listener ke tombol pagination
        function bindPaginationEvents() {
            $(document).off("click", ".page-btn, .prev-btn, .next-btn").on("click", ".page-btn, .prev-btn, .next-btn", function() {
                console.log("Clicked pagination button:", $(this).data("page"));
                if (!$(this).hasClass('disabled')) {
                    var page = $(this).data("page");
                    loadData(page);
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
                            console.error("Gagal menyimpan halaman ke session:", error, "Response:", xhr.responseText);
                            alert("Gagal menyimpan status halaman. Silakan coba lagi.");
                        }
                    });
                }
            });

            $(document).off("click", ".dots-btn").on("click", ".dots-btn", function(e) {
                console.log("Clicked dots button, attempting to show popup");
                if ($('.pageInputPopup').length === 0) { // Pastikan tidak ada popup yang sudah ada
                    showPageInput(e);
                } else {
                    console.log("Popup already exists, ignoring click");
                }
            });
        }

        // Fungsi untuk menampilkan popup input nomor halaman saat tombol "..." diklik
        function showPageInput(position) {
            var popup = $('<div class="pageInputPopup" style="position: absolute; background: white; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 1000;"></div>');
            var input = $('<input type="number" id="pageNumber" min="1" style="padding: 5px; width: 100px; margin-right: 5px;">');
            var submitBtn = $('<button style="padding: 5px 10px; cursor: pointer; background-color: #007bff; color: white; border: none; border-radius: 3px;">Go</button>');

            popup.append(input).append(submitBtn);
            var $dotsBtn = $(position.target);
            var offset = $dotsBtn.offset();
            popup.css({ top: offset.top - 50, left: offset.left });
            $('body').append(popup);

            // Event listener untuk submit via Enter
            input.on('keypress', function(e) {
                if (e.which === 13) {
                    var page = parseInt($(this).val()) || 1;
                    if (page >= 1 && page <= totalPagesGlobal) {
                        loadData(page);
                        $.ajax({
                            url: 'aplikasi/stockopname/actionstop/save_page.php',
                            method: 'POST',
                            data: { 
                                page: page,
                                recordsPerPage: recordsPerPage
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log("Halaman disimpan ke session via Enter:", page);
                            },
                            error: function(xhr, status, error) {
                                console.error("Gagal menyimpan halaman via Enter:", error);
                            }
                        });
                        $('.pageInputPopup').remove();
                        bindPaginationEvents();
                    } else {
                        alert('Masukkan nomor halaman yang valid (1-' + totalPagesGlobal + ')');
                    }
                }
            });

            // Event listener untuk tombol "Go"
            submitBtn.on('click', function() {
                var page = parseInt(input.val()) || 1;
                if (page >= 1 && page <= totalPagesGlobal) {
                    loadData(page);
                    $.ajax({
                        url: 'aplikasi/stockopname/actionstop/save_page.php',
                        method: 'POST',
                        data: { 
                            page: page,
                            recordsPerPage: recordsPerPage
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log("Halaman disimpan ke session via Go:", page);
                        },
                        error: function(xhr, status, error) {
                            console.error("Gagal menyimpan halaman via Go:", error);
                        }
                    });
                    $('.pageInputPopup').remove();
                    bindPaginationEvents();
                } else {
                    alert('Masukkan nomor halaman yang valid (1-' + totalPagesGlobal + ')');
                }
            });

            // Event listener untuk menutup popup jika klik di luar
            $(document).on("click.pagePopup", function(e) {
                if (!popup.is(e.target) && popup.has(e.target).length === 0) {
                    console.log("Popup closed by clicking outside");
                    $('.pageInputPopup').remove();
                    bindPaginationEvents();
                    $(document).off("click.pagePopup");
                }
            });
        }

        // Event listener untuk formulir penghapusan data (tombol "Hapus")
        $('#dataBody').on('submit', 'form[action="aplikasi/stockopname/actionstop/stc_deletdatas.php"]', function(e) {
            e.preventDefault();

            if (confirm('Apakah Anda yakin akan menghapus data ini?')) {
                var form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        console.log("Respons dari penghapusan:", response);
                        if (response.status === "success") {
                            alert(response.message);
                            loadData(response.currentPage);
                            $.ajax({
                                url: 'aplikasi/stockopname/actionstop/save_page.php',
                                method: 'POST',
                                data: { 
                                    page: response.currentPage,
                                    recordsPerPage: recordsPerPage
                                },
                                dataType: 'json',
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