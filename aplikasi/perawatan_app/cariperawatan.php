<?php
session_start();

// Sertakan file konfigurasi database
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Inisialisasi variabel default
$tahun = date('Y'); // Default tahun saat ini jika tidak ada input
$tipe = '';
$jumlahperawatan = 0;

// Inisialisasi array parameter untuk prepared statement
$params = [];

// Buat query dasar
$query = "SELECT * FROM pcaktif WHERE nomor = 0";

if (!empty($_GET['perangkat'])) {
    $perangkat = $_GET['perangkat'];
    $tahun = $_GET['tahun'] ?? date('Y'); // Gunakan tahun saat ini jika tidak ada
    $bulan = $_GET['bulan'] ?? '';

    // Query untuk mengambil nama perangkat
    $qry = "SELECT nama_perangkat FROM tipe_perawatan WHERE id = ?";
    $stmtQry = sqlsrv_prepare($conn, $qry, [$perangkat]);
    if ($stmtQry === false) {
        die("Persiapan query gagal: " . print_r(sqlsrv_errors(), true));
    }
    if (!sqlsrv_execute($stmtQry)) {
        die("Eksekusi query gagal: " . print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($stmtQry, SQLSRV_FETCH_ASSOC);
    $tipe = strtolower($row['nama_perangkat'] ?? '');
    sqlsrv_free_stmt($stmtQry);

    // Query untuk menghitung jumlah perawatan
    $qryItem = "SELECT id as jumlahperawatan FROM tipe_perawatan_item WHERE tipe_perawatan_id = ?";
    $stmtItem = sqlsrv_prepare($conn, $qryItem, [$perangkat]);
    if ($stmtItem === false) {
        die("Persiapan query gagal: " . print_r(sqlsrv_errors(), true));
    }
    if (!sqlsrv_execute($stmtItem)) {
        die("Eksekusi query gagal: " . print_r(sqlsrv_errors(), true));
    }
    $jumlahperawatan = sqlsrv_num_rows($stmtItem);
    // Jika tidak ada item perawatan, set default minimal 1 perawatan
    if ($jumlahperawatan == 0) {
        $jumlahperawatan = 1; // Default minimal 1 perawatan
    }
    sqlsrv_free_stmt($stmtItem);

    // Debugging: Tampilkan nilai $jumlahperawatan
    // echo "Jumlah Perawatan Diharapkan: $jumlahperawatan<br>";

    // Inisialisasi query utama dengan WHERE 1=1 untuk mempermudah penambahan filter
    if (strtolower($tipe) == 'pc dan laptop') {
        $query = "SELECT 
                    idpc, 
                    user, 
                    lokasi, 
                    model AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = pcaktif.idpc AND YEAR(tanggal_perawatan) = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = pcaktif.idpc AND YEAR(tanggal_perawatan) = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND tahun = ?) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND tahun = ?) AS approve_by
                  FROM pcaktif WHERE 1=1";
        $params = [$tahun, $tahun, $tahun, $tahun, $tahun];
    } else if (strtolower($tipe) == 'printer') {
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, 'printer' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = printer.id_perangkat AND YEAR(tanggal_perawatan) = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = printer.id_perangkat AND YEAR(tanggal_perawatan) = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND tahun = ?) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND tahun = ?) AS approve_by
                  FROM printer WHERE 1=1";
        $params = [$tahun, $tahun, $tahun, $tahun, $tahun];
    } else if (strtolower($tipe) == 'scaner') {
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, 'scaner' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = scaner.id_perangkat AND YEAR(tanggal_perawatan) = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = scaner.id_perangkat AND YEAR(tanggal_perawatan) = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND tahun = ?) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND tahun = ?) AS approve_by
                  FROM scaner WHERE 1=1";
        $params = [$tahun, $tahun, $tahun, $tahun, $tahun];
    } else if (strtolower($tipe) == 'ups') {
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, tipe AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND tahun = ? AND bulan = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ? ORDER BY id DESC) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ?) AS approve_by
                  FROM peripheral WHERE tipe = ? AND 1=1";
        $params = [$tahun, $bulan, $bulan, $tahun, $bulan, $tahun, $bulan, $tahun, $bulan, $tahun, $tipe];
    } else if (strtolower($tipe) == 'server') {
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, tipe AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND tahun = ? AND bulan = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ? ORDER BY id DESC) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ?) AS approve_by
                  FROM peripheral WHERE tipe = ? AND 1=1";
        $params = [$tahun, $bulan, $bulan, $tahun, $bulan, $tahun, $bulan, $tahun, $bulan, $tahun, $tipe];
    } else {
        $query = "SELECT id_perangkat AS idpc, user, lokasi AS lokasi, tipe AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND YEAR(tanggal_perawatan) = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND YEAR(tanggal_perawatan) = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND tahun = ? ORDER BY id DESC) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND tahun = ?) AS approve_by
                  FROM peripheral WHERE tipe = ? AND 1=1";
        $params = [$tahun, $tahun, $tahun, $tahun, $tahun, $tipe];
    }
}

// Filter tambahan
if (!empty($_GET['bulan'])) {
    $bulan = $_GET['bulan'];
    if ((strtolower($tipe) == 'ups' || strtolower($tipe) == 'server') && !empty($_GET['tahun'])) {
        $tahun = $_GET['tahun'];
        $query .= " AND bulan = '00'";
    } else {
        $query .= " AND bulan LIKE ?";
        $params[] = "%$bulan%";
    }
}

if (!empty($_GET['namadivisi'])) {
    $namadivisi = $_GET['namadivisi'];
    if (strtolower($tipe) == 'printer' || strtolower($tipe) == 'scaner') {
        $query .= " AND status LIKE ?";
        $params[] = "%$namadivisi%";
    } else {
        $query .= " AND divisi LIKE ?";
        $params[] = "%$namadivisi%";
    }
}

if (!empty($_GET['perangkat'])) {
    $query .= " ORDER BY tanggal DESC";
}

// Debugging: Tampilkan query untuk memeriksa sintaks (opsional, hapus setelah debugging)
// echo "Query: " . $query . "<br>";
// echo "Params: " . print_r($params, true) . "<br>";

// Persiapkan dan eksekusi query
$stmt = sqlsrv_prepare($conn, $query, $params);
if ($stmt === false) {
    die("Persiapan query gagal: " . print_r(sqlsrv_errors(), true));
}
if (!sqlsrv_execute($stmt)) {
    die("Eksekusi query gagal: " . print_r(sqlsrv_errors(), true));
}

// Hitung jumlah baris
$rowCount = 0;
$result = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $result[] = $row;
    $rowCount++;
}

$output = "";
if ($rowCount > 0) {
    $sudah = 0;
    $sedang = 0;
    $belum = 0;
    foreach ($result as $row) {
        if (strtolower($row['perangkat']) == 'switch/router') {
            if ($row['hitung'] >= 2) {
                $sudah++;
                $output .= "<tr style='background-color:#d4edda;'>";
            } else if ($row['hitung'] < 2 && $row['hitung'] > 0) {
                $sedang++;
                $output .= "<tr style='background-color:#FFFF00;'>";
            } else {
                $belum++;
                $output .= "<tr>";
            }
        } else if (strtolower($tipe) == 'ups') {
            if ($row['hitung'] >= 1) {
                $sudah++;
                $output .= "<tr style='background-color:#d4edda;'>"; // Hijau untuk sudah
            } else {
                $belum++;
                $output .= "<tr>";
            }
        } else if (strtolower($tipe) == 'server') {
            if ($row['hitung'] >= 1) {
                $sudah++;
                $output .= "<tr style='background-color:#d4edda;'>"; // Hijau untuk sudah
            } else {
                $belum++;
                $output .= "<tr>";
            }
        } else {
            if ($row['hitung'] == $jumlahperawatan) {
                $sudah++;
                $output .= "<tr style='background-color:#d4edda;'>";
            } else if ($row['hitung'] < $jumlahperawatan && $row['hitung'] > 0) {
                $sedang++;
                $output .= "<tr style='background-color:#FFFF00;'>";
            } else {
                $belum++;
                $output .= "<tr>";
            }
        }
        $output .= "<td>
                    <button type='button' class='btn btn-warning' onclick='showEdit(" . json_encode($row) . ")'>Rawat</button>
                    </td>";
        $output .= "<td>" . htmlspecialchars($row['idpc'], ENT_QUOTES, 'UTF-8') . "</td>";
        $output .= "<td>" . htmlspecialchars($row['user'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
        $output .= "<td>" . htmlspecialchars($row['lokasi'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
        $output .= "<td>" . htmlspecialchars($row['treated_by'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
        $output .= "<td>" . htmlspecialchars($row['keterangan'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
        $output .= "<td>" . strtoupper(htmlspecialchars($row['perangkat'] ?? '', ENT_QUOTES, 'UTF-8')) . "</td>";
        $output .= "</tr>";
    }
    $total = $rowCount;
    $progress = $total > 0 ? ($sudah / $total * 100) : 0; // Hindari pembagian dengan nol
    // $output .= "<tr>";
    // $output .= "<td>" . $sudah . "</td>";
    // $output .= "<td>" . $sedang . "</td>";
    // $output .= "<td>" . $belum . "</td>";
    // $output .= "<td>" . $total . "</td>";
    // if ($progress < 50) {
    //     $output .= "<td style='background-color:#FE6868;'>" . round($progress, 2) . " % </td>";
    // } else if ($progress >= 50) {
    //     $output .= "<td style='background-color:#59F2ED;'>" . round($progress, 2) . " % </td>";
    // }
    // $output .= "</tr>";
} else {
    $output .= "<tr><td colspan='5'>Tidak ada data ditemukan.</td></tr>";
}

echo $output;

// Bersihkan resource dan tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>