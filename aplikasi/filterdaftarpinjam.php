<?php
include('../config.php');
$nopinjam=$_GET['id_user'];
$query="SELECT * from  tpinjam as a ,trincipinjam as b WHERE a.nopinjam=b.nopinjam and a.nopinjam='".$nopinjam."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$tgl1=$hasil['tgl1'];
$nopinjam=$hasil['nopinjam'];
$tgl2=$hasil['tgl2'];
$status=$hasil['status'];

$data=$tgl1."&&&".$tgl2."&&&".$status."&&&".$nopinjam;
echo $data; ?>