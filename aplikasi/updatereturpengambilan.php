<?php
include('../config.php');
if(isset($_POST['button_selesai'])){
$no_faktur=$_POST['no_faktur'];
$tglambil=$_POST['tglambil'];
$jam=$_POST['jam'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];

$query_update="UPDATE tpengambilan SET nama= '".$nama."',bagian= '".$bagian."',
divisi= '".$divisi."' WHERE nofaktur='".$no_faktur."'";	
$update=mysql_query($query_update);
if($update){
header("location:../pemakai.php?menu=retur&stt= Update Berhasil");}
else{
header("location:../pemakai.php?menu=retur&stt=gagal");}}
?>