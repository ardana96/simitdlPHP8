<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$id_bagian=$_POST['id_bagian'];
$bagian=$_POST['bagian'];
$bagianbesar=strtoUpper($bagian);



$query_insert="insert into bagian (id_bagian,bagian) values ('".$id_bagian."','".$bagianbesar."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=keluar&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=keluar&stt=gagal");}}
?>