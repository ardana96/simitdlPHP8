<?php
include('../config.php');
$subbag_id=$_GET['subbag_id'];
$query="SELECT * from  sub_bagian WHERE subbag_id='".$subbag_id."' ";
$get_data=mysql_query($query);
$hasil=mysql_fetch_array($get_data);
$subbag_id=$hasil['subbag_id'];
$subbag_nama=$hasil['subbag_nama'];

$data=$subbag_id."&&&".$subbag_nama;
echo $data; ?>