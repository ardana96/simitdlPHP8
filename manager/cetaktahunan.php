<?php
session_start();
include('../config.php'); // Menggunakan koneksi SQL Server dari config.php
?>
<style>
#pilih_laporan {
    background-color: #666; height: 30px; width: 100%;
    font-weight: bold; color: #FFF;
    text-transform: capitalize;}
#tampil_laporan {
    height: auto; width: 100%; overflow: auto;
    text-transform: capitalize;}
.judul_laporan {
    font-size: 14pt; font-weight: bold;
    color: #000; text-align: center;}
.header_footer {
    background-color: #999;
    text-align: center; font-weight: bold;}
.isi_laporan {
    font-size: 12pt; color: #000;
    background-color: #FFF;}
.resume_laporan {
    background-color: #333;
    font-weight: bold; color: #FFF;}
@media print {  
    #pilih_laporan {display: none;} 
}
</style>
<?php
$show_all_data = !isset($_POST['button_filter']); // Default ke semua data kecuali filter ditekan
if (isset($_POST['button_filter'])) {
    $bln_akhir = $_POST['bln_akhir'];
    $thn_akhir = $_POST['thn_akhir'];
    $tanggal_akhir_format = $bln_akhir . "-" . $thn_akhir;
    $tanggal = true;
} else {
    $tanggal = false; // Default tidak menunjukkan filter bulan
    $bln_akhir = date('m');
    $thn_akhir = date('Y');
}

// Array untuk nama bulan
$bulan_arr = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];
$namabulan = $bulan_arr[$bln_akhir] ?? '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="pilih_laporan"><table width="95%" border="0" align="center">
  <tr>
    <td align="center"><form id="form_filter" name="form_filter" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
   
    <font color='white'>Bulan Tahun : </font>

    <select name="bln_akhir" size="1" id="bln_akhir">
<?php
for ($i = 1; $i <= 12; $i++) {
    $i_str = str_pad($i, 2, "0", STR_PAD_LEFT);
    echo "<option value=\"$i_str\"" . ($i_str == $bln_akhir ? " selected" : "") . ">$i_str</option>";
}
?>    
    </select>
    <select name="thn_akhir" size="1" id="thn_akhir">
<?php
for ($i = 2013; $i <= date('Y'); $i++) {
    echo "<option value=\"$i\"" . ($i == $thn_akhir ? " selected" : "") . ">$i</option>";
}
?>    
    </select>
   
    <input type="submit" name="button_filter" id="button_filter" value="Filter" />
    <input type="submit" name="button_print" id="button_print" value="Print" onclick="print()" />
    <input type='button' value='Cetak EXCEL' onClick='top.location="cetaktahunanexcel.php"'>
    </form></td>
  </tr>
</table>
</div>
<div id="tampil_laporan"><table width="95%" border="1" align="center">
  <tr>
    <td colspan="6" align="center" class="judul_laporan"><p>KARTU PERSEDIAN BARANG</p>
      <p><?php 
        if ($show_all_data) {
            echo "Semua Data";
        } elseif ($tanggal) {
            echo "Bulan : " . $namabulan . '-' . $thn_akhir;
        }
      ?></p></td>
    </tr>
  <tr class="header_footer">
    <td width="60%">Nama Barang</td>
    <td width="10%">Awal</td>
    <td width="10%">Masuk</td>
    <td width="10%">Keluar</td>
    <td width="10%">Sisa</td>
  </tr>
<?php
// Query untuk mengambil data barang
$query_barang = "SELECT * FROM tbarang WHERE report = 'y' ORDER BY namabarang";
$result_barang = sqlsrv_query($conn, $query_barang);

if ($result_barang === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($datarinci = sqlsrv_fetch_array($result_barang, SQLSRV_FETCH_ASSOC)) {
    $namabarang = $datarinci['namabarang'];
    $idbarang = $datarinci['idbarang'];

    $tambah = 0;
    $kurang = 0;

    // Stock awal dari tbarang
    $query_stock = "SELECT stockawal FROM tbarang WHERE idbarang = ?";
    $result_stock = sqlsrv_query($conn, $query_stock, [$idbarang]);
    $dat = sqlsrv_fetch_array($result_stock, SQLSRV_FETCH_ASSOC);
    $stockk = $dat['stockawal'] ?? 0;

    if ($show_all_data) {
        // Jika semua data, hitung semua pembelian dan pengambilan tanpa filter waktu
        $query_pembelian = "SELECT SUM(trincipembelian.jumlah) AS jumta 
                            FROM tpembelian 
                            INNER JOIN trincipembelian ON tpembelian.nofaktur = trincipembelian.nofaktur 
                            WHERE trincipembelian.idbarang = ?";
        $result_pembelian = sqlsrv_query($conn, $query_pembelian, [$idbarang]);
        $dataa = sqlsrv_fetch_array($result_pembelian, SQLSRV_FETCH_ASSOC);
        $jumm = $dataa['jumta'] ?? 0;

        $query_pengambilan = "SELECT SUM(trincipengambilan.jumlah) AS jumta 
                              FROM tpengambilan 
                              INNER JOIN trincipengambilan ON tpengambilan.nofaktur = trincipengambilan.nofaktur 
                              WHERE trincipengambilan.idbarang = ?";
        $result_pengambilan = sqlsrv_query($conn, $query_pengambilan, [$idbarang]);
        $datab = sqlsrv_fetch_array($result_pengambilan, SQLSRV_FETCH_ASSOC);
        $jummb = $datab['jumta'] ?? 0;

        $stockawal = $stockk; // Stock awal dari tabel
        $tambah = $jumm; // Semua pembelian
        $kurang = $jummb; // Semua pengambilan
    } else {
        // Jika filter bulan dan tahun
        // Jumlah pembelian sampai akhir bulan sebelumnya (untuk stock awal)
        $query_pembelian = "SELECT SUM(trincipembelian.jumlah) AS jumta 
                            FROM tpembelian 
                            INNER JOIN trincipembelian ON tpembelian.nofaktur = trincipembelian.nofaktur 
                            WHERE trincipembelian.idbarang = ? 
                            AND YEAR(tpembelian.tglbeli) <= ? 
                            AND MONTH(tpembelian.tglbeli) < ?";
        $result_pembelian = sqlsrv_query($conn, $query_pembelian, [$idbarang, $thn_akhir, $bln_akhir]);
        $dataa = sqlsrv_fetch_array($result_pembelian, SQLSRV_FETCH_ASSOC);
        $jumm = $dataa['jumta'] ?? 0;

        // Jumlah pengambilan sampai akhir bulan sebelumnya (untuk stock awal)
        $query_pengambilan = "SELECT SUM(trincipengambilan.jumlah) AS jumta 
                              FROM tpengambilan 
                              INNER JOIN trincipengambilan ON tpengambilan.nofaktur = trincipengambilan.nofaktur 
                              WHERE trincipengambilan.idbarang = ? 
                              AND YEAR(tpengambilan.tglambil) <= ? 
                              AND MONTH(tpengambilan.tglambil) < ?";
        $result_pengambilan = sqlsrv_query($conn, $query_pengambilan, [$idbarang, $thn_akhir, $bln_akhir]);
        $datab = sqlsrv_fetch_array($result_pengambilan, SQLSRV_FETCH_ASSOC);
        $jummb = $datab['jumta'] ?? 0;

        $stockawal = $stockk + $jumm - $jummb;

        // Pembelian dalam bulan tertentu
        $query_tambah = "SELECT SUM(trincipembelian.jumlah) AS jumta 
                         FROM tpembelian 
                         INNER JOIN trincipembelian ON tpembelian.nofaktur = trincipembelian.nofaktur 
                         WHERE trincipembelian.idbarang = ? 
                         AND YEAR(tpembelian.tglbeli) = ? 
                         AND MONTH(tpembelian.tglbeli) = ?";
        $result_tambah = sqlsrv_query($conn, $query_tambah, [$idbarang, $thn_akhir, $bln_akhir]);
        $datt = sqlsrv_fetch_array($result_tambah, SQLSRV_FETCH_ASSOC);
        $tambah = $datt['jumta'] ?? 0;

        // Pengambilan dalam bulan tertentu
        $query_kurang = "SELECT SUM(trincipengambilan.jumlah) AS jumta 
                         FROM tpengambilan 
                         INNER JOIN trincipengambilan ON tpengambilan.nofaktur = trincipengambilan.nofaktur 
                         WHERE trincipengambilan.idbarang = ? 
                         AND YEAR(tpengambilan.tglambil) = ? 
                         AND MONTH(tpengambilan.tglambil) = ?";
        $result_kurang = sqlsrv_query($conn, $query_kurang, [$idbarang, $thn_akhir, $bln_akhir]);
        $datttt = sqlsrv_fetch_array($result_kurang, SQLSRV_FETCH_ASSOC);
        $kurang = $datttt['jumta'] ?? 0;
    }

    $sisa = $stockawal + $tambah - $kurang;
?>

<tr class="isi_laporan">
    <td><?php echo htmlspecialchars($namabarang); ?> </td>
    <td align="center"><?php echo $stockawal; ?> </td>
    <td align="center"><?php echo $tambah; ?> </td>
    <td align="center"><?php echo $kurang; ?> </td>
    <td align="center"><?php echo $sisa; ?> </td>
</tr>

<?php } ?>
<tr class="header_footer">
    <td></td>
    <td> </td>
    <td> </td>
    <td> </td>
    <td></td>
</tr>
</table>
</div>
</body>
</html>