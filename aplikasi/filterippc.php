<?php
include('../config.php');
$ippc=$_GET['ippc'];
$query="SELECT * from  pcaktif WHERE ippc='".$ippc."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$ippc=$hasil['ippc'];
$bagian=$hasil['bagian'];
$divisi=$hasil['divisi'];
$perangkat = $hasil['model'];


$data=$bagian."&&&".$divisi."&&&".$ippc."&&&".$perangkat;
echo $data; ?>