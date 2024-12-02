
   
<?php
include('../config.php');
//$conn = mysqli_connect('localhost', 'root', '', 'learn_jquery');

$IdBarang = $_POST['idbarang'];
$catOut = $_POST['out'];




$query="SELECT * from tvalidasi where IdBarang = '$IdBarang' and  NomorBarang = '$catOut' and IsBack = 0";
$get_data=mysql_query($query);
$data=mysql_num_rows($get_data);

echo $data;

// if ($data == 0)
// {

// 	echo $query;
// }

// else{
// 	echo "Barang tersedia";
// }




// $username = mysqli_real_escape_string($conn, $_POST['username']);
// $sql = "select * from users where username = '$username'";
// $process = mysqli_query($conn, $sql);
// $num = mysqli_num_rows($process);
// if($found == 0){
// 	echo " &#10004; Barang tidak tersedia masih tersedia";
// }
?>
