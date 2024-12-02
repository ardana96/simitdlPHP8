<?php
include('../config.php');
$nomor=$_GET['id_user'];
$query="SELECT * from  service WHERE nomor='".$nomor."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);


$nomor=$hasil['nomor'];
$tgl=$hasil['tgl'];
$jam=$hasil['jam'];
$nama=$hasil['nama'];
$ippc = $hasil['ippc'];
$bagian = $hasil['bagian'];
$divisi = $hasil['divisi'];
$kasus = $hasil['kasus'];
$penerima = $hasil['penerima'];
$tgl2 = $hasil['tgl2'];
$svc_kat = $hasil['svc_kat'];
$tindakan = $hasil['tindakan'];



$data=$nomor."&&&".$tgl."&&&".$jam."&&&".$nama."&&&".$ippc."&&&".$bagian."&&&".$divisi."&&&".$kasus."&&&".$penerima."&&&".$tgl2."&&&".$svc_kat."&&&".$tindakan;
echo $data; ?>