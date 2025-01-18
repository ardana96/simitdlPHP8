<?php
include('../config.php');

// Pastikan koneksi ke database tersedia
if (!$conn) {
    die(json_encode(array("error" => "Koneksi database gagal: " . print_r(sqlsrv_errors(), true))));
}

// Periksa apakah tombol ditekan dan `id` dikirim
if (isset($_POST['tombol']) && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Gunakan Prepared Statement untuk keamanan
    $query_delete = "DELETE FROM pcaktif WHERE id = ?";
    $params = array($id);
    $delete = sqlsrv_query($conn, $query_delete, $params);

    if ($delete) {
        // Redirect ke halaman utama setelah sukses
        header("Location: ../user.php?menu=rpemakaipc&status=success");
        exit;
    } else {
        // Redirect ke halaman utama dengan status error
        header("Location: ../user.php?menu=rpemakaipc&status=error");
        exit;
    }
} else {
    // Redirect jika request tidak valid
    header("Location: ../user.php?menu=rpemakaipc&status=invalid");
    exit;
}
?>
