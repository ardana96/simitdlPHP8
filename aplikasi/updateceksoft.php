<?php
include('../config.php');
if($_POST['nomorr']){
$nomorr=$_POST['nomorr'];
$cek=$_POST['cek'];

$query_update="UPDATE software SET cetak= '".$cek."' WHERE nomor='".$nomorr."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=software&stt= Update Berhasil");}
else{
header("location:../user.php?menu=software&stt=gagal");}}
?>