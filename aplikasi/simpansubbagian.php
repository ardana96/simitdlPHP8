<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$subbag_id=$_POST['subbag_id'];
$subbag_nama=$_POST['subbag_nama'];
$subbagianbesar=strtoUpper($subbag_nama);



$query_insert="insert into sub_bagian (subbag_id,subbag_nama) values ('".$subbag_id."','".$subbagianbesar."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=subbagian&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=subbagian&stt=gagal");}}
?>