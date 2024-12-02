<?php
include('../config.php');
if(isset($_POST['tombol'])){
$kd=$_POST['kd'];

$query_delete="delete from divisi where kd='".$kd."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=divisi");}
else{
header("location:../user.php?menu=divisi");}}
?>