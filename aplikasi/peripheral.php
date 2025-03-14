<?include('config.php');?> 
<?php
function kdauto($tabel, $inisial) {
    global $conn; // Pastikan koneksi sqlsrv tersedia

    // Ambil nama kolom pertama dan panjang maksimum kolom
  
    $query_struktur = "
    WITH ColumnInfo AS (
        SELECT 
            COLUMN_NAME,
            ROW_NUMBER() OVER (ORDER BY ORDINAL_POSITION) AS RowNum,
            CHARACTER_MAXIMUM_LENGTH  AS Columnlength
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = ?
    )
    SELECT 
        Columnlength AS TotalColumns,
        COLUMN_NAME AS SecondColumnName
    FROM ColumnInfo
    WHERE RowNum = 2;
    ";
    $params_struktur = array($tabel);
    $stmt_struktur = sqlsrv_query($conn, $query_struktur, $params_struktur);

    if ($stmt_struktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $field = null;
    $maxLength = null; // Default jika tidak ditemukan panjang kolom
    if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
        $field = $row['SecondColumnName']; // Ambil nama kolom pertama
        $maxLength = $row['TotalColumns'] ?? $maxLength;
    }
    sqlsrv_free_stmt($stmt_struktur);

    if ($field === null) {
        die("Kolom tidak ditemukan pada tabel: $tabel");
    }

    // Ambil nilai maksimum dari kolom tersebut
    $query_max = "SELECT MAX($field) AS maxKode FROM $tabel";
    $stmt_max = sqlsrv_query($conn, $query_max);

    if ($stmt_max === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt_max, SQLSRV_FETCH_ASSOC);

    $angka = 0;
    if (!empty($row['maxKode'])) {
        $angka = (int) substr($row['maxKode'], strlen($inisial));
    }
    $angka++;

    sqlsrv_free_stmt($stmt_max);

    // Tentukan padding berdasarkan panjang kolom
    $padLength = $maxLength - strlen($inisial);
    if ($padLength <= 0) {
        die("Panjang padding tidak valid untuk kolom: $field");
    }

    // Menghasilkan kode baru
    return  $inisial. str_pad($angka, $padLength, "0", STR_PAD_LEFT); // Misalnya SUPP0001
}?>
            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Data Master Barang Peripheral</h2>
                    </div>
                </div>

                <hr />

                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#newReg">
                                    Tambah
                                </button>
                                <button type="button" class="btn btn-warning" onclick="toggleFilter()">Filter</button>
                            </div>
                            <div class="panel-body">
                                <div class="filter-container" id="filterContainer" style="margin-bottom: 20px; display: none;">
                                    <form id="filterForm" method="GET">
                                        <div class="row">
                                            <!-- Nama Perangkat -->
                                            <div class="col-md-2">
                                                <label for="perangkat">Nama Perangkat</label>
                                                <select id="perangkat" name="perangkat" class="form-control">
                                                    <option value="">-- Pilih Nama Perangkat --</option>
                                                    <?php
                                                    $queryPerangkat = "SELECT DISTINCT perangkat FROM peripheral ORDER BY perangkat ASC";
                                                    $stmtPerangkat = sqlsrv_query($conn, $queryPerangkat);
                                                    if ($stmtPerangkat === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    while ($row = sqlsrv_fetch_array($stmtPerangkat, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = isset($_GET['perangkat']) && $_GET['perangkat'] == $row['perangkat'] ? 'selected' : '';
                                                        echo "<option value='" . $row['perangkat'] . "' $selected>" . strtoupper($row['perangkat']) . "</option>";
                                                    }
                                                    sqlsrv_free_stmt($stmtPerangkat);
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- Tipe Perangkat -->
                                            <div class="col-md-2">
                                                <label for="tipe">Tipe</label>
                                                <select id="tipe" name="tipe" class="form-control">
                                                    <option value="">-- Pilih Tipe --</option>
                                                    <?php
                                                    $queryTipe = "SELECT DISTINCT tipe FROM peripheral ORDER BY tipe ASC";
                                                    $stmtTipe = sqlsrv_query($conn, $queryTipe);
                                                    if ($stmtTipe === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    while ($row = sqlsrv_fetch_array($stmtTipe, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = isset($_GET['tipe']) && $_GET['tipe'] == $row['tipe'] ? 'selected' : '';
                                                        echo "<option value='" . $row['tipe'] . "' $selected>" . strtoupper($row['tipe']) . "</option>";
                                                    }
                                                    sqlsrv_free_stmt($stmtTipe);
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- User -->
                                            <div class="col-md-2">
                                                <label for="user">User</label>
                                                <select id="user" name="user" class="form-control">
                                                    <option value="">-- Pilih User --</option>
                                                    <?php
                                                    $queryUser = "SELECT DISTINCT [user] FROM peripheral ORDER BY [user] ASC";
                                                    $stmtUser = sqlsrv_query($conn, $queryUser);
                                                    if ($stmtUser === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    while ($row = sqlsrv_fetch_array($stmtUser, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = isset($_GET['user']) && $_GET['user'] == $row['user'] ? 'selected' : '';
                                                        echo "<option value='" . $row['user'] . "' $selected>" . strtoupper($row['user']) . "</option>";
                                                    }
                                                    sqlsrv_free_stmt($stmtUser);
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- Bulan -->
                                            <div class="col-md-2">
                                                <label for="bulan">Bulan</label>
                                                <select id="bulan" name="bulan" class="form-control">
                                                    <option value="">-- Pilih Bulan --</option>
                                                    <?php
                                                    $bulanList = array(
                                                        '00' => 'All Bulan',
                                                        '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                                                        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                                                        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                                    );
                                                    foreach ($bulanList as $key => $value) {
                                                        $selected = isset($_GET['bulan']) && $_GET['bulan'] == $key ? 'selected' : '';
                                                        echo "<option value='$key' $selected>$value</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- Divisi -->
                                            <div class="col-md-2">
                                                <label for="divisi">Divisi</label>
                                                <select id="divisi" name="divisi" class="form-control">
                                                    <option value="">-- Pilih Divisi --</option>
                                                    <?php
                                                    $queryDivisi = "SELECT DISTINCT divisi FROM peripheral ORDER BY divisi ASC";
                                                    $stmtDivisi = sqlsrv_query($conn, $queryDivisi);
                                                    if ($stmtDivisi === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    while ($row = sqlsrv_fetch_array($stmtDivisi, SQLSRV_FETCH_ASSOC)) {
                                                        $selected = isset($_GET['divisi']) && $_GET['divisi'] == $row['divisi'] ? 'selected' : '';
                                                        echo "<option value='" . $row['divisi'] . "' $selected>" . strtoupper($row['divisi']) . "</option>";
                                                    }
                                                    sqlsrv_free_stmt($stmtDivisi);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Tombol Action -->
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-12 text-right">
                                                <button type="button" class="btn btn-success" onclick="exportToExcelV2()">Export to Excel</button>
                                                <button type="submit" class="btn btn-primary">Cari</button>
                                                <button type="button" id="clearFilter" class="btn btn-secondary" style="background-color: #6c757d; border-color: #6c757d; color: #fff;">Reset</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive" style="overflow: scroll;">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nomor</th>
                                                <th>ID Perangkat</th>
                                                <th>Nama Perangkat</th>
                                                <th>Tipe</th>
                                                <th>User</th>
                                                <th>Divisi</th>
                                                <th>Edit</th>
                                                <th>Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM peripheral ORDER BY tipe";
                                            $stmt = sqlsrv_query($conn, $query);
                                            if ($stmt === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }
                                            while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                $nomor = $data['nomor'];
                                                $id_perangkat = $data['id_perangkat'];
                                                $perangkat = $data['perangkat'];
                                                $user = $data['user'];
                                                $tipe = $data['tipe'];
                                                $divisi = $data['divisi'];
                                            ?>
                                                <tr class="gradeC">
                                                    <td><?php echo $nomor ?></td>
                                                    <td><?php echo $id_perangkat ?></td>
                                                    <td><?php echo $perangkat ?></td>
                                                    <td><?php echo strtoupper($tipe) ?></td>
                                                    <td><?php echo strtoupper($user) ?></td>
                                                    <td><?php echo $divisi ?></td>
                                                    <td class="center">
                                                        <button class="btn btn-primary" value="<?php echo $nomor; ?>" data-toggle="modal" data-target="#newReggg" onclick="sendRequest(this.value)">
                                                            Edit
                                                        </button>
                                                    </td>
                                                    <td class="center">
                                                        <form action="aplikasi/deleteperipheral.php" method="post">
                                                            <input type="hidden" name="nomor" value="<?php echo $nomor; ?>" />
                                                            <button name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            sqlsrv_free_stmt($stmt);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
     
	 
	   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Master Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanPeripheral.php" method="post"  enctype="multipart/form-data" name="postform2">
                                       <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="nomor" value="<?php echo kdauto("peripheral",""); ?>" readonly>
                                    
                                        </div>
										 <div class="form-group">
                                         ID Perangkat
                                            <input class="form-control" type="text" name="id_perangkat" placeholder="ID Perangkat"  >
                                    
                                        </div>
											
										<div class="form-group">
											Nama Perangkat
                                            <input class="form-control" type="text" name="perangkat" placeholder="Nama Perangkat"  >
                                    
                                        </div>
										
										<div class="form-group">
											Tipe
											<select class="form-control" name='tipe' required="required">
												 <option value="Switch/Router" >Switch / Router</option>
												 <option value="kabel jaringan" >Kabel Jaringan</option>
												 <option value="server" >Server</option>
												 <option value="ups" >UPS</option>
												 <option value="access point" >Access Point</option>
												 <option value="proyektor" >Proyektor</option>
												 <option value="NVR/DVR" >NVR / DVR</option>
												 <option value="kamera" >Kamera</option>
												 <option value="fingerspot" >Fingerspot</option>
											</select>  
                                        </div>
										<div class="form-group">
											Brand
                                            <input class="form-control" type="text" name="brand" placeholder="Brand"  >
                                    
                                        </div>
										<div class="form-group">
											Model
                                            <input class="form-control" type="text" name="model" placeholder="Model"  >
                                    
                                        </div>
										<div class="form-group">
											Pembelian Dari
                                            <input class="form-control" type="text" name="pembelian_dari" placeholder="Pembelian Dari"  >
                                    
                                        </div>
										<div class="form-group">
											Serial Number
                                            <input class="form-control" type="text" name="sn" placeholder="Serial Number"  >
                                    
                                        </div>

										
										<div class="form-group">
												Nama User                                    
                                            <input  placeholder="Nama User" class="form-control" type="text" name="nama_user" >
                                    
                                        </div>
										
										<div class="form-group">
												Lokasi                                    
                                            <input  placeholder="Lokasi" class="form-control" type="text" name="lokasi" >
                                    
                                        </div>
	
										<div class="form-group">
												 Keterangan                                    
                                            <input  placeholder="Keterangan" class="form-control" type="text" name="keterangan" >
                                    
                                        </div>
										
										<div class="form-group">
												 Tanggal Perawatan                                    
                                            <input class="form-control" type="date" name="tgl_perawatan"  >
                                    
                                        </div>
										 <div class="form-group">
											Bulan Perawatan         
											<select class="form-control" name="bulan">
                                                    <option value="">Pilih Bulan</option>
                                                    
                                                    <?php
                                                    
                                                    // Query untuk mengambil semua data dari tabel bulan
                                                    $query = "SELECT id_bulan, bulan FROM bulan";

                                                    // Eksekusi query
                                                    $stmt = sqlsrv_query($conn, $query);

                                                    if ($stmt === false) {
                                                        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
                                                    }

                                                    // Periksa apakah ada hasil
                                                    if (sqlsrv_has_rows($stmt)) {
                                                        while ($datas2 = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                            $id_bulan = htmlspecialchars($datas2['id_bulan']); // Pastikan data aman dari XSS
                                                            $bulan = htmlspecialchars($datas2['bulan']); // Pastikan data aman dari XSS
                                                            ?>
                                                            <option value="<?php echo $id_bulan; ?>"><?php echo $bulan; ?></option>
                                                            <?php
                                                        }
                                                    } else {
                                                        echo "<option value=''>Tidak ada data tersedia</option>";
                                                    }

                                                    // Bebaskan resource statement
                                                    sqlsrv_free_stmt($stmt);

                                                    // Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
                                                    sqlsrv_close($conn);
                                                    ?>
                                                </select>       
                                    
                                        </div>	
										<div class="form-group">										
											Divisi                                       
											<select class="form-control" name='divisi' required="required">
												 <option value="GARMENT" >GARMENT</option>
												 <option value="TEXTILE" >TEXTILE</option>
												
										
											</select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>
					
					
					
					
	 <div class="col-lg-12">
                        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Edit Master</h4>
                                        </div>
                                     <div class="modal-body">
                                       <form action="aplikasi/updatePeripheral.php" method="post"  enctype="multipart/form-data" name="postform2">
                                        <div class="form-group">
                                         
                                            <input class="form-control" type="hidden" name="nomor" id="nomor" readonly>
                                    
                                        </div>
										 <div class="form-group">
                                         ID Perangkat
                                            <input class="form-control" type="text" name="id_perangkat" id="id_perangkat"   >
                                    
                                        </div>
											
										<div class="form-group">
											Perangkat
                                            <input class="form-control" type="text" name="perangkat" id="perangkat" placeholder="ID Perangkat"  >
                                    
                                        </div>

										<div class="form-group">
											Tipe
											<select class="form-control" name="tipe" id="tipe" required="required">
												 <option value="Switch/Router" >Switch / Router</option>
												 <option value="kabel jaringan" >Kabel Jaringan</option>
												 <option value="server" >Server</option>
												 <option value="ups" >UPS</option>
												 <option value="access point" >Access Point</option>
												 <option value="proyektor" >Proyektor</option>
												 <option value="NVR/DVR" >NVR / DVR</option>
												 <option value="kamera" >Kamera</option>
												 <option value="fingerspot" >Fingerspot</option>
											</select>  
                                        </div>

										<div class="form-group">
											Brand
                                            
											<input class="form-control" type="text" name="brand" id="brand" placeholder="Brand"  >
                                    
                                        </div>
										<div class="form-group">
											Model
                                            <input class="form-control" type="text" name="model" id="model" placeholder="Model"  >
                                    
                                        </div>
										<div class="form-group">
											Pembelian Dari
                                            <input class="form-control" type="text" name="pembelian_dari" id="pembelian_dari" placeholder="Pembelian Dari"  >
                                    
                                        </div>
										<div class="form-group">
											Serial Number
                                            <input class="form-control" type="text" name="sn" id ="sn" placeholder="Serial Number"  >
                                    
                                        </div>
										
										<div class="form-group">
											Nama User
                                            <input class="form-control" type="text" name="user" id="user" placeholder="Nama User"  >
                                        </div>
										
										<div class="form-group">
											Lokasi
                                            <input class="form-control" type="text" name="lokasi" id="lokasi" placeholder="Lokasi"  >
                                        </div>
										
										
	
										<div class="form-group">
											Keterangan                                 
                                            <input  placeholder="Keterangan" class="form-control" type="text" name="keterangan" id="keterangan" >
                                    
                                        </div>	
										
										<div class="form-group">
											Tanggal Perawatan
                                            <input class="form-control" type="date" name="tgl_perawatan" id="tgl_perawatan"  >
                                        </div>
										<div class="form-group">
											Bulan Perawatan                                       
											<select class="form-control" name='bulan' id='bulan' required="required">
												<option value="" ></option>
												<option value="01" >JANUARI</option>
												<option value="02" >FEBRUARI</option>
												<option value="03" >MARET</option>
												<option value="04" >APRIL</option>
												<option value="05" >MEI</option>
												<option value="06" >JUNI</option>
												<option value="07" >JULI</option>
												<option value="08" >AGUSTUS</option>
												<option value="09" >SEPTEMBER</option>
												<option value="10" >OKTOBER</option>
												<option value="11" >NOVEMBER</option>
												<option value="12" >DESEMBER</option>
													
												
										
											</select>
										</div>
										<div class="form-group">
											Divisi                                       
											<select class="form-control" name='divisi' id='divisi' required="required">
												 <option value="GARMENT" >GARMENT</option>
												 <option value="TEXTILE" >TEXTILE</option>
												
										
											</select>
                                       
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>

<script language="javascript">





    function createRequestObject() {
        var ajax;
        if (navigator.appName == 'Microsoft Internet Explorer') {
            ajax = new ActiveXObject('Msxml2.XMLHTTP');
        } else {
            ajax = new XMLHttpRequest();
        }
        return ajax;
    }

    var http = createRequestObject();

    function sendRequest(nomor) {
        if (nomor == "") {
            alert("Anda belum memilih Printer !");
        } else {
            http.open('GET', 'aplikasi/filterPeripheral.php?nomor=' + encodeURIComponent(nomor), true);
            http.onreadystatechange = handleResponse;
            http.send(null);
        }
    }

    function handleResponse() {
        if (http.readyState == 4) {
            var string = http.responseText.split('&&&');
            document.getElementById('nomor').value = string[0].trim();
            document.getElementById('id_perangkat').value = string[1];
            document.getElementById('perangkat').value = string[2];
            document.getElementById('keterangan').value = string[3];
            document.getElementById('divisi').value = string[4];
            document.getElementById('user').value = string[5];
            document.getElementById('lokasi').value = string[6];
            document.getElementById('tgl_perawatan').value = string[7];
            document.getElementById('bulan').value = string[8];
            document.getElementById('tipe').value = string[9];
            document.getElementById('brand').value = string[10];
            document.getElementById('model').value = string[11];
            document.getElementById('pembelian_dari').value = string[12];
            document.getElementById('sn').value = string[13];
        }
    }

    function toggleFilter() {
    var filterContainer = document.getElementById("filterContainer");
    filterContainer.style.display = (filterContainer.style.display === "none") ? "block" : "none";
}

    document.getElementById('filterForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Cegah reload halaman

    // Ambil semua elemen input dalam form
    const form = this;
    const inputs = form.querySelectorAll('select, input');
    let isValid = false;

    // Periksa apakah ada salah satu input yang diisi
    inputs.forEach(input => {
        if (input.value.trim() !== '') {
            isValid = true;
        }
    });

    // Jika tidak ada input yang diisi, tampilkan peringatan dan hentikan proses submit
    if (!isValid) {
        alert('Form Filter harus diisi salah satunya'); // Peringatan untuk input kosong
        return;
    }

    // Ambil nilai form sebagai objek
    const formData = new FormData(this);
    const filterData = {};
    formData.forEach((value, key) => {
        filterData[key] = value;
    });

    // Mapping bulan ID ke nama bulan
    const bulanMapping = {
		"00": "Semua Bulan",
        "01": "Januari", "02": "Februari", "03": "Maret", "04": "April",
        "05": "Mei", "06": "Juni", "07": "Juli", "08": "Agustus",
        "09": "September", "10": "Oktober", "11": "November", "12": "Desember"
    };

    fetch('aplikasi/filter_peripheral.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(filterData)
    })
    .then(response => response.json())
    .then(data => {
        var table = $('#dataTables-example').DataTable(); // Ambil instance DataTables

        table.clear().draw(); // Hapus semua data tanpa kehilangan pagination

        data.forEach((item, index) => {
            // Konversi ID bulan menjadi nama bulan
            const namaBulan = bulanMapping[item.bulan] || "Tidak diketahui";

            table.row.add([
                item.nomor,
                item.id_perangkat,
                item.perangkat,
                item.tipe,
                item.user,
                item.divisi,
                // namaBulan, // Gunakan nama bulan yang sudah dikonversi
                // item.tgl_perawatan,
                `<button class="btn btn-primary" value='${item.nomor}' data-toggle="modal" data-target="#newReggg" onclick="sendRequest(this.value)">Edit</button>`,
                `<form action="aplikasi/deleteperipheral.php" method="post">
                    <input type="hidden" name="nomor" value="${item.nomor}" />
                    <button name="tombol" class="btn btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
                </form>`
            ]).draw(false); // Tambahkan tanpa mereset tabel
        });

    })
    .catch(error => {
        console.error('Error:', error);
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('clearFilter').addEventListener('click', function () {
        //console.log("Tombol Reset ditekan - Reload halaman");
        window.location.reload(); // Ini akan merefresh halaman sepenuhnya
    });
});
function exportToExcelV2() {
    var formData = $("#filterForm").serialize();
    var isFilterEmpty = formData === "" || formData.replace(/[^=]/g, "").length === formData.length;

    console.log("Payload yang dikirim:", formData);
    console.log("Apakah filter kosong?", isFilterEmpty);

    $.ajax({
        url: "manager/export_peripheral.php", // Panggil dari folder manager
        type: "POST",
        data: isFilterEmpty ? { all_data: true } : formData,
        success: function(response) {
            console.log("Response dari server:", response);
            window.location.href = "excel/generate_excel_peripheral.php?file=" + response; // Arahkan ke folder excel
        },
        error: function(xhr, status, error) {
            console.log("Error:", error);
            console.log("Response Text:", xhr.responseText);
            alert("Export gagal: " + error);
        }
    });
}
</script>