<?php
session_start();

// Sertakan file konfigurasi database
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Inisialisasi variabel default
$tahun = date('Y');
$tipe = '';
$jumlahperawatan = 0;
$params = [];
$query = "SELECT * FROM pcaktif WHERE nomor = 0";

if (!empty($_GET['perangkat'])) {
    $perangkat = $_GET['perangkat'];
    $tahun = $_GET['tahun'] ?? date('Y');
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
    // $jumlahperawatan = 0;
    // while (sqlsrv_fetch($stmtItem)) {
    //     $jumlahperawatan++;
    // }
    // if ($jumlahperawatan == 0) {
    //     $jumlahperawatan = 7; // Default target untuk PC dan Laptop adalah 4
    // }
    $jumlahperawatan = 0;
    while (sqlsrv_fetch($stmtItem)) {
        $jumlahperawatan++;
    }


    // Log untuk debugging
    error_log("Jumlah Perawatan untuk perangkat ID $perangkat: $jumlahperawatan");
    sqlsrv_free_stmt($stmtItem);

    // Inisialisasi query utama
    if (strtolower($tipe) == 'pc dan laptop') {
        $query = "SELECT 
                    idpc, 
                    [user], 
                    lokasi, 
                    model AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = pcaktif.idpc AND tahun= ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = pcaktif.idpc AND tahun = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND tahun = ?) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = pcaktif.idpc AND tahun = ?) AS approve_by
                  FROM pcaktif WHERE 1=1";
        $params = [$tahun, $tahun, $tahun, $tahun, $tahun];
    } else if (strtolower($tipe) == 'printer') {
        $query = "SELECT id_perangkat AS idpc, [user], lokasi AS lokasi, 'printer' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = printer.id_perangkat AND tahun = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = printer.id_perangkat AND tahun = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND tahun = ?) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = printer.id_perangkat AND tahun = ?) AS approve_by
                  FROM printer WHERE 1=1";
        $params = [$tahun, $tahun, $tahun, $tahun, $tahun];
    } else if (strtolower($tipe) == 'scaner') {
        $query = "SELECT id_perangkat AS idpc, [user], lokasi AS lokasi, 'scaner' AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = scaner.id_perangkat AND tahun = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = scaner.id_perangkat AND tahun = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND tahun = ?) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = scaner.id_perangkat AND tahun = ?) AS approve_by
                  FROM scaner WHERE 1=1";
        $params = [$tahun, $tahun, $tahun, $tahun, $tahun];
    } else if (strtolower($tipe) == 'ups') {
        $query = "SELECT id_perangkat AS idpc, [user], lokasi AS lokasi, tipe AS perangkat,
                    (
                        SELECT COUNT(*) FROM perawatan 
                        WHERE perawatan.idpc = peripheral.id_perangkat 
                        AND tahun = ? 
                        AND bulan = ?
                    )AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ? ORDER BY id DESC) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ?) AS approve_by
                  FROM peripheral WHERE tipe = ? AND 1=1";
        $params = [$tahun, $bulan, $bulan, $tahun, $bulan, $tahun, $bulan, $tahun, $bulan, $tahun, $tipe];
    } else if (strtolower($tipe) == 'server') {
        $query = "SELECT id_perangkat AS idpc, [user], lokasi AS lokasi, tipe AS perangkat,
                     (
                        SELECT COUNT(*) FROM perawatan 
                        WHERE perawatan.idpc = peripheral.id_perangkat 
                        AND tahun = ? 
                        AND bulan = ?
                    )  AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ?) AS tanggal,
                    (SELECT TOP 1 ket FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ? ORDER BY id DESC) AS keterangan,
                    (SELECT TOP 1 treated_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ? ORDER BY id DESC) AS treated_by,
                    (SELECT TOP 1 approve_by FROM ket_perawatan WHERE ket_perawatan.idpc = peripheral.id_perangkat AND bulan = ? AND tahun = ?) AS approve_by
                  FROM peripheral WHERE tipe = ? AND 1=1";
        $params = [$tahun, $bulan, $bulan, $tahun, $bulan, $tahun, $bulan, $tahun, $bulan, $tahun, $tipe];
    } else {
        $query = "SELECT id_perangkat AS idpc, [user], lokasi AS lokasi, tipe AS perangkat,
                    (SELECT COUNT(*) FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND tahun = ?) AS hitung,
                    (SELECT TOP 1 tanggal_perawatan FROM perawatan WHERE perawatan.idpc = peripheral.id_perangkat AND tahun = ?) AS tanggal,
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
        // Tentukan target berdasarkan tipe perangkat
        $targetPerawatan = $jumlahperawatan; // Default target
        if (strtolower($row['perangkat']) == 'switch/router') {
            $targetPerawatan = 3; // Target khusus untuk switch/router
        } elseif (strtolower($row['perangkat']) == 'ups' || strtolower($row['perangkat']) == 'server') {
            $targetPerawatan = 4; // Target khusus untuk ups dan server (perawatan bulanan)
        }

        // Log untuk debugging
        error_log("Perangkat: " . $row['perangkat'] . ", Hitung: " . $row['hitung'] . ", Target: " . $targetPerawatan);
        echo "Perangkat: " . $row['perangkat'] . ", Hitung: " . $row['hitung'] . ", Target: " . $targetPerawatan;
        // Logika warna berdasarkan tipe perangkat
        if (strtolower($row['perangkat']) == 'switch/router') {
            if ($row['hitung'] > 2) { // Hijau hanya jika lebih dari 2
                $sudah++;
                $output .= "<tr style='background-color:#d4edda;'>"; // Hijau: Selesai (> 2)
            } else if ($row['hitung'] <= 2 && $row['hitung'] > 0) {
                $sedang++;
                $output .= "<tr style='background-color:#FFFF00;'>"; // Kuning: Sedang (<= 2 tapi > 0)
            } else {
                $belum++;
                $output .= "<tr>"; // Default: Belum (0)
            }
        } elseif (strtolower($row['perangkat']) == 'ups' || strtolower($row['perangkat']) == 'server') {
            if ($row['hitung'] >= 4) { // Hijau jika sudah dirawat minimal 1 kali
                $sudah++;
                $output .= "<tr style='background-color:#d4edda;'>"; // Hijau: Selesai (>= 1)
            
            } else if ($row['hitung'] < 4 && $row['hitung'] > 0) {
                $sedang++;
                $output .= "<tr style='background-color:#FFFF00;'>"; // Kuning: Sedang (< target tapi > 0)
            }
            else {
                $belum++;
                $output .= "<tr>"; // Default: Belum (0)
            }
        } else {
            if ($row['hitung'] == $targetPerawatan) {
                $sudah++;
                $output .= "<tr style='background-color:#d4edda;'>"; // Hijau: Selesai (sama dengan target)
            } else if ($row['hitung'] < $targetPerawatan && $row['hitung'] > 0) {
                $sedang++;
                $output .= "<tr style='background-color:#FFFF00;'>"; // Kuning: Sedang (< target tapi > 0)
            } else {
                $belum++;
                $output .= "<tr>"; // Default: Belum (0 atau > target)
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
        $output .= "<td>" . $targetPerawatan . "</td>"; // Tampilkan target
        $output .= "<td>" . $row['hitung'] . "</td>"; // Tampilkan hitung
        $output .= "</tr>";
    }
    $total = $rowCount;
    $progress = $total > 0 ? ($sudah / $total * 100) : 0; // Hindari pembagian dengan nol
} else {
    $output .= "<tr><td colspan='9'>Tidak ada data ditemukan.</td></tr>";
}
echo $output;

// Bersihkan resource dan tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>