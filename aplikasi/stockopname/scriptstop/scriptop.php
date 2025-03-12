<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let totalPagesGlobal = 1;
    let recordsPerPage = 10;
    let currentPage = 1;
    let isFiltered = false;
    let filterData = {};

    // Fungsi untuk mengonversi id_bulan ke nama bulan
    function getMonthName(monthId) {
        const months = {
            '00': 'All Bulan',
            '01': 'Januari',
            '02': 'Februari',
            '03': 'Maret',
            '04': 'April',
            '05': 'Mei',
            '06': 'Juni',
            '07': 'Juli',
            '08': 'Agustus',
            '09': 'September',
            '10': 'Oktober',
            '11': 'November',
            '12': 'Desember'
        };
        return months[monthId] || monthId; // Jika tidak ada mapping, kembalikan nilai asli
    }

    $(document).ready(function() {
        // Fungsi untuk mengisi dropdown dengan data unik
        function populateDropdown(column, selectId) {
            console.log("Mengisi dropdown untuk kolom:", column, "dan ID:", selectId);
            let url = 'aplikasi/stockopname/actionstop/get_filter_data.php';

            if (column === 'bulan') {
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    data: { table: 'bulan', valueColumn: 'id_bulan', textColumn: 'bulan' },
                    timeout: 10000,
                    success: function(response) {
                        console.log("Respons dari server untuk bulan:", response);
                        let $select = $('#' + selectId);
                        $select.empty();
                        $select.append('<option value="">Pilih Bulan</option>');
                        if (response.error) {
                            console.error("Error dari server:", response.error);
                            return;
                        }
                        if (response.length === 0) {
                            console.warn("Tidak ada data untuk bulan");
                            $select.append('<option value="">Tidak ada data</option>');
                        } else {
                            $.each(response, function(index, item) {
                                $select.append('<option value="' + item.id_bulan + '">' + item.bulan + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal memuat data untuk bulan:', status, error, xhr.responseText);
                    }
                });
            } else {
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    data: { column: column },
                    timeout: 10000,
                    success: function(response) {
                        console.log("Respons dari server untuk kolom " + column + ":", response);
                        let $select = $('#' + selectId);
                        $select.empty();
                        $select.append('<option value="">Pilih ' + column.charAt(0).toUpperCase() + column.slice(1) + '</option>');
                        if (response.error) {
                            console.error("Error dari server:", response.error);
                            return;
                        }
                        if (response.length === 0) {
                            console.warn("Tidak ada data untuk kolom:", column);
                            $select.append('<option value="">Tidak ada data</option>');
                        } else {
                            $.each(response, function(index, value) {
                                $select.append('<option value="' + value + '">' + value + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal memuat data untuk ' + column + ':', status, error, xhr.responseText);
                    }
                });
            }
        }

        // Panggil fungsi untuk setiap dropdown saat halaman dimuat
        populateDropdown('divisi', 'divisi');
        populateDropdown('bagian', 'bagian');
        populateDropdown('subbagian', 'subBagian');
        populateDropdown('lokasi', 'lokasi');
        populateDropdown('bulan', 'bulan');
        populateDropdown('model', 'pcLaptop');

        // Render dropdown records per page
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

        // Fungsi untuk memuat data
        function loadData(page = 1, forceUpdate = false) {
            currentPage = page; // Perbarui currentPage global
            console.log("Mengambil data halaman:", page, "dengan records per page:", recordsPerPage, "forceUpdate:", forceUpdate);

            let url = isFiltered 
                ? 'aplikasi/stockopname/modal/filter_data.php'
                : 'aplikasi/stockopname/fect_stockopname.php';
            let dataToSend = isFiltered 
                ? { ...filterData, page: page, recordsPerPage: recordsPerPage }
                : { page: page, limit: recordsPerPage };
            let method = isFiltered ? 'POST' : 'GET';

            $.ajax({
                url: url,
                method: method,
                dataType: 'json',
                data: dataToSend,
                timeout: 10000,
                success: function(response) {
                    console.log("Data diterima:", response);
                    var html = "";
                    if (!response || !response.data || response.data.length === 0) {
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
                            // Ubah tampilan bulan menggunakan getMonthName
                            html += "<td>" + getMonthName(row.bulan || '') + "</td>";
                            // html += "<td>" + (row.bulan || '') + "</td>";
                            html += "<td>" + (row.tgl_perawatan ? row.tgl_perawatan : '') + "</td>";
                            html += '<td class="center"><form action="user.php?menu=fupdate_pemakaipc2" method="post"><input type="hidden" name="nomor" value="' + (row.nomor || '') + '" /><input type="hidden" name="id" value="' + (row.id || '') + '" /><button class="btn btn-primary" type="submit">Perawatan</button></form></td>';
                            html += '<td class="center"><form action="user.php?menu=updatestockop" method="post"><input type="hidden" name="id" value="' + (row.id || '') + '" /><input type="hidden" name="nomor" value="' + (row.nomor || '') + '" /><button class="btn btn-primary" type="submit">Update</button></form></td>';
                            html += '<td class="center"><form action="aplikasi/stockopname/actionstop/stc_deletdatas.php" method="post"><input type="hidden" name="id" value="' + (row.id || '') + '" /><input type="hidden" name="nomor" value="' + (row.nomor || '') + '" /><button class="btn btn-danger" type="submit">X</button></form></td>';
                            html += "</tr>";
                        });
                    }
                    $("#dataBody").html(html);

                    // Perbarui totalPagesGlobal dengan fallback
                    totalPagesGlobal = (response && response.totalPages) ? parseInt(response.totalPages) : 1;

                    // Logika pagination
                    var paginationHTML = '<div class="pagination">';
                    var maxVisiblePages = 5;
                    var startPage, endPage;
                    if (totalPagesGlobal <= maxVisiblePages) {
                        startPage = 1;
                        endPage = totalPagesGlobal;
                    } else {
                        var half = Math.floor(maxVisiblePages / 2);
                        if (page <= half + 1) {
                            startPage = 1;
                            endPage = maxVisiblePages;
                        } else if (page + half >= totalPagesGlobal) {
                            startPage = totalPagesGlobal - maxVisiblePages + 1;
                            endPage = totalPagesGlobal;
                        } else {
                            startPage = page - half;
                            endPage = page + half;
                        }
                    }
                    paginationHTML += '<button class="btn btn-secondary prev-btn' + (page === 1 ? ' disabled' : '') + '" data-page="' + (page - 1) + '">Previous</button>';
                    if (totalPagesGlobal > 3) {
                        if (startPage > 1) paginationHTML += '<button class="btn btn-secondary dots-btn" data-action="start">...</button>';
                        for (var i = startPage; i <= endPage; i++) {
                            paginationHTML += '<button class="btn btn-secondary page-btn' + (i === page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                        }
                        if (endPage < totalPagesGlobal) paginationHTML += '<button class="btn btn-secondary dots-btn" data-action="end">...</button>';
                    } else {
                        for (var i = 1; i <= totalPagesGlobal; i++) {
                            paginationHTML += '<button class="btn btn-secondary page-btn' + (i === page ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
                        }
                    }
                    paginationHTML += '<button class="btn btn-secondary next-btn' + (page === totalPagesGlobal ? ' disabled' : '') + '" data-page="' + (page + 1) + '">Next</button>';
                    paginationHTML += '</div>';
                    $("#pagination").html(paginationHTML);

                    if (forceUpdate) {
                        $(".page-btn").removeClass("active");
                        $(".page-btn[data-page='" + page + "']").addClass("active");
                    }
                    bindPaginationEvents();

                    // Simpan halaman ke session
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
                    $("#dataBody").html("<tr><td colspan='17' class='text-center'>Error: Gagal memuat data.</td></tr>");
                    $("#pagination").html('<div class="pagination"><p>Error: Gagal memuat pagination.</p></div>');
                    bindPaginationEvents(); // Tetap bind event meskipun error
                }
            });
        }

        // Fungsi untuk bind event pagination
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

        // Fungsi untuk menampilkan popup input halaman
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

        // Fungsi untuk tombol Cari
        $('#searchBtn').on('click', function() {
            filterData = {
                divisi: $('#divisi').val(),
                bagian: $('#bagian').val(),
                subBagian: $('#subBagian').val(),
                lokasi: $('#lokasi').val(),
                bulan: $('#bulan').val(),
                pcLaptop: $('#pcLaptop').val()
            };
            console.log('Payload yang dikirim:', filterData);
            isFiltered = true;
            currentPage = 1;
            loadData(currentPage, true);
        });

        // Fungsi untuk tombol Reset
        $('#resetBtn').on('click', function() {
            $('#filterForm')[0].reset();
            isFiltered = false;
            filterData = {};
            currentPage = 1;
            loadData(currentPage, true);
        });

        // Event untuk toggle filter
        $('#toggleFilter').on('click', function() {
            $('#filterContainer').toggle();
        });

        // Event untuk update records per page
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

        // Event untuk menghapus data
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

        // Muat data awal berdasarkan session
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

                const isRefresh = performance.navigation.type === 1 || window.performance.getEntriesByType("navigation")[0].type === "reload";

                const initialPage = (!isRefresh && lastPage > 1) ? lastPage : (sessionPage > 1 ? sessionPage : 1);
                const initialLimit = (!isRefresh && lastLimit > 10) ? lastLimit : (sessionLimit > 10 ? sessionLimit : 10);

                currentPage = initialPage;
                recordsPerPage = initialLimit;
                $('#recordsPerPage').val(recordsPerPage);
                loadData(initialPage, true);
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
    });
</script>