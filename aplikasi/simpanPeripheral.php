<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$nomor=$_POST['nomor'];
$id_perangkat=$_POST['id_perangkat'];
$perangkat=$_POST['perangkat'];
$keterangan=$_POST['keterangan'];
$divisi=$_POST['divisi'];
$nama_user = $_POST['nama_user'];
$lokasi = $_POST['lokasi'];
$bulan = $_POST['bulan'];
$tgl_perawatan = $_POST['tgl_perawatan'];
$tipe = $_POST['tipe'];
$brand = $_POST['brand'];
$model = $_POST['model'];
$pembelian_dari = $_POST['pembelian_dari'];
$sn = $_POST['sn'];


$query_insert="insert into peripheral (nomor,id_perangkat,perangkat,keterangan,divisi,user,lokasi, bulan, tgl_perawatan, tipe, brand, model, pembelian_dari, sn) 
values ('".$nomor."','".$id_perangkat."','".$perangkat."','".$keterangan."','".$divisi."','".$nama_user."','".$lokasi."','".$bulan."',
		'".$tgl_perawatan."', '".$tipe."','".$brand."', '".$model."', '".$pembelian_dari."', '".$sn."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=peripheral&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=peripheral&stt=gagal");}}
?>