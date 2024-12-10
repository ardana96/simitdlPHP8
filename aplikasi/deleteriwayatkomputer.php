<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];

    // Query untuk menghapus data
    $query_delete = "DELETE FROM service WHERE nomor = ?";
    $params = array($nomor);

    // Eksekusi query menggunakan sqlsrv_query
    $stmt = sqlsrv_query($conn, $query_delete, $params);

    if ($stmt) {
        header("location:../user.php?menu=riwayat&stt=Berhasil Hapus");
    } else {
        // Tangkap error jika ada
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error[0] . "<br>";
            echo "Pesan Kesalahan: " . $error[2] . "<br>";
        }
        die("Proses gagal, periksa log error.");
    }
}
?>
