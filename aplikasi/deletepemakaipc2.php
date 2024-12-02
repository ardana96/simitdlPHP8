<?php
include('../config.php');
if(isset($_POST['tombol'])){
$nomor=$_POST['nomor'];

$query_delete="delete from pcaktif2 where nomor='".$nomor."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=rpemakaipc2");}
else{
header("location:../user.php?menu=rpemakaipc2");}}
?>