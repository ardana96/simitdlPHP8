<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];

    // Query untuk mengubah status aktif pada permintaan
    $query_update = "UPDATE permintaan SET aktif = 'aktif' WHERE nomor = ?";
    $params = [$nomor]; // Parameter nomor

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_update, $params);

    if ($stmt === false) {
        // Redirect dengan pesan gagal jika terjadi error
        header("location:../user.php?menu=permintaanhidden&gagal");
        die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
    } else {
        // Redirect dengan pesan sukses
        header("location:../user.php?menu=permintaanhidden&sukses");
    }
}
?>
