<?php
include('../config.php');
$nomor=$_GET['nomor'];
$query="SELECT * from  scaner WHERE nomor='".$nomor."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$nomor=$hasil['nomor'];
$id_perangkat=$hasil['id_perangkat'];
$printer=$hasil['printer'];
$keterangan=$hasil['keterangan'];
$status=$hasil['status'];
$user = $hasil['user'];
$lokasi = $hasil['lokasi'];
$tgl_perawatan = $hasil['tgl_perawatan'];
$bulan = $hasil['bulan'];


$data=$nomor."&&&".$id_perangkat."&&&".$printer."&&&".$keterangan."&&&".$status."&&&".$user."&&&".$lokasi."&&&".$tgl_perawatan."&&&".$bulan;
echo $data; ?>