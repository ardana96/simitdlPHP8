<?php
include('../config.php');
$idpc=$_GET['idpc'];
$query="SELECT * from  pcaktif WHERE idpc LIKE '%".$idpc."%' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$idpc=$hasil['idpc'];
$bagian=$hasil['bagian'];
$divisi=$hasil['divisi'];
$perangkat = $hasil['model'];

$data=$bagian."&&&".$divisi."&&&".$idpc."&&&".$perangkat;
echo $data; ?>