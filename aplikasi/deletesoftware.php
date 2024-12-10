<?php
include('../config.php');

if (isset($_POST['tombol'])) {
    $nomor = $_POST['nomor'];

    // Query untuk menghapus data
    $query_delete = "DELETE FROM software WHERE nomor = ?";
    $params = [$nomor];

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query_delete, $params);

    if ($stmt) {
        header("location:../user.php?menu=software&stt=Berhasil Hapus");
    } else {
        // Menangani error jika terjadi
        header("location:../user.php?menu=software&stt=Gagal Hapus");
        echo "Error occurred.<br>";
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                echo "Code: " . $error['code'] . "<br>";
                echo "Message: " . $error['message'] . "<br>";
            }
        }
    }
}
?>
