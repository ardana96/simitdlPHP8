<?php
include('../config.php');
if(isset($_POST['tombol'])){
$id_bagian=$_POST['id_bagian'];

$query_delete="delete from bagian where id_bagian='".$id_bagian."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=bagian");}
else{
header("location:../user.php?menu=bagian");}}
?>