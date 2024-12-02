<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$id_bag_pemakai=$_POST['id_bag_pemakai'];
$bag_pemakai=$_POST['bag_pemakai'];



$query_insert="insert into bagian_pemakai (id_bag_pemakai,bag_pemakai) values ('".$id_bag_pemakai."','".$bag_pemakai."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=bagian_pemakai&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=bagian_pemakai&stt=gagal");}}
?>