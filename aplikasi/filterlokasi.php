<?php
include('../config.php');
$lokasi_id=$_GET['lokasi_id'];
$query="SELECT * from  lokasi WHERE lokasi_id='".$lokasi_id."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$lokasi_id=$hasil['lokasi_id'];
$lokasi_nama=$hasil['lokasi_nama'];

$data=$lokasi_id."&&&".$lokasi_nama;
echo $data; ?>