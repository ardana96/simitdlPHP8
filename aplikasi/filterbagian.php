<?php
include('../config.php');
$id_bagian=$_GET['id_bagian'];
$query="SELECT * from  bagian WHERE id_bagian='".$id_bagian."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$id_bagian=$hasil['id_bagian'];
$bagian=$hasil['bagian'];

$data=$id_bagian."&&&".$bagian;
echo $data; ?>