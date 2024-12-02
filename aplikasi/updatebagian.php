<?php
include('../config.php');
if(isset($_POST['tombol'])){
$id_bagian=$_POST['id_bagian'];
$bagian=$_POST['bagian'];

$query_update="UPDATE bagian SET bagian= '".$bagian."' WHERE id_bagian='".$id_bagian."'";	
$update=mysql_query($query_update);
if($update){
header("location:../user.php?menu=bagian&stt= Update Berhasil");}
else{
header("location:../user.php?menu=bagian&stt=gagal");}}
?>