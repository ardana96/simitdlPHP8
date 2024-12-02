<?php
include('../config.php');
if(isset($_POST['tombol'])){
$Id=$_POST['Id'];

$query_delete="delete from tvalidasi where Id='".$Id."'";	
$update=mysql_query($query_delete);
if($update){
header("location:../user.php?menu=catridge");}
else{
header("location:../user.php?menu=catridge");}}
?>