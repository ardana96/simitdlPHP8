<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];

$query_delete="update permintaan set aktif='nonaktif' where nomor='$nomor' ";	
$update=mysql_query($query_delete);

if($update){
header("location:../user.php?menu=permintaan&sukses");}
else{
header("location:../user.php?menu=permintaan&gagal");}}
?>