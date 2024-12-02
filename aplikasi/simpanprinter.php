<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$nomor=$_POST['nomor'];
$id_perangkat=$_POST['id_perangkat'];
$printer=$_POST['printer'];
$keterangan=$_POST['keterangan'];
$status=$_POST['status'];
$nama_user = $_POST['nama_user'];
$lokasi = $_POST['lokasi'];
$bulan = $_POST['bulan'];
$tgl_perawatan = $_POST['tgl_perawatan'];


$query_insert="insert into printer (nomor,id_perangkat,printer,keterangan,status,user,lokasi, bulan, tgl_perawatan) 
values ('".$nomor."','".$id_perangkat."','".$printer."','".$keterangan."','".$status."','".$nama_user."','".$lokasi."','".$bulan."','".$tgl_perawatan."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=printer&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=printer&stt=gagal");}}
?>