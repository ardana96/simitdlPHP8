<?php
include('../config.php');
$kd=$_GET['kd'];
$query="SELECT * from  divisi WHERE kd='".$kd."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$kd=$hasil['kd'];
$namadivisi=$hasil['namadivisi'];


$data=$kd."&&&".$namadivisi;
echo $data; ?>