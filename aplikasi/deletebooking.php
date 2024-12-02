<?php
include('../config.php');
if(isset($_POST['tombol'])){
$id=$_POST['id'];

$query_delete="delete from boking where id='".$id."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../pemakai.php?menu=booking");}
else{
header("location:../pemakai.php?menu=booking");}}
?>