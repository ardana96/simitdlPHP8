<?php
session_start();
include('../config.php');

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
}
$nomorprinter=kdauto("printer",'');
$nomorscanner=kdauto("scaner",'');




if (isset($_POST['button_selesai'])) {
    $no_faktur = $_POST['no_faktur'];
    $tglambil = $_POST['tglambil'];
    $jam = $_POST['jam'];
    $nomor = $_POST['nomor'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $divisi = $_POST['divisi'];
    // $tahun = substr($tglambil, -4, 4);
    // $bulan = substr($tglambil, -7, 2);
    // $tanggal = substr($tglambil, 0, 2);
    //$tglbaru = $tahun . '-' . $bulan . '-' . $tanggal;

    $jenisprinter = $_POST['jenisprinter'];
    $id_perangkat = $_POST['id_perangkat'];
    $printer = $_POST['printer'];
    $keterangan = $_POST['keterangan'];
    $ketlokasi = $_POST['ketlokasi'];

    // Insert tpengambilan
    $query = "INSERT INTO tpengambilan (nofaktur, tglambil, jam, nama, bagian, divisi, keterangan) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = array($no_faktur, $tglambil, $jam, $nama, $bagian, $divisi, $keterangan);
    $insert = sqlsrv_query($conn, $query, $params);

    if ($nomor != "") {
        // Memproses permintaan
        $cek = "SELECT * FROM trincipengambilan WHERE nofaktur = ?";
        $cek_params = array($no_faktur);
        $cek_stmt = sqlsrv_query($conn, $cek, $cek_params);

        while ($result = sqlsrv_fetch_array($cek_stmt, SQLSRV_FETCH_ASSOC)) {
            $namabarang = $result['namabarang'];
            $jumlah = $result['jumlah'];

            $perintah = "INSERT INTO rincipermintaan (nomor, nofaktur, namabarang, qtykeluar, tanggal) 
                         VALUES (?, ?, ?, ?, ?)";
            $perintah_params = array($nomor, $no_faktur, $namabarang, $jumlah, $tglambil);
            sqlsrv_query($conn, $perintah, $perintah_params);
        }

        // Update status
        $cstatus = "SELECT SUM(qtymasuk) as totalmasuk, SUM(qtykeluar) as totalkeluar 
                    FROM rincipermintaan WHERE nomor = ?";
        $cstatus_params = array($nomor);
        $cstatus_stmt = sqlsrv_query($conn, $cstatus, $cstatus_params);
        $totalkeluar = 0;

        while ($result = sqlsrv_fetch_array($cstatus_stmt, SQLSRV_FETCH_ASSOC)) {
            $totalkeluar = $result['totalkeluar'];
        }

        $ccstatus = "SELECT * FROM permintaan WHERE nomor = ?";
        $ccstatus_params = array($nomor);
        $ccstatus_stmt = sqlsrv_query($conn, $ccstatus, $ccstatus_params);
        $totalpermintaan = 0;

        while ($result = sqlsrv_fetch_array($ccstatus_stmt, SQLSRV_FETCH_ASSOC)) {
            $totalpermintaan = $result['qty'];
        }

        if ($totalpermintaan == $totalkeluar) {
            $upstatus = "UPDATE permintaan SET status = 'SELESAI' WHERE nomor = ?";
            sqlsrv_query($conn, $upstatus, $ccstatus_params);
        }
    }

    // Insert printer atau scanner
    if ($jenisprinter == "printer") {
        $insprinter = "INSERT INTO printer (nomor, id_perangkat, printer, keterangan, status) 
                       VALUES (?, ?, ?, ?, ?)";
        $printer_params = array($nomorprinter, $id_perangkat, $printer, $ketlokasi, $divisi);
        sqlsrv_query($conn, $insprinter, $printer_params);
    }

    if ($jenisprinter == "scanner") {
        $insprinter = "INSERT INTO scaner (nomor, id_perangkat, printer, keterangan, status) 
                       VALUES (?, ?, ?, ?, ?)";
        $scanner_params = array($nomorscanner, $id_perangkat, $printer, $ketlokasi, $divisi);
        sqlsrv_query($conn, $insprinter, $scanner_params);
    }

    // Update sesi
    $dd = "UPDATE trincipengambilan SET sesi = '' WHERE sesi = 'ADM'";
    sqlsrv_query($conn, $dd);

    // Redirect jika berhasil
    if ($insert) {
        header('Location: ../user.php?menu=keluar');
    } else {
        echo "Transaksi gagal: " . print_r(sqlsrv_errors(), true);
    }
} else {
    header('Location: ../user.php?menu=keluar');
}
?>