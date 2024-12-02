<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$idsupp=$_POST['idsupp'];
$namasupp=$_POST['namasupp'];
$alamatsupp=$_POST['alamatsupp'];
$telpsupp=$_POST['telpsupp'];


$query_insert="insert into tsupplier (idsupp,namasupp,alamatsupp,telpsupp) values ('".$idsupp."','".$namasupp."','".$alamatsupp."','".$telpsupp."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=masuk&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=masuk&stt=gagal");}}
?>