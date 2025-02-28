<?php
session_start();
include('../config.php'); // Menggunakan koneksi SQL Server dari config.php
if (isset($_POST['tombol'])) {
    $tanggalanyar = $_POST['tglbro'];
}
?>

<head>
    <meta charset="UTF-8" />
    <title>Inventory IT</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- GLOBAL STYLES -->
    <script src="../js/pop_up.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../assets/css/main.css" />
    <link rel="stylesheet" href="../assets/css/theme.css" />
    <link rel="stylesheet" href="../assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/plugins/Font-Awesome/css/font-awesome.css" />
    <!-- END GLOBAL STYLES -->

    <!-- PAGE LEVEL STYLES -->
    <link href="../assets/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- END PAGE LEVEL  STYLES -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<script language="JavaScript" type="text/javascript" src="../suggestkartu.js"></script>

<style>
    #pilih_laporan {
        background-color: #666;
        height: 30px;
        width: 100%;
        font-weight: bold;
        color: #FFF;
        text-transform: capitalize;
    }

    #tampil_laporan {
        height: auto;
        width: 100%;
        overflow: auto;
        text-transform: capitalize;
    }

    .judul_laporan {
        font-size: 14pt;
        font-weight: bold;
        color: #000;
        text-align: center;
    }

    .header_footer {
        background-color: #999;
        text-align: center;
        font-weight: bold;
    }

    .isi_laporan {
        font-size: 10pt;
        color: #000;
        background-color: #FFF;
    }

    .resume_laporan {
        background-color: #333;
        font-weight: bold;
        color: #FFF;
    }

    @media print {
        #pilih_laporan {
            display: none;
        }
    }

    /* Menyesuaikan UI filter agar horizontal dan presisi seperti gambar */
    #pilih_laporan table {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px 0; /* Jarak antara bar filter dan tabel */
    }

    #pilih_laporan form {
        display: flex;
        flex-wrap: wrap;
        gap: 5px; /* Jarak presisi antara elemen-elemen filter */
        align-items: center;
    }

    #pilih_laporan font {
        margin-right: 5px;
    }

    #pilih_laporan select, #pilih_laporan input[type="submit"] {
        margin-right: 5px; /* Jarak presisi antara elemen */
    }

    #pilih_laporan input[type="text"] {
        width: 150px; /* Lebar input barang disesuaikan dengan gambar */
        margin-right: 10px;
    }

    #suggestSearch {
        display: inline-flex;
        align-items: center;
    }

    #layer1 {
        position: absolute;
        z-index: 10;
    }

    /* Menyesuaikan struktur tabel agar sesuai gambar */
    #tampil_laporan table td[colspan="8"] {
        padding: 5px;
    }

    #tampil_laporan table .header_footer td {
        padding: 8px;
    }

    #tampil_laporan table .isi_laporan td {
        padding: 5px;
    }
</style>

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

    function sendRequest(barang) {
        if (barang == "") {
            alert("Anda belum memilih barang");
        } else {
            http.open('GET', '../koneksi/ajax.php?barang=' + encodeURIComponent(barang), true);
            http.onreadystatechange = handleResponse;
            http.send(null);
        }
    }

    function handleResponse() {
        if (http.readyState == 4) {
            var string = http.responseText.split('&&&');
            document.getElementById('asfa').value = string[2];
            document.getElementById('www').value = string[0];
        }
    }

    var mywin;

    function popup(tanggal) {
        if (tanggal == "") {
            alert("Anda belum memilih tanggal");
        } else {
            mywin = window.open("lap_pembeliandetail.php?tanggal=" + tanggal + "&idbarang=" + tanggal.split('&')[1].split('=')[1], "_blank", "toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400");
            mywin.moveTo(100, 100);
        }
    }

    function popup2(tanggal) {
        if (tanggal == "") {
            alert("Anda belum memilih tanggal");
        } else {
            mywin = window.open("lap_pengambilandetail.php?tanggal=" + tanggal + "&idbarang=" + tanggal.split('&')[1].split('=')[1], "_blank", "toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400");
            mywin.moveTo(100, 100);
        }
    }
</script>

<?php
if (isset($_POST['button_filter'])) {
    $kd_barang = $_POST['kd_barang'] ?? ''; // Default kosong jika tidak ada
    $bln_akhir = $_POST['bln_akhir'] ?? date('m'); // Default bulan saat ini
    $thn_akhir = $_POST['thn_akhir'] ?? date('Y'); // Default tahun saat ini
    $tanggal = true;
    $tanggaal = $thn_akhir . '-' . $bln_akhir . '-31'; // Menggunakan tanggal akhir bulan (31) sebagai default

    // Mengambil nama barang berdasarkan idbarang menggunakan SQL Server
    $query = "SELECT namabarang FROM tbarang WHERE idbarang = ?";
    $params = [$kd_barang];
    $stmt = sqlsrv_query($conn, $query, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    $namabarangcuy = $row['namabarang'] ?? '';
} else {
    $tanggal = false;
    $bln_akhir = '02'; // Default bulan seperti gambar (Februari)
    $thn_akhir = '2025'; // Default tahun seperti gambar
    $kd_barang = ''; // Default untuk kd_barang jika tidak ada filter
    $namabarangcuy = ''; // Default untuk nama barang jika tidak ada filter
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="pilih_laporan">
    <table width="95%" border="0" align="center">
        <tr>
            <td>
                <form id="form_filter" name="form_filter" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div id="suggestSearch">
                        <font color='white'>Nama Barang :</font>
                        <input name="barang" value="<?php echo htmlspecialchars($namabarangcuy); ?>" type="text" id="dbTxt" alt="Search Criteria" onKeyUp="searchSuggest();" onchange="new sendRequest(this.value)" autocomplete="off" />
                        <div id="layer1" onclick="new sendRequest(this.value)" class="isi_tabelll"></div>
                    </div>
                    <input type="hidden" value="<?php echo htmlspecialchars($kd_barang); ?>" name="kd_barang" id="www" readonly />
                    <input class="form-contro" type="hidden" id="asfa" name="kategori" />
                    <!-- Filter bulan/tahun horizontal -->
                    <font color='white'>Bulan / Tahun :</font>
                    <select name="bln_akhir" size="1" id="bln_akhir">
                        <?php
                        $bln_arr = [
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ];
                        echo "<option value=\"02\" selected>02</option>"; // Default Februari seperti gambar
                        for ($i = 1; $i <= 12; $i++) {
                            $i_str = str_pad($i, 2, "0", STR_PAD_LEFT);
                            if ($i_str != '02') {
                                echo "<option value=\"$i_str\">$i_str</option>";
                            }
                        }
                        ?>
                    </select>
                    <select name="thn_akhir" size="1" id="thn_akhir">
                        <?php
                        echo "<option value=\"2025\" selected>2025</option>"; // Default 2025 seperti gambar
                        for ($i = 2013; $i <= date('Y'); $i++) {
                            if ($i != 2025) {
                                echo "<option value=\"$i\">$i</option>";
                            }
                        }
                        ?>
                    </select>
                    <input type="submit" name="button_filter" id="button_filter" value="Filter" />
                    <input type="submit" name="button_print" id="button_print" value="Print" onclick="print()" />
                </form>
            </td>
        </tr>
    </table>
</div>
<div id="tampil_laporan">
    <table width="95%" border="1" align="center">
        <tr>
            <td colspan="8" align="center" class="judul_laporan">
                <p>KARTU PERSEDIAN BARANG</p>
                <?php
                // Menyesuaikan nama bulan dengan array statis
                $bulan_arr = [
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
                    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
                    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                ];
                $namabulan = $bulan_arr[$bln_akhir] ?? '';
                ?>
                <p>Bulan : <?php if ($tanggal == true) echo $namabulan . '-' . $thn_akhir; ?></p>
            </td>
        </tr>
        <tr>
            <?php
            // Mengambil nama barang berdasarkan kd_barang
            $aa = "SELECT namabarang FROM tbarang WHERE idbarang = ?";
            $params_aa = [$kd_barang];
            $stmt_aa = sqlsrv_query($conn, $aa, $params_aa);
            if ($stmt_aa === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            $dataaa = sqlsrv_fetch_array($stmt_aa, SQLSRV_FETCH_ASSOC);
            $namabarang = $dataaa['namabarang'] ?? '';
            ?>
            <td colspan="8">Nama Barang : <?php echo htmlspecialchars($namabarang); ?></td>
        </tr>
        <tr>
            <td colspan="8">Kode Barang : <?php echo htmlspecialchars($kd_barang); ?></td>
        </tr>
        <tr class="header_footer">
            <td width="20%">Tanggal</td>
            <td width="15%">Awal</td>
            <td width="15%">Masuk</td>
            <td width="10%"> </td>
            <td width="15%">Keluar</td>
            <td width="10%"> </td>
            <td width="15%">Sisa</td>
        </tr>
        <?php
        $tanggall = $thn_akhir . '-' . $bln_akhir . '-01'; // Awal bulan
        $tanggalll = $thn_akhir . '-01-01'; // Awal tahun

        // Stock awal (dari tbarang + transaksi sebelum bulan yang dipilih)
        $query_stock = "SELECT stockawal FROM tbarang WHERE idbarang = ?";
        $stmt_stock = sqlsrv_query($conn, $query_stock, [$kd_barang]);
        if ($stmt_stock === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $dat = sqlsrv_fetch_array($stmt_stock, SQLSRV_FETCH_ASSOC);
        $stockawal = $dat['stockawal'] ?? 0;

        // Jumlah pembelian sampai akhir bulan sebelumnya
        $query_pembelian = "SELECT SUM(trincipembelian.jumlah) AS jumta 
                            FROM tpembelian 
                            INNER JOIN trincipembelian ON tpembelian.nofaktur = trincipembelian.nofaktur 
                            WHERE trincipembelian.idbarang = ? 
                            AND CONVERT(date, tpembelian.tglbeli) < ?";
        $params_pembelian = [$kd_barang, $tanggall];
        $stmt_pembelian = sqlsrv_query($conn, $query_pembelian, $params_pembelian);
        if ($stmt_pembelian === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $dataa = sqlsrv_fetch_array($stmt_pembelian, SQLSRV_FETCH_ASSOC);
        $jumm = $dataa['jumta'] ?? 0;

        // Jumlah pengambilan sampai akhir bulan sebelumnya
        $query_pengambilan = "SELECT SUM(trincipengambilan.jumlah) AS jumta 
                              FROM tpengambilan 
                              INNER JOIN trincipengambilan ON tpengambilan.nofaktur = trincipengambilan.nofaktur 
                              WHERE trincipengambilan.idbarang = ? 
                              AND CONVERT(date, tpengambilan.tglambil) < ?";
        $params_pengambilan = [$kd_barang, $tanggall];
        $stmt_pengambilan = sqlsrv_query($conn, $query_pengambilan, $params_pengambilan);
        if ($stmt_pengambilan === false) {
            die(print_r(sqlsrv_errors(), true));
        }
        $datab = sqlsrv_fetch_array($stmt_pengambilan, SQLSRV_FETCH_ASSOC);
        $jummb = $datab['jumta'] ?? 0;

        $stockk = $stockawal + $jumm - $jummb; // Stock awal untuk bulan yang dipilih

        // Mengeluarkan tanggal berdasarkan bulan yang dipilih
        $query_tanggal = "SELECT DISTINCT CONVERT(date, tpembelian.tglbeli) AS tgll 
                          FROM tpembelian 
                          WHERE YEAR(tpembelian.tglbeli) = ? 
                          AND MONTH(tpembelian.tglbeli) = ? 
                          UNION 
                          SELECT DISTINCT CONVERT(date, tpengambilan.tglambil) AS tgll 
                          FROM tpengambilan 
                          WHERE YEAR(tpengambilan.tglambil) = ? 
                          AND MONTH(tpengambilan.tglambil) = ? 
                          ORDER BY tgll ASC";
        $params_tanggal = [$thn_akhir, $bln_akhir, $thn_akhir, $bln_akhir];
        $stmt_tanggal = sqlsrv_query($conn, $query_tanggal, $params_tanggal);
        if ($stmt_tanggal === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $jumtambah = 0; // Inisialisasi total Masuk
        $jumkurang = 0; // Inisialisasi total Keluar

        while ($datarinci = sqlsrv_fetch_array($stmt_tanggal, SQLSRV_FETCH_ASSOC)) {
            $tgll = $datarinci['tgll'];
            if ($tgll instanceof DateTime) {
                $tgll = $tgll->format('d'); // Ambil hanya tanggal
            } else {
                $tgll = date('d', strtotime($tgll)); // Pastikan format tanggal
            }
            $tanggal = $thn_akhir . '-' . $bln_akhir . '-' . $tgll;

            // Mengeluarkan data pembelian berdasarkan tanggal
            $query_pembelian_harian = "SELECT SUM(trincipembelian.jumlah) AS jumta 
                                      FROM tpembelian 
                                      INNER JOIN trincipembelian ON tpembelian.nofaktur = trincipembelian.nofaktur 
                                      WHERE trincipembelian.idbarang = ? 
                                      AND CONVERT(date, tpembelian.tglbeli) = ?";
            $params_pembelian_harian = [$kd_barang, $tanggal];
            $stmt_pembelian_harian = sqlsrv_query($conn, $query_pembelian_harian, $params_pembelian_harian);
            if ($stmt_pembelian_harian === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            $datarinciiii = sqlsrv_fetch_array($stmt_pembelian_harian, SQLSRV_FETCH_ASSOC);
            $jumta = $datarinciiii['jumta'] ?? 0;
            $jumtambah += $jumta; // Tambahkan ke total Masuk

            // Mengeluarkan jumlah pengambilan berdasarkan tanggal
            $query_pengambilan_harian = "SELECT SUM(trincipengambilan.jumlah) AS jumtaa 
                                         FROM tpengambilan 
                                         INNER JOIN trincipengambilan ON tpengambilan.nofaktur = trincipengambilan.nofaktur 
                                         WHERE trincipengambilan.idbarang = ? 
                                         AND CONVERT(date, tpengambilan.tglambil) = ?";
            $params_pengambilan_harian = [$kd_barang, $tanggal];
            $stmt_pengambilan_harian = sqlsrv_query($conn, $query_pengambilan_harian, $params_pengambilan_harian);
            if ($stmt_pengambilan_harian === false) {
                die(print_r(sqlsrv_errors(), true));
            }
            $datarinc = sqlsrv_fetch_array($stmt_pengambilan_harian, SQLSRV_FETCH_ASSOC);
            $jumtaa = $datarinc['jumtaa'] ?? 0;
            $jumkurang += $jumtaa; // Tambahkan ke total Keluar

            $stockk = $stockk + $jumtambah - $jumkurang;
            $awal = $stockk - $jumtambah + $jumkurang;

            if ($jumta == 0 && $jumtaa == 0) {
                continue; // Skip jika tidak ada transaksi
            } else {
        ?>
                <tr class="isi_laporan">
                    <td align="center"><?php echo $tgll; ?> </td>
                    <td align="center"><?php echo $awal; ?> </td>
                    <td align="center"><?php echo $jumta; ?> </td>
                    <td align="center">
                        <button class="btn btn-primary" value="<?php echo $tanggal . '&idbarang=' . $kd_barang; ?>" onclick="popup(this.value)" name='tombol'>
                            Detail(+)
                        </button>
                    </td>
                    <td align="center"><?php echo $jumtaa; ?> </td>
                    <td align="center">
                        <button class="btn btn-primary" value="<?php echo $tanggal . '&idbarang=' . $kd_barang; ?>" onclick="popup2(this.value)" name='tombol'>
                            Detail(-)
                        </button>
                    </td>
                    <td align="center"><?php echo $stockk; ?> </td>
                </tr>
        <?php
            }
        }
        ?>
        <tr>
            <td colspan='7'>Rincian Total</td>
        </tr>
        <tr class="isi_laporan">
            <td align="center"><?php echo '1 s/d 31'; ?> </td>
            <td align="center"><?php echo $stockawal; ?> </td>
            <td align="center"><?php echo $jumtambah; ?> </td>
            <td align="center"> </td>
            <td align="center"><?php echo $jumkurang; ?> </td>
            <td align="center"> </td>
            <td align="center"><?php echo $stockk; ?> </td>
        </tr>
        <tr class="header_footer">
            <td colspan="7"> </td>
        </tr>
    </table>
</div>
</body>
</html>

<script src="../assets/plugins/jquery-2.0.3.min.js"></script>
<script src="../assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/plugins/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<!-- END GLOBAL SCRIPTS -->
<!-- PAGE LEVEL SCRIPTS -->
<script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
<script src="../assets/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
</script>
<div class="col-lg-12">
    <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="H4"> Tambah Bagian untuk pengambilan Barang</h4>
                </div>
                <div class="modal-body">
                    <form action="aplikasi/simpanbagian.php" method="post" enctype="multipart/form-data" name="postform2">
                        <?php
                        if (isset($tanggalanyar)) {
                            $query_oo = "SELECT nofaktur, idsupp FROM tpembelian WHERE tglbeli = ?";
                            $params_oo = [$tanggalanyar];
                            $stmt_oo = sqlsrv_query($conn, $query_oo, $params_oo);
                            if ($stmt_oo === false) {
                                die(print_r(sqlsrv_errors(), true));
                            }
                            while ($dataoo = sqlsrv_fetch_array($stmt_oo, SQLSRV_FETCH_ASSOC)) {
                                $nofaktur = $dataoo['nofaktur'];
                                $idsupp = $dataoo['idsupp'];
                                echo $nofaktur;
                            }
                        }
                        ?>
                        <div class="form-group">
                            <input placeholder="Nama Bagian" class="form-control" type="text" name="bagian">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger" name='tombol'>Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>