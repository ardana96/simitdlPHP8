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
        #pilih_laporan {
            display: none;
        }
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

    // Mengonversi tanggal ke format SQL Server yang konsisten, sesuai SSMS
    $date = date('Y-m-d', strtotime($tanggalbro));

    // Pastikan idbarang sesuai format yang tepat (tanpa spasi, hanya angka, sesuai SSMS)
    $idbarang = trim(preg_replace('/[^0-9]/', '', $idbarang)); // Hanya ambil angka, hapus spasi dan karakter non-numerik
    if (strlen($idbarang) < 15) {
        $idbarang_padded = str_pad($idbarang, 15, '0', STR_PAD_LEFT); // Pastikan panjang 15 digit dengan leading zeros
    } else {
        $idbarang_padded = $idbarang; // Gunakan asli jika sudah cukup panjang
    }

    // Query langsung menyesuaikan dengan SSMS, menggunakan TRIM untuk memastikan kecocokan penuh
    $query_get_faktur = "SELECT * FROM tpembelian 
                         INNER JOIN trincipembelian ON TRIM(tpembelian.nofaktur) = TRIM(trincipembelian.nofaktur) 
                         WHERE CONVERT(date, tpembelian.tglbeli) = ? 
                         AND TRIM(trincipembelian.idbarang) = ?";
    $params_get_faktur = [$date, $idbarang_padded];
    $get_faktur = sqlsrv_query($conn, $query_get_faktur, $params_get_faktur);

    if ($get_faktur === false) {
        die("Query gagal: " . print_r(sqlsrv_errors(), true));
    }

} else {
    $tanggal = false;

    // Query default untuk semua faktur pembelian (tanpa filter)
    $query_get_faktur = "SELECT * FROM tpembelian";
    $get_faktur = sqlsrv_query($conn, $query_get_faktur);

    if ($get_faktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

$total_seluruh_beli = 0;
$total_seluruh_item = 0;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
            <td colspan="9" align="center" class="judul_laporan">
                <p>Laporan Pemasukan Barang</p>
                <p>Tanggal : <?php if ($tanggal == true) echo $tglbaru . " s/d " . $tglbaru; ?></p><br>
            </td>
        </tr>
        <tr class="header_footer">
            <td>No Faktur</td>
            <td>Tanggal</td>
            <td>Supplier</td>
            <td>Nama Barang</td>
            <td>Jumlah</td>
            <td>Permintaan</td>
            <td>Bagian</td>
            <td>Divisi</td>
            <td>Keterangan</td>
        </tr>
        <?php
        // Gunakan while loop untuk menangkap semua baris dari query, tanpa bergantung pada $count_faktur
        if ($get_faktur) {
            $hasData = false;
            while ($faktur = sqlsrv_fetch_array($get_faktur, SQLSRV_FETCH_ASSOC)) {
                $hasData = true;
                $nofaktur = $faktur['nofaktur'];
                $id_user = $faktur['id_user'] ?? '';
                $tglbeli = $faktur['tglbeli'];
                $idsupp = $faktur['idsupp'];
                $keterangan = $faktur['keterangan'] ?? '';
                $namasupp = $faktur['namasupp'] ?? '';
                $atas_nama = $faktur['atas_nama'] ?? '';
                $total_pembelian = $faktur['total_pembelian'] ?? 0;

                // Format tanggal untuk tampilan
                if ($tglbeli instanceof DateTime) {
                    $tglbeliformat = $tglbeli->format('d-m-Y');
                } else {
                    $tglbeliformat = date('d-m-Y', strtotime($tglbeli));
                }

                // Mendapatkan nama supplier dari tabel tsupplier menggunakan SQL Server
                $query_supplier = "SELECT namasupp FROM tsupplier WHERE TRIM(idsupp) = TRIM(?)";
                $params_supplier = [$idsupp];
                $stmt_supplier = sqlsrv_query($conn, $query_supplier, $params_supplier);
                if ($stmt_supplier === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
                $rinci = sqlsrv_fetch_array($stmt_supplier, SQLSRV_FETCH_ASSOC);
                $namasupp = $rinci['namasupp'] ?? 'N/A';

                // Query untuk rincian pembelian menggunakan SQL Server, langsung sesuai SSMS
                $query_get_rinci_pembelian = "SELECT trincipembelian.nofaktur, trincipembelian.idbarang, trincipembelian.namabarang, SUM(trincipembelian.jumlah) AS jumta 
                                              FROM trincipembelian 
                                              WHERE TRIM(trincipembelian.nofaktur) = TRIM(?) AND TRIM(trincipembelian.idbarang) = TRIM(?) 
                                              GROUP BY trincipembelian.nofaktur, trincipembelian.idbarang, trincipembelian.namabarang";
                $params_rinci_pembelian = [$nofaktur, $idbarang_padded];
                $get_rinci_pembelian = sqlsrv_query($conn, $query_get_rinci_pembelian, $params_rinci_pembelian);

                if ($get_rinci_pembelian === false) {
                    die(print_r(sqlsrv_errors(), true));
                }

                $total_item = 0;
                while ($rinci_pembelian = sqlsrv_fetch_array($get_rinci_pembelian, SQLSRV_FETCH_ASSOC)) {
                    $idbarang = $rinci_pembelian['idbarang'];
                    $namabarang = $rinci_pembelian['namabarang'];
                    $jumta = $rinci_pembelian['jumta'] ?? 0;

                    // Mendapatkan data permintaan dari rincipermintaan dan permintaan menggunakan SQL Server
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
                        <td><?php echo htmlspecialchars($tglbeliformat); ?></td>
                        <td><?php echo htmlspecialchars($namasupp); ?></td>
                        <td><?php echo htmlspecialchars($namabarang); ?> </td>
                        <td><?php echo htmlspecialchars($jumta); ?> </td>
                        <td><?php echo htmlspecialchars($nmpeminta); ?> </td>
                        <td><?php echo htmlspecialchars($bagianpeminta); ?> </td>
                        <td><?php echo htmlspecialchars($divisi); ?> </td>
                        <td><?php echo htmlspecialchars($keterangan); ?> </td>
                    </tr>
                    <tr>
                        <td colspan='9'><hr></td>
                    </tr>
                <?php
                    $total_item += $jumta; // Menambahkan jumlah ke total item
                }
                $total_seluruh_beli += $total_pembelian; // Menambahkan total pembelian ke total seluruh
                $total_seluruh_item += $total_item; // Menambahkan total item ke total seluruh
            }

            // Tampilkan pesan "Tidak ada data" hanya jika tidak ada data yang diproses
            if (!$hasData && isset($_GET['tanggal'])) {
        ?>
                <tr class="isi_laporan">
                    <td colspan="9" align="center">Tidak ada data untuk tanggal <?php echo $tglbaru; ?> dan ID Barang <?php echo $idbarang_padded; ?></td>
                </tr>
        <?php
            }
        }
        ?>

    </table>
</div>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:../calender/agenda.js" id="gToday:normal:../calender/agenda.js" src="../calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>