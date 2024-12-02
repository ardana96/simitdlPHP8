<?php
include('../config.php');
// if(isset($_POST['tombol'])){
// $idkategori=$_POST['idkategori'];
// $kategori=$_POST['kategori'];


// $query_update="UPDATE tkategori SET kategori= '".$kategori."' WHERE idkategori='".$idkategori."'";	
// $update=mysql_query($query_update);
// if($update){
// header("location:../user.php?menu=kategori&stt= Update Berhasil");}
// else{
// header("location:../user.php?menu=kategori&stt=gagal");}}

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $idkategori = $_POST['idkategori'];
    $kategori = $_POST['kategori'];

    // Query untuk memperbarui data
    $query = "UPDATE tkategori SET kategori = ? WHERE idkategori = ?";
    $params = array($kategori, $idkategori);

    // Eksekusi query menggunakan prepared statement
    $stmt = sqlsrv_query($conn, $query, $params);

    // Periksa hasil eksekusi
    if ($stmt === false) {
        // Jika gagal, tangkap error
        $errors = sqlsrv_errors();
        $error_message = "Gagal: " . print_r($errors, true);
        header("Location: ../user.php?menu=kategori&stt=$error_message");
        exit();
    } else {
        // Jika berhasil, arahkan ke halaman sukses
        header("Location: ../user.php?menu=kategori&stt=Update Berhasil");
        exit();
    }

    // Bebaskan resource statement
    sqlsrv_free_stmt($stmt);
}

// Tutup koneksi database (opsional, jika tidak dilakukan di config.php)
sqlsrv_close($conn);
?>