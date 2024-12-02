<?php
include('../config.php');
$nomor=$_GET['nomor'];
$query="SELECT * from  service WHERE nomor='".$nomor."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$tgl2=$hasil['tgl2'];
$nomor=$hasil['nomor'];
$nama=$hasil['nama'];
$bag=$hasil['bagian'];
$divisi=$hasil['divisi'];
$perangkat=$hasil['perangkat'];
$kasus=$hasil['kasus'];
$penerima=$hasil['penerima'];

$data=$nomor."&&&".$tgl2."&&&".$nama."&&&".$bag."&&&".$divisi."&&&".$perangkat."&&&".$kasus."&&&".$penerima;
echo $data; ?>