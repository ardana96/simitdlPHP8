<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$idbarang=$_POST['IdBarang'];
$nomorbarang=$_POST['NomorBarang'];
$isback =1;


$query_insert="insert into tvalidasi (IdBarang,NomorBarang,IsBack) values ('".$idbarang."','".$nomorbarang."','".$isback."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=catridge&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=catridge&stt=gagal");}}
?>