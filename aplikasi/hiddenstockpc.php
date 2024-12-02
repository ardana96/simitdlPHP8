<?php
include('../config.php');
if(isset($_POST['tombol'])){
$idpc=$_POST['idpc'];

$query_delete="update tpc set aktif='nonaktif' where idpc='$idpc' ";	
$update=mysql_query($query_delete);

if($update){
header("location:../user.php?menu=stockpc&sukses");}
else{
header("location:../user.php?menu=stockpc&gagal");}}
?>