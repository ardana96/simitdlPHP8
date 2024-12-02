<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$kodedivisi=$_POST['kd'];
$namadivisi=$_POST['namadivisi'];


$query_insert="insert into divisi (kd,namadivisi) values ('".$kodedivisi."','".$namadivisi."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=divisi&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=divisi&stt=gagal");}}
?>