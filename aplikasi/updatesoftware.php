<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];
$tgl=$_POST['tgl'];
$jam=$_POST['jam'];
$nama=$_POST['nama'];
$bagian=$_POST['bagian'];
$divisi=$_POST['divisi'];
$penerima=$_POST['penerima'];
$kasus=$_POST['kasus'];
$tgl2=$_POST['tgl2'];
$jam2=$_POST['jam2'];
$tindakan=$_POST['tindakan'];
$oleh=$_POST['oleh'];
$status=$_POST['status'];
$svc_kat = $_POST['svc_kat'];
$tglRequest = $_POST['tglRequest'];

$query_update="UPDATE software SET oleh= '".$penerima."',tgl= '".$tgl."',jam= '".$jam."',nama= '".$nama."',bagian= '".$bagian."',divisi= '".$divisi."',
penerima= '".$penerima."',kasus= '".$kasus."',tgl2= '".$tgl2."',jam2= '".$jam2."',tindakan= '".$tindakan."', svc_kat= '".$svc_kat."', tglRequest = '".$tglRequest."'  WHERE nomor='".$nomor."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=software&stt= Update Berhasil");}
else{
header("location:../user.php?menu=software&stt=gagal");}}
?>