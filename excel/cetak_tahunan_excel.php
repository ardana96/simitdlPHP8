<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Stock.xls"); // Nama file tetap sama
header("Pragma: no-cache");
header("Expires: 0");

include('../config.php'); // Koneksi ke SQL Server

if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil input dari form, tanpa logika default semua data
$bln_akhir = $_POST['bln_akhir'] ?? date('m'); // Jika tidak ada input, gunakan bulan saat ini
$thn_akhir = $_POST['thn_akhir'] ?? date('Y'); // Jika tidak ada input, gunakan tahun saat ini
$tanggal_akhir_format = $bln_akhir . "-" . $thn_akhir;
$tanggal = isset($_POST['simpan']); // Cek apakah form disubmit, sesuai tombol "DOWNLOAD EXCEL"

// Array untuk nama bulan, sesuai form input
$bulan_arr = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
    '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
    '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
];
$namabulan = $bulan_arr[$bln_akhir] ?? '';
?>
<!-- Style untuk Excel, tetap dipertahankan -->
<style>
.warna {background-color: #D3D3D3;}
</style>
<table width="100%" cellpadding="3" cellspacing="0" border="1">
<tr>
    <!-- Judul menyesuaikan input dari form -->
    <th align="center" colspan="6"><h2>LAPORAN STOCK</h2>
        <?php 
        if ($tanggal) {
            echo "Bulan : " . $namabulan . '-' . $thn_akhir;
        } else {
            echo "Data Saat Ini"; // Jika tidak ada input dari form
        }
        ?>
    </th>
</tr>
<tr class="warna">
    <th>Divisi</th>
    <th>Nama Barang</th>
    <th>Awal</th>
    <th>Masuk</th>
    <th>Keluar</th>
    <th>Sisa</th>
</tr>
<?php
// Query untuk mengambil data barang, menyesuaikan filter dari form
$query_barang = "SELECT tbarang.*, tpengambilan.divisi 
                 FROM tbarang 
                 LEFT JOIN trincipengambilan ON tbarang.idbarang = trincipengambilan.idbarang 
                 LEFT JOIN tpengambilan ON trincipengambilan.nofaktur = tpengambilan.nofaktur 
                 WHERE tbarang.report = 'y'";
$params = [];

// Jika form disubmit, terapkan filter bulan dan tahun
if ($tanggal) {
    $query_barang .= " AND (tpengambilan.tglambil IS NULL OR (YEAR(tpengambilan.tglambil) = ? AND MONTH(tpengambilan.tglambil) = ?))";
    $params = [$thn_akhir, $bln_akhir];
}

$query_barang .= " GROUP BY tbarang.id, tbarang.idbarang, tbarang.barcode, tbarang.idkategori, 
                  tbarang.namabarang, tbarang.stockawal, tbarang.stock, tbarang.inventory, 
                  tbarang.refil, tbarang.status, tbarang.keterangan, tbarang.cek, 
                  tbarang.rutin, tbarang.report, tpengambilan.divisi 
                  ORDER BY tpengambilan.divisi, tbarang.namabarang";
$result_barang = sqlsrv_query($conn, $query_barang, $params);

if (!$result_barang) {
    die(print_r(sqlsrv_errors(), true));
}

while ($datarinci = sqlsrv_fetch_array($result_barang, SQLSRV_FETCH_ASSOC)) {
    $divisi_barang = $datarinci['divisi'] ?? 'N/A';
    $namabarang = $datarinci['namabarang'];
    $idbarang = $datarinci['idbarang'];

    $tambah = 0;
    $kurang = 0;

    // Stock awal dari tbarang
    $query_stock = "SELECT stockawal FROM tbarang WHERE idbarang = ?";
    $result_stock = sqlsrv_query($conn, $query_stock, [$idbarang]);
    $dat = sqlsrv_fetch_array($result_stock, SQLSRV_FETCH_ASSOC);
    $stockk = $dat['stockawal'] ?? 0;

    if (!$tanggal) {
        // Jika tidak ada filter dari form, hitung semua data hingga saat ini
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
        // Jika ada filter dari form (bulan dan tahun)
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

        $stockawal = $stockk + $jumm - $jummb; // Stock awal dengan transaksi sebelum bulan yang dipilih

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

    $sisa = $stockawal + $tambah - $kurang; // Perhitungan sisa
?>
<tr class="isi_tabel">
    <td align="left" valign="top"><?php echo htmlspecialchars($divisi_barang); ?></td>
    <td align="left" valign="top"><?php echo htmlspecialchars($namabarang); ?></td>
    <td align="left" valign="top"><?php echo $stockawal; ?></td>
    <td align="left" valign="top"><?php echo $tambah; ?></td>
    <td align="left" valign="top"><?php echo $kurang; ?></td>
    <td align="left" valign="top"><?php echo $sisa; ?></td>
</tr>
<?php } ?>
</table>