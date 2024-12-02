<?php
include('../config.php');
if(isset($_POST['tombol'])){
$tgl2=$_POST['tgl2'];
$jam2=$_POST['jam2'];
$teknisi=$_POST['teknisi'];
$tindakan=$_POST['tindakan'];
$nomor=$_POST['nomor'];
$status='Selesai';
$ket='D';

$query_insert="update service set tgl2='$tgl2',jam2='$jam2',teknisi='$teknisi',tindakan='$tindakan',status='$status',ket='$ket' where nomor='$nomor'"; 
$insert=mysql_query($query_insert);
if($insert){
header("location:../user.php?menu=service&stt=Simpan Berhasil ");}
else{
header("location:../user.php?menu=service&stt=Gagal Simpan");} }
?>