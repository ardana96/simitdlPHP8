<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let totalPagesGlobal = 1;
    let recordsPerPage = 10;
    let currentPage = 1;

    $(document).ready(function() {
        $.ajax({
            url: 'aplikasi/stockopname/actionstop/save_page.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log("Respons dari save_page.php:", response);
                const sessionPage = parseInt(response.current_page) || 1;
                const sessionLimit = parseInt(response.records_per_page) || 10;
                const lastPage = parseInt(response.last_page) || 1;
                const lastLimit = parseInt(response.last_limit) || 10;

                // Deteksi refresh sengaja
                const isRefresh = performance.navigation.type === 1 || window.performance.getEntriesByType("navigation")[0].type === "reload";

                // Logika: Gunakan last_page jika ada dan bukan refresh, jika tidak gunakan current_page, jika refresh reset ke 1
                const initialPage = (!isRefresh && lastPage > 1) ? lastPage : (sessionPage > 1 ? sessionPage : 1);
                const initialLimit = (!isRefresh && lastLimit > 10) ? lastLimit : (sessionLimit > 10 ? sessionLimit : 10);

                currentPage = initialPage;
                recordsPerPage = initialLimit;
                $('#recordsPerPage').val(recordsPerPage);
                loadData(initialPage, true); // Panggil loadData dengan forceUpdate
                console.log("Initial load with page:", initialPage, "limit:", initialLimit, "isRefresh:", isRefresh, "lastPage:", lastPage, "sessionPage:", sessionPage);
            },
            error: function(xhr, status, error) {
                console.error("Gagal mengambil session:", error, "Response:", xhr.responseText);
                recordsPerPage = 10;
                currentPage = 1;
                $('#recordsPerPage').val(recordsPerPage);
                loadData(1, true);
            }
        });

        const recordsDropdown = `
            <div style="display: inline-block; margin-left: 20px; margin-top: 30px;">
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
        $('#recordsPerPage').val(recordsPerPage);

        $('#recordsPerPage').on('change', function() {
            recordsPerPage = parseInt($(this).val());
            $.ajax({
                url: 'aplikasi/stockopname/actionstop/save_page.php',
                method: 'POST',
                data: { recordsPerPage: recordsPerPage, page: currentPage },
                success: function() { console.log("Records per page disimpan ke session"); },
                error: function(xhr, status, error) { console.error("Gagal menyimpan records per page:", error); }
            });
            loadData(currentPage, true);
        });

        function loadData(page = 1, forceUpdate = false) {
            currentPage = page; // Perbarui currentPage global
            console.log("Mengambil data halaman:", page, "dengan records per page:", recordsPerPage, "forceUpdate:", forceUpdate);
            $.ajax({
                url: 'aplikasi/stockopname/fect_stockopname.php',
                method: "GET",
                dataType: "json",
                data: { page: page, limit: recordsPerPage },
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
                            html += '<td class="center">' +'<form action="user.php?menu=fupdate_pemakaipc2" method="post">' +'<input type="hidden" name="nomor" value="' + (row.nomor || '') + '" />' +'<input type="hidden" name="id" value="' + (row.id || '') + '" />' +'<button class="btn btn-primary" type="submit">Perawatan</button>' +'</form>' +'</td>';
                            html += '<td class="center"><form action="user.php?menu=updatestockop" method="post"><input type="hidden" name="id" value="' + (row.id || '') + '" /><input type="hidden" name="nomor" value="' + (row.nomor || '') + '" /><button class="btn btn-primary" type="submit">Update</button></form></td>';
                            html += '<td class="center"><form action="aplikasi/stockopname/actionstop/stc_deletdatas.php" method="post"><input type="hidden" name="id" value="' + (row.id || '') + '" /><input type="hidden" name="nomor" value="' + (row.nomor || '') + '" /><button class="btn btn-danger" type="submit">X</button></form></td>';
                            html += "</tr>";
                        });
                    }
                    $("#dataBody").html(html);
                    totalPagesGlobal = response.totalPages;
                    var paginationHTML = '<div class="pagination">';
                    var maxVisiblePages = 5;
                    var startPage, endPage;
                    if (response.totalPages <= maxVisiblePages) {
                        startPage = 1;
                        endPage = response.totalPages;
                    } else {
                        var half = Math.floor(maxVisiblePages / 2);
                        if (page <= half + 1) {
                            startPage = 1;
                            endPage = maxVisiblePages;
                        } else if (page + half >= response.totalPages) {
                            startPage = response.totalPages - maxVisiblePages + 1;
                            endPage = response.totalPages;
                        } else {
                            startPage = page - half;
                            endPage = page + half;
                        }
                    }
                    paginationHTML += '<button class="btn btn-secondary prev-btn' + (page === 1 ? ' disabled' : '') + '" data-page="' + (page - 1) + '">Previous</button>';
                    if (response.totalPages > 3) {
                        if (startPage > 1) paginationHTML += '<button class="btn btn-secondary dots-btn" data-action="start">...</button>';
                        for (var i = startPage; i <= endPage; i++) {
                            paginationHTML += '<button class="btn btn-secondary page-btn' + (i === page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                        }
                        if (endPage < response.totalPages) paginationHTML += '<button class="btn btn-secondary dots-btn" data-action="end">...</button>';
                    } else {
                        for (var i = 1; i <= response.totalPages; i++) {
                            paginationHTML += '<button class="btn btn-secondary page-btn' + (i === page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                        }
                    }
                    paginationHTML += '<button class="btn btn-secondary next-btn' + (page === response.totalPages ? ' disabled' : '') + '" data-page="' + (page + 1) + '">Next</button>';
                    paginationHTML += '</div>';
                    $("#pagination").html(paginationHTML);
                    if (forceUpdate) {
                        $(".page-btn").removeClass("active");
                        $(".page-btn[data-page='" + page + "']").addClass("active");
                    }
                    bindPaginationEvents();
                    $.ajax({
                        url: 'aplikasi/stockopname/actionstop/save_page.php',
                        method: 'POST',
                        data: { page: page, recordsPerPage: recordsPerPage },
                        dataType: 'json',
                        success: function(data) { console.log("Halaman disimpan ke session:", data); },
                        error: function(xhr, status, error) { console.error("Gagal menyimpan halaman:", error); }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error, "Response:", xhr.responseText);
                    $("#pagination").html('<div class="pagination"><p>Error: Gagal memuat pagination.</p></div>');
                    alert("Terjadi kesalahan: " + (xhr.responseText || "Koneksi gagal, coba lagi nanti."));
                }
            });
        }

        function bindPaginationEvents() {
            $(document).off("click", ".page-btn, .prev-btn, .next-btn").on("click", ".page-btn, .prev-btn, .next-btn", function() {
                if (!$(this).hasClass('disabled')) {
                    var page = $(this).data("page");
                    loadData(page, true);
                    $.ajax({
                        url: 'aplikasi/stockopname/actionstop/save_page.php',
                        method: 'POST',
                        data: { page: page, recordsPerPage: recordsPerPage },
                        dataType: 'json',
                        success: function(data) { console.log("Halaman disimpan ke session:", page); },
                        error: function(xhr, status, error) { console.error("Gagal menyimpan halaman:", error); }
                    });
                }
            });
            $(document).off("click", ".dots-btn").on("click", ".dots-btn", function(e) {
                if ($('.pageInputPopup').length === 0) showPageInput(e);
            });
        }

        function showPageInput(position) {
            var popup = $('<div class="pageInputPopup" style="position: absolute; background: white; border: 1px solid #ccc; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); z-index: 1000;"></div>');
            var input = $('<input type="number" id="pageNumber" min="1" style="padding: 5px; width: 100px; margin-right: 5px;">');
            var submitBtn = $('<button style="padding: 5px 10px; cursor: pointer; background-color: #007bff; color: white; border: none; border-radius: 3px;">Go</button>');
            popup.append(input).append(submitBtn);
            var $dotsBtn = $(position.target);
            var offset = $dotsBtn.offset();
            popup.css({ top: offset.top - 50, left: offset.left });
            $('body').append(popup);

            input.on('keypress', function(e) {
                if (e.which === 13) {
                    var page = parseInt($(this).val()) || 1;
                    if (page >= 1 && page <= totalPagesGlobal) {
                        loadData(page, true);
                        $.ajax({
                            url: 'aplikasi/stockopname/actionstop/save_page.php',
                            method: 'POST',
                            data: { page: page, recordsPerPage: recordsPerPage },
                            dataType: 'json',
                            success: function(data) { console.log("Halaman disimpan via Enter:", page); },
                            error: function(xhr, status, error) { console.error("Gagal menyimpan halaman:", error); }
                        });
                        $('.pageInputPopup').remove();
                        bindPaginationEvents();
                    } else {
                        alert('Masukkan nomor halaman yang valid (1-' + totalPagesGlobal + ')');
                    }
                }
            });

            submitBtn.on('click', function() {
                var page = parseInt(input.val()) || 1;
                if (page >= 1 && page <= totalPagesGlobal) {
                    loadData(page, true);
                    $.ajax({
                        url: 'aplikasi/stockopname/actionstop/save_page.php',
                        method: 'POST',
                        data: { page: page, recordsPerPage: recordsPerPage },
                        dataType: 'json',
                        success: function(data) { console.log("Halaman disimpan via Go:", page); },
                        error: function(xhr, status, error) { console.error("Gagal menyimpan halaman:", error); }
                    });
                    $('.pageInputPopup').remove();
                    bindPaginationEvents();
                } else {
                    alert('Masukkan nomor halaman yang valid (1-' + totalPagesGlobal + ')');
                }
            });

            $(document).on("click.pagePopup", function(e) {
                if (!popup.is(e.target) && popup.has(e.target).length === 0) {
                    $('.pageInputPopup').remove();
                    bindPaginationEvents();
                    $(document).off("click.pagePopup");
                }
            });
        }

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
                        if (response.status === "success") {
                            alert(response.message);
                            loadData(response.currentPage, true);
                            $.ajax({
                                url: 'aplikasi/stockopname/actionstop/save_page.php',
                                method: 'POST',
                                data: { page: response.currentPage, recordsPerPage: recordsPerPage },
                                dataType: 'json',
                                success: function(data) { console.log("Halaman disimpan:", data); },
                                error: function(xhr, status, error) { console.error("Gagal menyimpan:", error); }
                            });
                        } else {
                            alert("Gagal menghapus data: " + (response.error || "Error tidak diketahui"));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error saat menghapus:", error);
                        alert("Terjadi kesalahan: " + (xhr.responseText || "Koneksi gagal"));
                    }
                });
            }
        });

        loadData();
        bindPaginationEvents();
    });
</script>