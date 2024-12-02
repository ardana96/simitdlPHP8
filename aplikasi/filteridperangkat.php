<?php
include('../config.php');
$keterangan=$_GET['keterangan'];
$query="SELECT * from  printer WHERE keterangan='".$keterangan."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$id_perangkat=$hasil['id_perangkat'];
$bagian=$hasil['keterangan'];
$divisi=$hasil['status'];
$printer=$hasil['printer'];
$id_perangkat=$hasil['id_perangkat'];


$data=$bagian."&&&".$divisi."&&&".$printer."&&&".$keterangan;
echo $data; ?>