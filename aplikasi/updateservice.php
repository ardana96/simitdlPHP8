<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$tgl2=$_POST['tgl2'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$perangkat=$_POST['perangkat'];
$kasus=$_POST['kasus'];
$penerima=$_POST['penerima'];




$query_update="UPDATE service SET tgl2= '".$tgl2."',nama= '".$nama."',bagian= '".$bagian."' 
,divisi= '".$divisi."',perangkat= '".$perangkat."',kasus= '".$kasus."',penerima= '".$penerima."' WHERE nomor='".$nomor."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=serviceluar&stt= Update Berhasil");}
else{
header("location:../user.php?menu=serviceluar&stt=gagal");}}
?>