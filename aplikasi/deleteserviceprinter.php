<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];

    // Query parameterized untuk mencegah SQL Injection
    $query_delete = "DELETE FROM service WHERE nomor = ?";
    $params = [$nomor];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_delete, $params);

    if ($stmt) {
        // Redirect jika berhasil
        header("location:../user.php?menu=serviceprinter&stt=Berhasil Hapus");
    } else {
        // Tangkap error jika query gagal
        $errors = sqlsrv_errors();
        foreach ($errors as $error) {
            echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
            echo "Kode Kesalahan: " . $error[0] . "<br>";
            echo "Pesan Kesalahan: " . $error[2] . "<br>";
        }
        header("location:../user.php?menu=serviceprinter&stt=Gagal Hapus");
    }
}
?>
