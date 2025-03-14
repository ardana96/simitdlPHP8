<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Update Perawatan PC</title>

    <!-- JavaScript for preventing Enter key in text fields -->
    <script type="text/javascript">
        function dontEnter(evt) {
            var evt = (evt) ? evt : ((event) ? event : null);
            var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
            if ((evt.keyCode == 13) && (node.type === "text")) {
                return false;
            }
        }
        document.onkeypress = dontEnter;
    </script>

    <!-- Include external JavaScript files -->
    <script language="JavaScript" type="text/javascript" src="suggest.js"></script>

    <!-- Include PHP configuration -->
    <?php
    include(dirname(__DIR__, 3) . "/config.php");
    ?>

    <!-- PHP Logic for Data Retrieval -->
    <?php
    if (isset($_POST['nomor'], $_POST['id'])) {
        $nomor = $_POST['nomor'];
        $id = $_POST['id'];

        $query = "SELECT * FROM pcaktif WHERE nomor = ? AND id = ?";
        $params = [$nomor, $id];
        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt !== false && ($result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))) {
            $nomor = $result['nomor'];
            $user = $result['user'];
            $divisi = $result['divisi'];
            $bagian = $result['bagian'];
            $subbagian = $result['subbagian'];
            $lokasi = $result['lokasi'];
            $idpc = $result['idpc'];
            $ippc = $result['ippc'];
            $os = $result['os'];
            $prosesor = $result['prosesor'];
            $mobo = $result['mobo'];
            $monitor = $result['monitor'];
            $ram = $result['ram'];
            $harddisk = $result['harddisk'];
            $jumlah = $result['jumlah'];
            $tgl_update = $result['tgl_update'];
            $bulan = $result['bulan'];
            $tgl_masuk = $result['tgl_masuk'];
            $ram1 = $result['ram1'];
            $ram2 = $result['ram2'];
            $hd1 = $result['hd1'];
            $hd2 = $result['hd2'];
            $namapc = $result['namapc'];
            $powersuply = $result['powersuply'];
            $cassing = $result['cassing'];
            $dvd = $result['dvd'];
            $model = $result['model'];

            // Fetch month name
            $query_bulan = "SELECT bulan FROM bulan WHERE id_bulan = ?";
            $stmt_bulan = sqlsrv_query($conn, $query_bulan, [$bulan]);

            if ($stmt_bulan !== false && ($dataa = sqlsrv_fetch_array($stmt_bulan, SQLSRV_FETCH_ASSOC))) {
                $namabulan = $dataa['bulan'];
            } else {
                echo "Error mengambil data bulan: " . print_r(sqlsrv_errors(), true) . "<br>";
            }
        } else {
            echo "Error mengambil data PC aktif.<br>";
            if (($errors = sqlsrv_errors()) != null) {
                foreach ($errors as $error) {
                    echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                    echo "Code: " . $error['code'] . "<br>";
                    echo "Message: " . $error['message'] . "<br>";
                }
            }
        }
    } else {
        die("Error: Nomor atau ID tidak ditemukan dalam request.");
    }
    ?>

    <!-- PHP Function for Auto Code Generation -->
    <?php
    $datee = date('Y-m-d');
    $jam = date("H:i");
    $date = date('Y-m-d');

    function kdauto($tabel, $inisial) {
        global $conn;

        // Fetch column structure
        $query_struktur = "
            WITH ColumnInfo AS (
                SELECT 
                    COLUMN_NAME,
                    ROW_NUMBER() OVER (ORDER BY ORDINAL_POSITION) AS RowNum,
                    CHARACTER_MAXIMUM_LENGTH AS ColumnLength
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME = ?
            )
            SELECT 
                ColumnLength AS TotalColumns,
                COLUMN_NAME AS SecondColumnName
            FROM ColumnInfo
            WHERE RowNum = 2;
        ";
        $params_struktur = [$tabel];
        $stmt_struktur = sqlsrv_query($conn, $query_struktur, $params_struktur);

        if ($stmt_struktur === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $field = null;
        $maxLength = null;
        if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
            $field = $row['SecondColumnName'];
            $maxLength = $row['TotalColumns'] ?? $maxLength;
        }
        sqlsrv_free_stmt($stmt_struktur);

        if ($field === null) {
            die("Kolom tidak ditemukan pada tabel: $tabel");
        }

        // Fetch maximum value from the column
        $query_max = "SELECT MAX($field) AS maxKode FROM $tabel";
        $stmt_max = sqlsrv_query($conn, $query_max);

        if ($stmt_max === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $row = sqlsrv_fetch_array($stmt_max, SQLSRV_FETCH_ASSOC);
        $angka = 0;
        if (!empty($row['maxKode'])) {
            $angka = (int)substr($row['maxKode'], strlen($inisial));
        }
        $angka++;

        sqlsrv_free_stmt($stmt_max);

        // Generate new code with padding
        $padLength = $maxLength - strlen($inisial);
        if ($padLength <= 0) {
            die("Panjang padding tidak valid untuk kolom: $field");
        }

        return $inisial . str_pad($angka, $padLength, "0", STR_PAD_LEFT);
    }
    $no_faktur = kdauto("tpengambilan", '');
    ?>

    <!-- Inline CSS Styles -->
    <style type="text/css">
        .isi_tabelll {
            border: 1px;
            font-size: 14pt;
            color: black;
            background-color: #FFF;
        }

        #info_transaksi {
            height: 550px;
            width: 25%;
            float: left;
            background-color: #E8E8E8;
            font-family: Arial, Helvetica, sans-serif;
        }

        #info_user {
            background-color: #CCC;
            height: 450px;
            width: 20%;
            float: left;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10pt;
            color: #000;
            font-weight: bold;
            padding-top: 5px;
        }

        #kalkulator {
            height: 90px;
            width: 100%;
            border-bottom-width: 2px;
            border-bottom-color: #933;
            border-bottom-style: solid;
            padding-left: 10px;
            padding-top: 10px;
        }

        #scanner {
            height: 50px;
            width: 100%;
            border-bottom-width: 2px;
            border-bottom-color: #933;
            border-bottom-style: solid;
            padding-top: 10px;
            padding-left: 10px;
        }

        #button_transaksi {
            height: 45px;
            width: 100%;
            padding-top: 5px;
            padding-left: 10px;
        }

        #data_barang {
            background-color: white;
            height: 450px;
            width: 50%;
            float: left;
            overflow: scroll;
            padding-top: 5px;
        }

        .td_total {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 25px;
            font-weight: bold;
            color: #03F;
            text-decoration: none;
        }

        .td_cash {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 25px;
            font-weight: bold;
            color: #FF0;
            text-decoration: none;
        }

        .td_kembali {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 25px;
            font-weight: bold;
            color: #F00;
            text-decoration: none;
        }

        .tr_header_footer {
            background-color: #09F;
            font-size: 14px;
            color: #FFF;
            font-weight: bold;
            font-family: Arial, Helvetica, sans-serif;
        }

        .tr_isi {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            background-color: #FFF;
        }
    </style>

    <!-- Additional JavaScript for Enter Key Navigation -->
    <script language="javascript">
        function onEnter(e) {
            var key = e.keyCode || e.which;
            var kd_barang = document.getElementById('kd_barang').value;
            var no_faktur = document.getElementById('no_faktur').value;
            if (key === 13) {
                document.location.href = "aplikasi/simpanrincipengeluaran.php?kd_barang=" + kd_barang + "&no_faktur=" + no_faktur;
            }
        }
    </script>
</head>

<body onload="document.getElementById('kd_barang').focus()">
    <h4 align="center">UPDATE PERAWATAN PC</h4>

    <div id="info_transaksi">
        <form id="form_penjualan" method="post" action="aplikasi/pemakaipc/modals/updateperawatanpc.php" enctype="multipart/form-data" name="postform2">
            <div class="form-group">
                Tanggal Perawatan<br>
                <input required="required" type="text" id="from" name="tgl_perawatan" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;" />
                <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
                    <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt="" />
                </a>
            </div>

            <div class="form-group">
                Bulan Perawatan
                <select class="form-control" name="bulan" required>
                    <option value="<?php echo $bulan; ?>"><?php echo $namabulan; ?></option>
                    <?php
                    $sql = "SELECT * FROM bulan ORDER BY id_bulan ASC";
                    $stmt = sqlsrv_query($conn, $sql);
                    while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        echo '<option value="' . $datas['id_bulan'] . '">' . $datas['bulan'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                Bagian
                <select class="form-control" name="bagian" required="required">
                    <option value="<?php echo $bagian; ?>"><?php echo $bagian; ?></option>
                    <?php
                    $query = "SELECT * FROM bagian_pemakai ORDER BY bag_pemakai ASC";
                    $stmt = sqlsrv_query($conn, $query);

                    if ($stmt !== false) {
                        while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $id_bag_pemakai = $datas['id_bag_pemakai'];
                            $bag_pemakai = $datas['bag_pemakai'];
                            ?>
                            <option value="<?php echo $bag_pemakai; ?>"><?php echo $bag_pemakai; ?></option>
                            <?php
                        }
                    } else {
                        echo "Error executing query.<br>";
                        if (($errors = sqlsrv_errors()) != null) {
                            foreach ($errors as $error) {
                                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                                echo "Code: " . $error['code'] . "<br>";
                                echo "Message: " . $error['message'] . "<br>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                Sub Bagian
                <select class="form-control" name="subbagian" required="required">
                    <option value="<?php echo $subbagian; ?>"><?php echo $subbagian; ?></option>
                    <?php
                    $query = "SELECT * FROM sub_bagian ORDER BY subbag_nama ASC";
                    $stmt = sqlsrv_query($conn, $query);

                    if ($stmt !== false) {
                        while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $subbag_id = $datas['subbag_id'];
                            $subbag_nama = $datas['subbag_nama'];
                            ?>
                            <option value="<?php echo $subbag_nama; ?>"><?php echo $subbag_nama; ?></option>
                            <?php
                        }
                    } else {
                        echo "Error executing query.<br>";
                        if (($errors = sqlsrv_errors()) != null) {
                            foreach ($errors as $error) {
                                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                                echo "Code: " . $error['code'] . "<br>";
                                echo "Message: " . $error['message'] . "<br>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                Lokasi
                <select class="form-control" name="lokasi" required="required">
                    <option value="<?php echo $lokasi; ?>"><?php echo $lokasi; ?></option>
                    <?php
                    $query = "SELECT * FROM lokasi ORDER BY lokasi_nama ASC";
                    $stmt = sqlsrv_query($conn, $query);

                    if ($stmt !== false) {
                        while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $lokasi_id = $datas['lokasi_id'];
                            $lokasi_nama = $datas['lokasi_nama'];
                            ?>
                            <option value="<?php echo $lokasi_nama; ?>"><?php echo $lokasi_nama; ?></option>
                            <?php
                        }
                    } else {
                        echo "Error executing query.<br>";
                        if (($errors = sqlsrv_errors()) != null) {
                            foreach ($errors as $error) {
                                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                                echo "Code: " . $error['code'] . "<br>";
                                echo "Message: " . $error['message'] . "<br>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                User
                <input class="form-control" type="text" name="user" value="<?php echo $user; ?>">
            </div>

            <div class="form-group">
                ID Komputer
                <input class="form-control" type="text" name="idpc" value="<?php echo $idpc; ?>">
            </div>

            <div class="form-group">
                Nama Komputer
                <input class="form-control" type="text" name="namapc" value="<?php echo $namapc; ?>">
            </div>
        </div>

        <div id="data_barang" style="overflow: scroll; width: 600px; height: 550px;">
            <div class="panel-body">
                <div class="form-group">
                    <b>Divisi</b>
                    <input readonly class="form-control" type="text" name="divisi" value="<?php echo $divisi; ?>">
                </div>

                <div class="form-group">
                    <b>Monitor</b>
                    <input readonly class="form-control" type="text" name="monitor" value="<?php echo $monitor; ?>">
                </div>

                <div class="form-group">
                    <b>Model</b>
                    <input readonly class="form-control" type="text" name="model" value="<?php echo $model; ?>">
                </div>

                <div class="form-group">
                    <b>Operation System</b>
                    <input readonly class="form-control" type="text" name="os" value="<?php echo $os; ?>">
                </div>

                <div class="form-group">
                    <b>IP Komputer</b>
                    <input readonly class="form-control" type="text" name="ippc" value="<?php echo $ippc; ?>">
                </div>

                <div class="form-group">
                    <b>Total Kapasitas Harddisk</b>
                    <input readonly class="form-control" type="text" name="harddisk" value="<?php echo $harddisk; ?>">
                </div>

                <div class="form-group">
                    <b>Total Kapasitas RAM</b>
                    <input readonly class="form-control" type="text" name="ram" value="<?php echo $ram; ?>">
                </div>

                <div class="form-group">
                    <b>RAM Slot 1</b>
                    <input readonly class="form-control" type="text" name="ram1" value="<?php echo $ram1; ?>">
                </div>

                <div class="form-group">
                    <b>RAM Slot 2</b>
                    <input readonly class="form-control" type="text" name="ram2" value="<?php echo $ram2; ?>">
                </div>

                <div class="form-group">
                    <b>Harddisk Slot 1</b>
                    <input readonly class="form-control" type="text" name="hd1" value="<?php echo $hd1; ?>">
                </div>

                <div class="form-group">
                    <b>Harddisk Slot 2</b>
                    <input readonly class="form-control" type="text" name="hd2" value="<?php echo $hd2; ?>">
                </div>

                <div class="form-group">
                    <b>Motherboard</b>
                    <input readonly class="form-control" type="text" name="mobo" value="<?php echo $mobo; ?>">
                </div>

                <div class="form-group">
                    <b>Prosesor</b>
                    <input readonly class="form-control" type="text" name="prosesor" value="<?php echo $prosesor; ?>">
                </div>

                <div class="form-group">
                    <b>Power Supply</b>
                    <input readonly class="form-control" type="text" name="powersuply" value="<?php echo $powersuply; ?>">
                </div>

                <div class="form-group">
                    <b>Cassing</b>
                    <input readonly class="form-control" type="text" name="cassing" value="<?php echo $cassing; ?>">
                </div>

                <div class="form-group">
                    <b>DVD Internal</b>
                    <input readonly class="form-control" type="text" name="dvd" value="<?php echo $dvd; ?>">
                </div>

                <!-- <input class="form-control" type="hidden" name="nomor" value="<?php echo $nomor; ?>">
                <button name="tombol" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button> -->
                <input class="form-control" type="hidden" name="nomor" value="<?php echo $nomor; ?>">
                <input class="form-control" type="hidden" name="id" value="<?php echo $id; ?>">
                <button name="tombol" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
            </div>
        </div>
    </form>
</div>

<!-- Hidden Calendar Iframe -->
<iframe width="174" height="189" name="gToday:normal:/simitdlPHP8/calender/agenda.js" id="gToday:normal:/simitdlPHP8/calender/agenda.js" src="/simitdlPHP8/calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>
</body>
</html>