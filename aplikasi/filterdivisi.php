

<?php
include('../config.php'); // Pastikan koneksi menggunakan sqlsrv

// Ambil parameter dari URL
$kd=$_GET['kd'];
$query = "SELECT * FROM divisi WHERE kd = ?";
$params = array($kd);
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    // Jika query gagal, tampilkan pesan error
    die(print_r(sqlsrv_errors(), true));
}

// Ambil data dari hasil query
$hasil = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if ($hasil) {

    $kd=$hasil['kd'];
$namadivisi=$hasil['namadivisi'];


$data=$kd."&&&".$namadivisi;

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
