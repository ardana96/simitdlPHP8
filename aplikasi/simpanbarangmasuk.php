<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idbarang=$_POST['idbarang'];	
$idkategori=$_POST['idkategori'];
$namabarang=$_POST['namabarang'];
$barcode=$_POST['barcode'];
$inventory=$_POST['inventory'];
$refil=$_POST['refil'];
$keterangan=$_POST['keterangan'];
$nmbesar=strtoupper($namabarang);


$query_insert="insert into tbarang (idbarang,idkategori,namabarang,barcode,inventory,refil,keterangan) 
values ('".$idbarang."','".$idkategori."','".$nmbesar."','".$barcode."','".$inventory."','".$refil."','".$keterangan."')";	
$update=mysql_query($query_insert);
if($update){
header("location:../user.php?menu=masuk&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=masuk&stt=gagal");}}
?>