<div class="inner">
    <div class="row">
        <div class="col-lg-12">
            <h2>Data Perawatan</h2>
        </div>  
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="panel panel-danger">
                        <div class="panel-body">
                            <form method="GET" action="index.php">
                                <div class="form-group">
                                    <b>Nama Bulan</b>        
                                    <select class="form-control" name="bulan" required="required">	 
                                        <option value="">Pilih Bulan</option>
                                        <?php
                                        include("../config.php"); // Pastikan koneksi SQL Server ada di config.php

                                        // Pastikan koneksi tersedia
                                        if (!$conn) {
                                            die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
                                        }

                                        // Query untuk mengambil data bulan
                                        $queryBulan = "SELECT * FROM bulan";
                                        $stmtBulan = sqlsrv_query($conn, $queryBulan);
                                        if ($stmtBulan === false) {
                                            die("Query gagal: " . print_r(sqlsrv_errors(), true));
                                        }

                                        while ($datass = sqlsrv_fetch_array($stmtBulan, SQLSRV_FETCH_ASSOC)) {
                                            $id_bulan = $datass['id_bulan'];
                                            $bulan = $datass['bulan'];
                                            ?>
                                            <option value="<?php echo htmlspecialchars($id_bulan, ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars($bulan, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php
                                        }
                                        sqlsrv_free_stmt($stmtBulan);
                                        ?>
                                    </select> 
                                </div>	

                                <div class="form-group">
                                    <b>Tahun</b>        
                                    <select class="form-control" name="tahun" size="1" id="tahun">
                                        <?php
                                        // for ($i = date('Y'); $i >= 2022; $i--) {
                                        //     $year = ($i < 10) ? "0$i" : $i;
                                        //     echo "<option value=\"$year\">$year</option>";
                                        // }
                                        for ($i = 2030; $i >= 2022; $i--) {
                                            $year = ($i < 10) ? "0$i" : $i;
                                            echo "<option value=\"$year\">$year</option>";
                                        }
                                        ?>    
                                    </select>
                                </div>

                                <div class="form-group">
                                    <b>Divisi</b>        
                                    <select class="form-control" name="namadivisi" required="required">	 
                                        <option value="">Pilih Divisi</option>
                                        <?php
                                        // Query untuk mengambil data divisi
                                        $queryDivisi = "SELECT * FROM divisi";
                                        $stmtDivisi = sqlsrv_query($conn, $queryDivisi);
                                        if ($stmtDivisi === false) {
                                            die("Query gagal: " . print_r(sqlsrv_errors(), true));
                                        }

                                        while ($datass = sqlsrv_fetch_array($stmtDivisi, SQLSRV_FETCH_ASSOC)) {
                                            $namadivisi = $datass['namadivisi'];
                                            ?>
                                            <option value="<?php echo htmlspecialchars($namadivisi, ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars($namadivisi, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php
                                        }
                                        sqlsrv_free_stmt($stmtDivisi);
                                        ?>
                                    </select> 
                                </div>

                                <div class="form-group">
                                    <b>Perangkat Yang Dirawat</b>        
                                    <select class="form-control" name="perangkat" required="required">	 
                                        <option value="">Pilih Perangkat</option>
                                        <?php
                                        // Query untuk mengambil data tipe perawatan
                                        $queryTipe = "SELECT * FROM tipe_perawatan";
                                        $stmtTipe = sqlsrv_query($conn, $queryTipe);
                                        if ($stmtTipe === false) {
                                            die("Query gagal: " . print_r(sqlsrv_errors(), true));
                                        }

                                        while ($datass = sqlsrv_fetch_array($stmtTipe, SQLSRV_FETCH_ASSOC)) {
                                            $id = $datass['id'];
                                            $nama_perangkat = $datass['nama_perangkat'];
                                            ?>
                                            <option value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
                                                <?php echo htmlspecialchars($nama_perangkat, ENT_QUOTES, 'UTF-8'); ?>
                                            </option>
                                        <?php
                                        }
                                        sqlsrv_free_stmt($stmtTipe);
                                        sqlsrv_close($conn);
                                        ?>
                                    </select> 
                                </div>

                                <button type="submit" class="btn btn-primary">Cari</button>	
                                <button type="button" class="btn btn-danger" onclick="prints()">Print</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>    

            <br>
            <div class="panel-body">
                <div class="table-responsive" style="overflow: scroll;">
                    <table class="table table-bordered table-hover" id="data">
                        <thead>
                            <tr>
                                <th>Sudah Dirawat</th>
                                <th>Belum Selesai</th>
                                <th>Belum Dirawat</th>
                                <th>Total</th>
                                <th>Progress %</th>
                            </tr>
                        </thead>
                        <tbody id="tableInfo">
                        </tbody>
                    </table>

                    <!-- Tabel Laporan -->
                    <table class="table table-bordered table-hover" id="data">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>ID</th>
                                <th>User</th>
                                <th>Lokasi</th>
                                <th>PIC</th>
                                <th>Keterangan</th>
                                <th>Perangkat</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Item Yang Di Cek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="perawatanForm">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="perangkatId" id="perangkatId" disabled>
                        <input type="hidden" class="form-control" name="tahunModal" id="tahunModal" disabled>
                        <div class="form-group">
                            <label for="idpc">ID</label>
                            <input type="text" class="form-control" name="idpc" id="idpc" disabled>
                        </div>
                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="text" class="form-control" name="user" id="user" disabled>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi" disabled>
                        </div>
                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <select class="form-control" name="bulan" id="bulanModul" required disabled>
                                <option value="">Pilih Bulan</option>
                                <?php
                                $bulanArr = array(
                                    "01" => "Januari", "02" => "Februari", "03" => "Maret", "04" => "April",
                                    "05" => "Mei", "06" => "Juni", "07" => "Juli", "08" => "Agustus",
                                    "09" => "September", "10" => "Oktober", "11" => "November", "12" => "Desember"
                                );
                                foreach ($bulanArr as $id => $nama) {
                                    echo "<option value='$id'>$nama</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="editOrderDate">Jenis Perawatan</label><br>
                            <label><input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)"> Pilih Semua</label><br>
                        </div>
                        <div id="modalCheckboxes"></div>
                        <hr>
                        <div class="form-group">
                            <b>Keterangan</b>									  
                            <textarea cols="45" rows="5" name="keterangan" class="form-control" id="keterangan" placeholder="Keterangan"></textarea>    
                        </div>
                        <div class="form-group">
                            <label for="approve_by">Nama User</label>
                            <input type="text" class="form-control" name="approve_by" id="approve_by" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('perawatanForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Mencegah submit default
            simpanPerawatan();
        });

        function toggleCheckboxes(source) {
            const checkboxes = document.querySelectorAll("input[type='checkbox'][name='selected_items[]']");
            checkboxes.forEach((checkbox) => {
                checkbox.checked = source.checked;
            });
        }

        function loadData() {
            const bulan = document.querySelector("[name='bulan']").value;
            const tahun = document.querySelector("[name='tahun']").value;
            const namadivisi = document.querySelector("[name='namadivisi']").value;
            const perangkat = document.querySelector("[name='perangkat']").value;

            $.ajax({
                url: 'aplikasi/perawatan_app/cariperawatan.php',
                type: 'GET',
                data: {
                    bulan: bulan,
                    tahun: tahun,
                    namadivisi: namadivisi,
                    perangkat: perangkat
                },
                success: function(response) {
                    console.log(response);
                    $('#tableData').html(response);
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });

            $.ajax({
                url: 'aplikasi/perawatan_app/hitungperawatan.php',
                type: 'GET',
                data: {
                    bulan: bulan,
                    tahun: tahun,
                    namadivisi: namadivisi,
                    perangkat: perangkat
                },
                success: function(response) {
                    console.log(response);
                    $('#tableInfo').html(response);
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        }

        $(document).ready(function() {
            loadData();
            $('form').on('submit', function(e) {
                e.preventDefault();
                loadData();
            });
        });

        function showEdit(data) {
            const perangkatValue = document.querySelector("[name='perangkat']").value;
            const tahunValue = document.querySelector("[name='tahun']").value;
            document.getElementById("idpc").value = data.idpc;
            document.getElementById("user").value = data.user;
            document.getElementById("lokasi").value = data.lokasi;
            document.getElementById("keterangan").value = data.keterangan;
            document.getElementById("perangkatId").value = perangkatValue;
            document.getElementById("tahunModal").value = tahunValue;
            document.getElementById("approve_by").value = data.approve_by;

            $.ajax({
                url: 'aplikasi/perawatan_app/get_perawatan_items.php',
                type: 'GET',
                data: { 
                    idpc: data.idpc,
                    perangkat_id: perangkatValue,
                    tahun: tahunValue
                },
                success: function(response) {
                    $('#modalCheckboxes').html(response);
                    $('#editModal').modal('show');
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        }

        function simpanPerawatan() {
    const selectedItems = Array.from(document.querySelectorAll("input[name='selected_items[]']:checked")).map(cb => cb.value);
    const unselectedItems = Array.from(document.querySelectorAll("input[name='selected_items[]']:not(:checked)")).map(cb => cb.value);
    const idpc = document.getElementById("idpc").value;
    const user = document.getElementById("user").value;
    const lokasi = document.getElementById("lokasi").value;
    const keterangan = document.getElementById("keterangan").value;
    const tipe_perawatan_id = document.getElementById("perangkatId").value;
    const approve_by = document.getElementById("approve_by").value;
    const tahun = document.getElementById("tahun").value;
    const bulan = document.getElementById("bulanModul").value;

    // Debugging: Log selectedItems sebelum dikirim
    console.log("Selected Items:", selectedItems);
    console.log("Unselected Items:", unselectedItems);

    $.ajax({
        url: 'aplikasi/perawatan_app/simpan_perawatan.php',
        type: 'POST',
        data: {
            idpc: idpc,
            user: user,
            lokasi: lokasi,
            tipe_perawatan_id: tipe_perawatan_id,
            tahun: tahun,
            bulan: bulan, // Tambahkan parameter bulan
            keterangan: keterangan,
            selected_items: selectedItems,
            unselected_items: unselectedItems,
            approve_by: approve_by
        },
        success: function(response) {
            console.log(response);
            $('#editModal').modal('hide');
            loadData();
        },
        error: function() {
            alert('Gagal menyimpan data.');
        }
    });
}

        function refresh() {
            location.reload();
        }

        function get_nama_perangkat(callback) {
            const perangkat = document.querySelector("[name='perangkat']").value;

            $.ajax({
                url: 'aplikasi/perawatan_app/get_nama_perangkat.php',
                type: 'GET',
                data: {
                    perangkat: perangkat
                },
                success: function(response) {
                    callback(response);
                },
                error: function() {
                    alert('Gagal memuat data.');
                }
            });
        }

        function prints() {
            const bulan = document.querySelector("[name='bulan']").value;
            const tahun = document.querySelector("[name='tahun']").value;
            const namadivisi = document.querySelector("[name='namadivisi']").value;
            const perangkat = document.querySelector("[name='perangkat']").value;

            get_nama_perangkat(function(data) {
                const parameter = `tahun=${tahun}&bulan=${bulan}&pdivisi=${namadivisi}`;
                let url = '';
                switch (data.toLowerCase()) {
                    case 'pc dan laptop':
                        url = `manager/lap_perawatanPC.php?`;
                        break;
                    case 'printer':
                        url = `manager/lap_perawatanPrinter.php?`;
                        break;
                    case 'scaner':
                        url = `manager/lap_perawatanScanner.php?`;
                        break;
                    case 'switch/router':
                        url = `manager/lap_perawatanRouter.php?`;
                        break;
                    case 'kabel jaringan':
                        url = `manager/lap_perawatanKabel.php?`;
                        break;
                    case 'access point':
                        url = `manager/lap_perawatanAccessPoint.php?`;
                        break;
                    case 'nvr/dvr':
                        url = `manager/lap_perawatanNVR.php?`;
                        break;
                    case 'kamera':
                        url = `manager/lap_perawatanKamera.php?`;
                        break;
                    case 'fingerspot':
                        url = `manager/lap_perawatanFingerSpot.php?`;
                        break;
                    case 'server':
                        url = `manager/lap_perawatanServer.php?`;
                        break;
                    case 'ups':
                        url = `manager/lap_perawatanUPS.php?`;
                        break;
                    case 'proyektor':
                        url = `manager/lap_perawatanProyektor.php?`;
                        break;
                    default:
                        console.error('Tipe perangkat tidak dikenali');
                        return;
                }
                const mergeUrl = url + parameter;
                window.open(mergeUrl, '_blank');
            });
        }

        
        $(document).ready(function() {
    // Set nilai default bulan di modal berdasarkan bulan yang dipilih di filter utama
    $("select[name='bulan']").on("change", function() {
        let selectedBulan = $(this).val(); // Ambil nilai bulan dari filter utama
        $("#bulanModul").val(selectedBulan); // Atur nilai dropdown di modal
    });

    // Saat modal dibuka, pastikan dropdown bulan tetap sesuai dengan filter utama
    $("#editModal").on("show.bs.modal", function() {
        let selectedBulan = $("select[name='bulan']").val();
        $("#bulanModul").val(selectedBulan);
    });
});
    </script>
</div>