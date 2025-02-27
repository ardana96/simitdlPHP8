<?php
session_start();
include('../config.php'); // Menggunakan koneksi SQL Server dari config.php
?>

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
        #pilih_laporan { display: none; }
    }

    .hidden {
        display: none;
    }

    .visible {
        display: block;
    }
</style>

<?php
if (isset($_GET['tanggal'])) {
    $tanggalbro = $_GET['tanggal'];
    $idbarang = $_GET['idbarang'];

    $tahun = substr($tanggalbro, 0, 4);
    $bulan = substr($tanggalbro, -5, 2);
    $tanggal = substr($tanggalbro, -2, 2);
    $tglbaru = $tanggal . '-' . $bulan . '-' . $tahun;

    $tanggal = true;

    // Mengonversi tanggal ke format SQL Server
    $date = date('Y-m-d', strtotime($tanggalbro));

    // Pastikan idbarang sesuai format (15 digit dengan leading zeros)
    $idbarang = trim(preg_replace('/[^0-9]/', '', $idbarang)); // Hanya ambil angka
    if (strlen($idbarang) < 15) {
        $idbarang_padded = str_pad($idbarang, 15, '0', STR_PAD_LEFT);
    } else {
        $idbarang_padded = $idbarang;
    }

    // Debugging: Cetak parameter untuk memeriksa
    error_log("Tanggal: $date, ID Barang: $idbarang_padded");

    // Query utama dengan LEFT JOIN dan LIKE
    $query_get_faktur = "SELECT * FROM tpengambilan 
                         INNER JOIN trincipengambilan ON tpengambilan.nofaktur = trincipengambilan.nofaktur
                         LEFT JOIN bagian ON tpengambilan.bagian = bagian.id_bagian 
                         WHERE CONVERT(date, tpengambilan.tglambil) = ? 
                         AND trincipengambilan.idbarang LIKE ?";
    $params_get_faktur = [$date, '%' . $idbarang_padded . '%'];
    $get_faktur = sqlsrv_query($conn, $query_get_faktur, $params_get_faktur);

    if ($get_faktur === false) {
        die("Query gagal: " . print_r(sqlsrv_errors(), true));
    } else {
        // Simpan hasil query ke array untuk digunakan kembali
        $results = [];
        while ($row = sqlsrv_fetch_array($get_faktur, SQLSRV_FETCH_ASSOC)) {
            $results[] = $row;
        }

        // Debugging: Tampilkan hasil query di hide dengan kelas hidden
        $debugClass = 'hidden';
        // Jika parameter debug=1 ada di URL, tampilkan hasil query
        if (isset($_GET['debug']) && $_GET['debug'] == 1) {
            $debugClass = 'visible';
        }

        echo "<pre class='$debugClass'>";
        echo "Hasil Query SQL Server:\n";
        if (empty($results)) {
            echo "Tidak ada data untuk tanggal $tglbaru dan ID Barang $idbarang_padded\n";
        } else {
            print_r($results);
        }
        echo "</pre>";
    }
} else {
    $tanggal = false;

    // Query default untuk semua data pengambilan
    $query_get_faktur = "SELECT * FROM tpengambilan";
    $get_faktur = sqlsrv_query($conn, $query_get_faktur);

    if ($get_faktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Simpan hasil query ke array
    $results = [];
    while ($row = sqlsrv_fetch_array($get_faktur, SQLSRV_FETCH_ASSOC)) {
        $results[] = $row;
    }
}

$total_seluruh_beli = 0;
$total_seluruh_item = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitionals.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>
    <link href="../css/laporan.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="tampil_laporan">
    <table width="95%" border="0" align="center">
        <tr>
            <td colspan="8" align="center" class="judul_laporan">
                <p>Laporan Pengambilan</p>
                <p>Tanggal : <?php if ($tanggal == true) echo $tglbaru . " s/d " . $tglbaru; ?></p><br>
            </td>
        </tr>
        <tr class="header_footer">
            <td>No Faktur</td>
            <td>Tanggal</td>
            <td>Pengambil</td>
            <td>Nama Barang</td>
            <td>Jumlah</td>
            <td>Permintaan</td>
            <td>Bagian</td>
            <td>Divisi</td>
        </tr>
        <?php
        if (isset($results) && !empty($results)) {
            $hasData = false;
            foreach ($results as $faktur) {
                $hasData = true;
                $nofaktur = $faktur['nofaktur'];
                $id_user = $faktur['id_user'] ?? '';
                $tglambil = $faktur['tglambil'];
                $idsupp = $faktur['idsupp'] ?? '';
                $nama = $faktur['nama'] ?? '';
                $bagian = $faktur['bagian'] ?? '';
                $divisi = $faktur['divisi'] ?? '';
                $total_pembelian = $faktur['total_pembelian'] ?? 0;

                // Format tanggal untuk tampilan
                if ($tglambil instanceof DateTime) {
                    $tglambilformat = $tglambil->format('d-m-Y');
                } else {
                    $tglambilformat = date('d-m-Y', strtotime($tglambil));
                }

                // Query untuk rincian pengambilan
                $query_get_rinci_pengambilan = "SELECT trincipengambilan.nofaktur, trincipengambilan.idbarang, trincipengambilan.namabarang, SUM(trincipengambilan.jumlah) AS jumta 
                                                FROM trincipengambilan 
                                                WHERE trincipengambilan.nofaktur = ? AND trincipengambilan.idbarang LIKE ? 
                                                GROUP BY trincipengambilan.nofaktur, trincipengambilan.idbarang, trincipengambilan.namabarang";
                $params_rinci_pengambilan = [$nofaktur, '%' . $idbarang_padded . '%'];
                $get_rinci_pengambilan = sqlsrv_query($conn, $query_get_rinci_pengambilan, $params_rinci_pengambilan);

                if ($get_rinci_pengambilan === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                $total_item = 0;
                while ($rinci_pengambilan = sqlsrv_fetch_array($get_rinci_pengambilan, SQLSRV_FETCH_ASSOC)) {
                    $idbarang = $rinci_pengambilan['idbarang'];
                    $namabarang = $rinci_pengambilan['namabarang'];
                    $jumta = $rinci_pengambilan['jumta'] ?? 0;

                    // Mendapatkan data permintaan
                    $query_minta = "SELECT nomor FROM rincipermintaan WHERE TRIM(nofaktur) = TRIM(?)";
                    $params_minta = [$nofaktur];
                    $minta = sqlsrv_query($conn, $query_minta, $params_minta);
                    if ($minta === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }
                    $dminta = sqlsrv_fetch_array($minta, SQLSRV_FETCH_ASSOC);
                    $nomorminta = $dminta['nomor'] ?? '';

                    $query_peminta = "SELECT nama, bagian, divisi FROM permintaan WHERE TRIM(nomor) = TRIM(?)";
                    $params_peminta = [$nomorminta];
                    $peminta = sqlsrv_query($conn, $query_peminta, $params_peminta);
                    if ($peminta === false) {
                        die(print_r(sqlsrv_errors(), true));
                    }
                    $dpeminta = sqlsrv_fetch_array($peminta, SQLSRV_FETCH_ASSOC);
                    $nmpeminta = $dpeminta['nama'] ?? '';
                    $bagianpeminta = $dpeminta['bagian'] ?? '';
                    $divisi = $dpeminta['divisi'] ?? '';
                    ?>
                    <tr class="isi_laporan">
                        <td><?php echo htmlspecialchars($nofaktur); ?></td>
                        <td><?php echo htmlspecialchars($tglambilformat); ?></td>
                        <td><?php echo htmlspecialchars($nama . '/' . $bagian . '/' . $divisi); ?></td>
                        <td><?php echo htmlspecialchars($namabarang); ?></td>
                        <td><?php echo htmlspecialchars($jumta); ?></td>
                        <td><?php echo htmlspecialchars($nmpeminta); ?></td>
                        <td><?php echo htmlspecialchars($bagianpeminta); ?></td>
                        <td><?php echo htmlspecialchars($divisi); ?></td>
                    </tr>
                    <tr>
                        <td colspan='8'><hr></td>
                    </tr>
                    <?php
                    $total_item += $jumta;
                }
                $total_seluruh_beli += $total_pembelian;
                $total_seluruh_item += $total_item;
            }

            // Tampilkan pesan "Tidak ada data" hanya jika benar-benar tidak ada data
            if (!$hasData && isset($_GET['tanggal'])) {
                ?>
                <tr class="isi_laporan">
                    <td colspan="8" align="center">Tidak ada data untuk tanggal <?php echo $tglbaru; ?> dan ID Barang <?php echo $idbarang_padded; ?></td>
                </tr>
                <?php
            }
        } else if (isset($_GET['tanggal'])) {
            // Tambahkan pesan "Tidak ada data" di tabel jika $results kosong
            ?>
            <tr class="isi_laporan">
                <td colspan="8" align="center">Tidak ada data untuk tanggal <?php echo $tglbaru; ?> dan ID Barang <?php echo $idbarang_padded; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
</body>
</html>
<iframe width="174" height="189" name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;"></iframe>