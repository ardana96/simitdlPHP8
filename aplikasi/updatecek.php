<?php
include('../config.php');
if($_POST['idbarang']){
$idbarang=$_POST['idbarang'];
$cek=$_POST['cek'];

$query_update="UPDATE tbarang SET cek= '".$cek."' WHERE idbarang='".$idbarang."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=barang&stt= Update Berhasil");}
else{
header("location:../user.php?menu=barang&stt=gagal");}}
?>