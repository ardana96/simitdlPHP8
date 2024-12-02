<?
include('config.php');
$tgll=date('20y-01-01');

$l=mysql_query("Select * from stockth where blnth='$tgll'");
if(mysql_num_rows($l) > 0){}
else{
$ll=mysql_query("Select * from tbarang ");	
if(mysql_num_rows($ll) > 0){
while($datall = mysql_fetch_array($ll)){
$idbarang=$datall['idbarang'];
$stock=$datall['stock'];

$lll=mysql_query("insert into stockth (idbarang,blnth,stock) values ('$idbarang','$tgll',0)");	
}
}}


?>