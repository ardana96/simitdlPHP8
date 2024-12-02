<?php
include('../config.php');
if(isset($_POST['tombol'])){
	
$nomor=$_POST['nomor'];
$tgl=$_POST['tgl'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$namabarang=$_POST['namabarang'];
$qty=$_POST['qty'];
$keterangan=$_POST['keterangan'];



$query_insert="insert into permintaan (nomor,tgl,nama,bagian,divisi,namabarang,qty,keterangan,status,aktif) 
values ('".$nomor."','".$tgl."','".$nama."','".$bagian."','".$divisi."','".$namabarang."','".$qty."','".$keterangan."','PENDING','aktif')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=permintaan&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=permintaan&stt=gagal");}}
?>