<?php
include('../config.php');
if(isset($_POST['tombol'])){
$tgl3=$_POST['tgl3'];
$jam3=$_POST['jam3'];
$tindakan2=$_POST['tindakan2'];
$nomor=$_POST['nomor'];
$status='Selesai';
$ket='L';

$query_insert="update service set tgl3='$tgl3',jam3='$jam3',tindakan2='$tindakan2',status='$status',ket='$ket' where nomor='$nomor'"; 
$insert=mysql_query($query_insert);
if($insert){
header("location:../user.php?menu=serviceluar&stt=Berhasil");}
else{
header("location:../user.php?menu=serviceluar&stt=Gagal");} }
?>