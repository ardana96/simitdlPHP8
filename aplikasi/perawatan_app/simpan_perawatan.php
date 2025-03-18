<?php
session_start();

// Sertakan file konfigurasi database
include(dirname(dirname(dirname(__FILE__))) . '/config.php');

// Pastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal: " . print_r(sqlsrv_errors(), true));
}

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    die("User tidak login. Silakan login terlebih dahulu.");
}

// Mengambil data dari POST
$bulan = $_POST['bulan'] ?? '';
$idpc = $_POST['idpc'] ?? '';
$user = $_POST['user'] ?? '';
$lokasi = $_POST['lokasi'] ?? '';
$tipe_perawatan_id = $_POST['tipe_perawatan_id'] ?? '';
$tahun = $_POST['tahun'] ?? '';
$selectedItems = $_POST['selected_items'] ?? [];
$unselectedItems = $_POST['unselected_items'] ?? [];
$tanggal = date("Y-m-d");
// $treated_by = $_POST['treated_by'] ?? '';
$treated_by = $_SESSION['user']; // Ambil dari session
$keterangan = $_POST['keterangan'] ?? '';
$approve_by = $_POST['approve_by'] ?? '';

// Debugging: Log semua data yang diterima dari POST
error_log("Data POST diterima: " . print_r($_POST, true));

// Cek apakah tipe_perawatan_id adalah 24 (Server) atau 25 (UPS)
$isServerOrUPS = ($tipe_perawatan_id == 24 || $tipe_perawatan_id == 25);

// Variabel untuk melacak keberhasilan operasi
$success = false;

// Simpan ke tabel ket_perawatan (selalu menyertakan bulan)
$query_exist_ket = "SELECT * FROM ket_perawatan WHERE idpc = ? AND tahun = ? AND bulan = ? AND treated_by = ?";
$params_exist_ket = [$idpc, $tahun, $bulan, $treated_by];
$stmt_exist_ket = sqlsrv_prepare($conn, $query_exist_ket, $params_exist_ket);

if ($stmt_exist_ket === false) {
    die("Persiapan query ket_perawatan gagal: " . print_r(sqlsrv_errors(), true));
}

if (!sqlsrv_execute($stmt_exist_ket)) {
    die("Eksekusi query ket_perawatan gagal: " . print_r(sqlsrv_errors(), true));
}

$exist_ket_perawatan_count = 0;
while (sqlsrv_fetch($stmt_exist_ket)) {
    $exist_ket_perawatan_count++;
}
sqlsrv_free_stmt($stmt_exist_ket);

if ($exist_ket_perawatan_count == 0) {
    $query_ket = "INSERT INTO ket_perawatan (idpc, treated_by, ket, tahun, bulan, approve_by) VALUES (?, ?, ?, ?, ?, ?)";
    $params_ket = [$idpc, $treated_by, $keterangan, $tahun, $bulan, $approve_by];
} else {
    $query_ket = "UPDATE ket_perawatan SET ket = ?, approve_by = ? WHERE idpc = ? AND tahun = ? AND bulan = ? AND treated_by = ?";
    $params_ket = [$keterangan, $approve_by, $idpc, $tahun, $bulan, $treated_by];
}

$stmt_ket = sqlsrv_prepare($conn, $query_ket, $params_ket);
if ($stmt_ket === false) {
    die("Persiapan query ket_perawatan (insert/update) gagal: " . print_r(sqlsrv_errors(), true));
}

if (sqlsrv_execute($stmt_ket)) {
    $affected_rows_ket = sqlsrv_rows_affected($stmt_ket);
    if ($affected_rows_ket !== false && $affected_rows_ket > 0) {
        $success = true; // Tandai keberhasilan operasi ket_perawatan
    }
}
// Jangan lepaskan $stmt_ket sekarang, gunakan untuk rows_affected

// Debugging: Log selectedItems dan unselectedItems
error_log("Selected Items: " . print_r($selectedItems, true));
error_log("Unselected Items: " . print_r($unselectedItems, true));

// **Tambah Perawatan**
if (count($selectedItems) > 0) {
    foreach ($selectedItems as $itemId) {
        // Debugging: Log data untuk setiap item
        error_log("Memproses item: $itemId dengan idpc: $idpc, tipe_perawatan_id: $tipe_perawatan_id, tahun: $tahun, bulan: $bulan");

        // Query cek eksistensi data dengan pengecualian
        if ($isServerOrUPS) {
            $query_exist = "SELECT id FROM perawatan 
                           WHERE idpc = ? 
                           AND tipe_perawatan_id = ? 
                           AND tipe_perawatan_item_id = ? 
                           AND tahun = ? 
                           AND bulan = ?";
            $params_exist = [$idpc, $tipe_perawatan_id, $itemId, $tahun, $bulan];
        } else {
            $query_exist = "SELECT id FROM perawatan 
                           WHERE idpc = ? 
                           AND tipe_perawatan_id = ? 
                           AND tipe_perawatan_item_id = ? 
                           AND YEAR(tanggal_perawatan) = ?";
            $params_exist = [$idpc, $tipe_perawatan_id, $itemId, $tahun];
        }

        $stmt_exist = sqlsrv_prepare($conn, $query_exist, $params_exist);
        if ($stmt_exist === false) {
            die("Persiapan query cek eksistensi perawatan gagal: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_execute($stmt_exist)) {
            die("Eksekusi query cek eksistensi perawatan gagal: " . print_r(sqlsrv_errors(), true));
        }

        $exist_count = 0;
        while (sqlsrv_fetch($stmt_exist)) {
            $exist_count++;
        }
        sqlsrv_free_stmt($stmt_exist);

        // Debugging: Log hasil cek eksistensi
        error_log("Exist count untuk item $itemId: $exist_count");

        if ($exist_count == 0) {
            // Query insert dengan pengecualian
            if ($isServerOrUPS) {
                $query = "INSERT INTO perawatan (idpc, tipe_perawatan_id, tipe_perawatan_item_id, tanggal_perawatan, bulan, tahun) 
                          VALUES (?, ?, ?, ?, ?, ?)";
                $params = [$idpc, $tipe_perawatan_id, $itemId, $tanggal, $bulan, $tahun];
            } else {
                $query = "INSERT INTO perawatan (idpc, tipe_perawatan_id, tipe_perawatan_item_id, tanggal_perawatan) 
                          VALUES (?, ?, ?, ?)";
                $params = [$idpc, $tipe_perawatan_id, $itemId, $tanggal];
            }

            // Debugging: Log query insert
            error_log("Query insert: $query");
            error_log("Params insert: " . print_r($params, true));

            $stmt_perawatan = sqlsrv_prepare($conn, $query, $params);
            if ($stmt_perawatan === false) {
                die("Persiapan query insert perawatan gagal: " . print_r(sqlsrv_errors(), true));
            }

            if (sqlsrv_execute($stmt_perawatan)) {
                $affected_rows_perawatan = sqlsrv_rows_affected($stmt_perawatan);
                if ($affected_rows_perawatan !== false && $affected_rows_perawatan > 0) {
                    $success = true; // Tandai keberhasilan operasi perawatan
                }
            } else {
                die("Eksekusi query insert perawatan gagal: " . print_r(sqlsrv_errors(), true));
            }
            sqlsrv_free_stmt($stmt_perawatan);
        } else {
            error_log("Data untuk item $itemId sudah ada, tidak di-insert.");
        }
    }
} else {
    error_log("Tidak ada selected items untuk disimpan.");
}

// **Hapus Perawatan**
if (count($unselectedItems) > 0) {
    foreach ($unselectedItems as $itemId) {
        if ($isServerOrUPS) {
            $query_exist = "SELECT id FROM perawatan 
                           WHERE idpc = ? 
                           AND tipe_perawatan_id = ? 
                           AND tipe_perawatan_item_id = ? 
                           AND tahun = ? 
                           AND bulan = ?";
            $params_exist = [$idpc, $tipe_perawatan_id, $itemId, $tahun, $bulan];
        } else {
            $query_exist = "SELECT id FROM perawatan 
                           WHERE idpc = ? 
                           AND tipe_perawatan_id = ? 
                           AND tipe_perawatan_item_id = ? 
                           AND YEAR(tanggal_perawatan) = ?";
            $params_exist = [$idpc, $tipe_perawatan_id, $itemId, $tahun];
        }

        $stmt_exist = sqlsrv_prepare($conn, $query_exist, $params_exist);
        if ($stmt_exist === false) {
            die("Persiapan query cek eksistensi perawatan (hapus) gagal: " . print_r(sqlsrv_errors(), true));
        }

        if (!sqlsrv_execute($stmt_exist)) {
            die("Eksekusi query cek eksistensi perawatan (hapus) gagal: " . print_r(sqlsrv_errors(), true));
        }

        $exist_count = 0;
        $idperawatan = null;
        while ($row = sqlsrv_fetch_array($stmt_exist, SQLSRV_FETCH_ASSOC)) {
            $exist_count++;
            $idperawatan = $row['id'];
        }
        sqlsrv_free_stmt($stmt_exist);

        if ($exist_count > 0 && $idperawatan !== null) {
            $query_delete = "DELETE FROM perawatan WHERE id = ?";
            $stmt_delete = sqlsrv_prepare($conn, $query_delete, [$idperawatan]);
            if ($stmt_delete === false) {
                die("Persiapan query delete perawatan gagal: " . print_r(sqlsrv_errors(), true));
            }

            if (sqlsrv_execute($stmt_delete)) {
                $affected_rows_delete = sqlsrv_rows_affected($stmt_delete);
                if ($affected_rows_delete !== false && $affected_rows_delete > 0) {
                    $success = true; // Tandai keberhasilan operasi delete
                }
            } else {
                die("Eksekusi query delete perawatan gagal: " . print_r(sqlsrv_errors(), true));
            }
            sqlsrv_free_stmt($stmt_delete);
        }
    }
}

// Feedback yang lebih akurat
if ($success || count($selectedItems) > 0 || count($unselectedItems) > 0) {
    echo "Data berhasil disimpan.";
} else {
    echo "Gagal menyimpan data.";
}

// Tutup koneksi
sqlsrv_close($conn);
?>