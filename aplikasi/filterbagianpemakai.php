<?php
include('../config.php');
$id_bagian=$_GET['id_bagian'];
$query="SELECT * from  bagian_pemakai WHERE id_bag_pemakai='".$id_bagian."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$id_bag_pemakai=$hasil['id_bag_pemakai'];
$bag_pemakai=$hasil['bag_pemakai'];

$data=$id_bag_pemakai."&&&".$bag_pemakai;
echo $data; ?>