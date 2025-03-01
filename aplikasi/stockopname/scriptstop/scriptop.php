<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let totalPagesGlobal = 1; // Variabel global untuk menyimpan totalPages
let recordsPerPage = 10; // Default jumlah data per halaman

$(document).ready(function() {
    // Buat dropdown records per page secara dinamis
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

    // Set nilai awal dari dropdown
    $('#recordsPerPage').val(recordsPerPage);

    // Event listener untuk perubahan dropdown records per page
    $('#recordsPerPage').on('change', function() {
        recordsPerPage = parseInt($(this).val());
        loadData(1); // Muat ulang data dengan halaman pertama
    });

    function loadData(page = 1) {
        console.log("Mengambil data halaman:", page, "dengan records per page:", recordsPerPage);

        $.ajax({
            url: 'aplikasi/stockopname/fect_stockopname.php',
            method: "GET",
            dataType: "json",
            data: {
                page: page,
                limit: recordsPerPage // Kirim jumlah data per halaman
            },
            success: function(response) {
                console.log("Data diterima:", response);

                var html = "";
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
                    html += '<td class="center"><form action="user.php?menu=fupdate_kerusakanpc2" method="post">';
                    html += '<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />';
                    html += '<button class="btn btn-primary" type="submit">Update</button></form></td>';
                    html += '<td class="center"><form action="aplikasi/deletepemakaipc2.php" method="post">';
                    html += '<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />';
                    html += '<button class="btn btn-danger" type="submit" onclick="return confirm(\'Apakah Anda yakin akan menghapus data ini?\')">X</button></form></td>';
                    html += "</tr>";
                });

                $("#dataBody").html(html);

                // Simpan totalPages ke variabel global
                totalPagesGlobal = response.totalPages;

                // Generate pagination dengan batasan nomor halaman (misalnya, tampilkan 5 nomor)
                var totalPages = response.totalPages;
                var maxVisiblePages = 5; // Maksimum nomor halaman yang ditampilkan
                var paginationHTML = '<div class="pagination">';
                var startPage, endPage;

                // Logika untuk menentukan rentang nomor halaman
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

                // Tombol Previous
                paginationHTML += '<button class="btn btn-secondary prev-btn' + (page === 1 ? ' disabled' : '') + '" data-page="' + (page - 1) + '">Previous</button>';

                // Nomor halaman dengan tanda "..."
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

                // Tombol Next
                paginationHTML += '<button class="btn btn-secondary next-btn' + (page === totalPages ? ' disabled' : '') + '" data-page="' + (page + 1) + '">Next</button>';

                paginationHTML += '</div>';
                $("#pagination").html(paginationHTML);

                // Re-bind event listeners setelah pagination diperbarui
                bindPaginationEvents();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Response:", xhr.responseText);
            }
        });
    }

    // Fungsi untuk mengikat event listener pagination
    function bindPaginationEvents() {
        // Event listener untuk pagination (tombol halaman, Previous, Next)
        $(document).off("click", ".page-btn, .prev-btn, .next-btn").on("click", ".page-btn, .prev-btn, .next-btn", function() {
            console.log("Clicked pagination button:", $(this).data("page"));
            if (!$(this).hasClass('disabled')) {
                var page = $(this).data("page");
                loadData(page);
            }
        });

        // Event listener untuk tombol "..."
        $(document).off("click", ".dots-btn").on("click", ".dots-btn", function(e) {
            console.log("Clicked dots button");
            showPageInput(e); // Tampilkan popup saat "..." diklik
        });
    }

    // Fungsi untuk menampilkan popup
    function showPageInput(position) {
        var popup = $('<div id="pageInputPopup" style="position: absolute; background: white; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 1000;"></div>');
        var input = $('<input type="number" id="pageNumber" min="1" style="padding: 5px; width: 100px; margin-right: 5px;">');
        var submitBtn = $('<button style="padding: 5px 10px; cursor: pointer;">Go</button>');

        popup.append(input).append(submitBtn);

        // Posisi popup di atas tombol "..."
        var $dotsBtn = $(position.target);
        var offset = $dotsBtn.offset();
        popup.css({
            top: offset.top - 50, // Popup muncul 50px di atas tombol
            left: offset.left
        });

        $('body').append(popup);

        // Event untuk submit (Enter atau klik tombol Go)
        input.on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                var page = parseInt($(this).val());
                console.log("Enter pressed, page:", page);
                if (page >= 1 && page <= totalPagesGlobal) {
                    loadData(page);
                    $('#pageInputPopup').remove();
                    bindPaginationEvents(); // Re-bind event setelah navigasi
                } else {
                    alert('Masukkan nomor halaman yang valid (1-' + totalPagesGlobal + ')');
                }
            }
        });

        submitBtn.on('click', function() {
            var page = parseInt(input.val());
            console.log("Go button clicked, page:", page);
            if (page >= 1 && page <= totalPagesGlobal) {
                loadData(page);
                $('#pageInputPopup').remove();
                bindPaginationEvents(); // Re-bind event setelah navigasi
            } else {
                alert('Masukkan nomor halaman yang valid (1-' + totalPagesGlobal + ')');
            }
        });

        // Menutup popup jika klik di luar
        $(document).off("click", "#pageInputPopupClose").on("click", function(e) {
            if (!popup.is(e.target) && popup.has(e.target).length === 0) {
                console.log("Popup closed by clicking outside");
                popup.remove();
                bindPaginationEvents(); // Re-bind event setelah popup ditutup
                $(document).off("click", "#pageInputPopupClose");
            }
        });
    }

    // Load pertama kali dan bind event
    loadData();
    bindPaginationEvents();
});
</script>