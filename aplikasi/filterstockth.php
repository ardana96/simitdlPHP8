<?php
include('../config.php');
$idbarang=$_GET['idbarang'];
$blnth=$_GET['blnth'];
$query="SELECT * from  stockth WHERE idbarang='".$idbarang."' and blnth='".$blnth."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$idbarang=$hasil['idbarang'];
$blnth=$hasil['blnth'];
$stocka=$hasil['stocka'];


$data=$idbarang."&&&".$blnth."&&&".$stocka;
echo $data; ?>