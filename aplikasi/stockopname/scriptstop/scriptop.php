<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    function loadData(page = 1) {
        console.log("Mengambil data halaman:", page);

        $.ajax({
            url: 'aplikasi/stockopname/fect_stockopname.php?page=' + page,
            method: "GET",
            dataType: "json",
            success: function(response) {
                console.log("Data diterima:", response);

                var html = "";
                $.each(response.data, function(index, row) {
                    html += "<tr>";
                    html += "<td>" + ((page - 1) * 10 + index + 1) + "</td>";
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

                // Nomor halaman
                for (var i = startPage; i <= endPage; i++) {
                    paginationHTML += '<button class="btn btn-secondary page-btn' + (i === page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                }

                // Tombol Next
                paginationHTML += '<button class="btn btn-secondary next-btn' + (page === totalPages ? ' disabled' : '') + '" data-page="' + (page + 1) + '">Next</button>';

                paginationHTML += '</div>';
                $("#pagination").html(paginationHTML);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.log("Response:", xhr.responseText);
            }
        });
    }

    // Load pertama kali
    loadData();

    // Event listener untuk pagination
    $(document).on("click", ".page-btn, .prev-btn, .next-btn", function() {
        if (!$(this).hasClass('disabled')) {
            var page = $(this).data("page");
            loadData(page);
        }
    });
});
</script>