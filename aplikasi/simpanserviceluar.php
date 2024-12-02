<?php
include('../config.php');
if(isset($_POST['tombol'])){
$tgl2=$_POST['tgl2'];
$jam2=$_POST['jam2'];
$luar=$_POST['luar'];
$tindakan='Pengiriman Ke Luar';
$nomor=$_POST['nomor'];
$status='PROSES';

$query_insert="update service set tgl2='$tgl2',jam2='$jam2',luar='$luar',tindakan='$tindakan',status='$status' where nomor='$nomor'"; 
$insert=mysql_query($query_insert);
if($insert){
header("location:../user.php?menu=service&stt=Berhasil");}
else{
header("location:../user.php?menu=service&stt=Gagal");} }
?>