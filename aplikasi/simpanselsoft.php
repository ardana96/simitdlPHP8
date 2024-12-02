<?php
include('../config.php');

if(isset($_POST['tombol'])){

$nomor=$_POST['nomor'];
$tgl2=$_POST['tgl2'];
$jam2=$_POST['jam2'];
$tindakan=$_POST['tindakan'];
$svc_kat = $_POST['svc_kat'];


$ubah="UPDATE software SET tgl2= '".$tgl2."',jam2= '".$jam2."',tindakan= '".$tindakan."',oleh= '".$penerima."',status='Selesai', svc_kat = '".$svc_kat."' where nomor = '".$nomor."' ";	
$pubah=mysql_query($ubah);


if($pubah){
header("location:../user.php?menu=software&stt= Simpan Berhasil");}
else{
header("location:../user.php?menu=software&stt=gagal");}}

?>
