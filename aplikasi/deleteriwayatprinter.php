<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];

$query_delete="delete from service where nomor='".$nomor."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=riwayatprinter&stt=Berhasil Hapus");}
else{
header("location:../user.php?menu=riwayatprinter&stt=Gagal Hapus");}}
?>