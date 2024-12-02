<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$lokasi_id=$_POST['lokasi_id'];
$lokasi_nama=$_POST['lokasi_nama'];
$lokasibesar=strtoUpper($lokasi_nama);

$query_insert="insert into lokasi (lokasi_id,lokasi_nama) values ('".$lokasi_id."','".$lokasibesar."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=lokasi&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=lokasi&stt=gagal");}}
?>