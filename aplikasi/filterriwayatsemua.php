<?php
include('../config.php');
$nomor=$_GET['id_user'];
$query="SELECT * from  service WHERE nomor='".$nomor."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$tgl=$hasil['tgl'];
$tgl2=$hasil['tgl2'];
$tgl3=$hasil['tgl3'];
$nomor=$hasil['nomor'];

$data=$tgl."&&&".$tgl2."&&&".$tgl3."&&&".$nomor;
echo $data; ?>