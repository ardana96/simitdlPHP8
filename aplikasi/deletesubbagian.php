<?php
include('../config.php');
if(isset($_POST['tombol'])){
$subbag_id=$_POST['subbag_id'];

$query_delete="delete from sub_bagian where subbag_id='".$subbag_id."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=subbagian");}
else{
header("location:../user.php?menu=subbagian");}}
?>