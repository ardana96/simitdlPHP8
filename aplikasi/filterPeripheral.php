<?php
include('../config.php');
$nomor=$_GET['nomor'];
$query="SELECT * from  peripheral WHERE nomor='".$nomor."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$nomor=$hasil['nomor'];
$id_perangkat=$hasil['id_perangkat'];
$perangkat=$hasil['perangkat'];
$keterangan=$hasil['keterangan'];
$divisi=$hasil['divisi'];
$user = $hasil['user'];
$lokasi = $hasil['lokasi'];
$tgl_perawatan = $hasil['tgl_perawatan'];
$bulan = $hasil['bulan'];
$tipe = $hasil['tipe'];
$brand = $hasil['brand'];
$model = $hasil['model'];
$pembelian_dari = $hasil['pembelian_dari'];
$sn = $hasil['sn']; 

$data=$nomor."&&&".$id_perangkat."&&&".$perangkat."&&&".$keterangan."&&&".$divisi."&&&".$user."&&&".$lokasi."&&&".$tgl_perawatan."&&&".$bulan."&&&".$tipe."&&&".$brand."&&&".$model."&&&".$pembelian_dari."&&&".$sn;
echo $data; ?>