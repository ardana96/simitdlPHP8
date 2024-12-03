<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

// Ambil parameter dari URL
$subbag_id=$_GET['subbag_id'];
$query = "SELECT * from  sub_bagian WHERE subbag_id= ?";
$params = array($subbag_id);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    // Jika query gagal, tampilkan pesan error
    die(print_r(sqlsrv_errors(), true));
}

// Ambil data dari hasil query
$hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($hasil) {
    // Ambil nilai kolom
    $subbag_id=$hasil['subbag_id'];
    $subbag_nama=$hasil['subbag_nama'];

    // Gabungkan data dengan format tertentu
    $data=$subbag_id."&&&".$subbag_nama;
    echo $data;
} else {
    // Jika data tidak ditemukan
    echo "Data tidak ditemukan untuk nomor: " . htmlspecialchars($nomor);
}

// Bebaskan resource statement
sqlsrv_free_stmt($stmt);

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>
