<?php
include('../config.php');
// if(isset($_POST['tombol'])){
// $idkategori=$_POST['idkategori'];

// $query_delete="delete from tkategori where idkategori='".$idkategori."'";	
// $update=mysql_query($query_delete);
// if($update){
// header("location:../user.php?menu=kategori");}
// else{
// header("location:../user.php?menu=kategori");}}

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $idkategori = $_POST['idkategori'];

    // Gunakan prepared statement untuk mencegah SQL Injection
    $stmt = $mysql->prepare("DELETE FROM tkategori WHERE idkategori = ?");
    $stmt->bind_param("s", $idkategori);

    // Eksekusi query dan periksa hasilnya
    if ($stmt->execute()) {
        header("Location: ../user.php?menu=kategori");
        exit();
    } else {
        header("Location: ../user.php?menu=kategori&stt=Gagal: " . $mysql->error);
        exit();
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi database
$mysql->close();


?>