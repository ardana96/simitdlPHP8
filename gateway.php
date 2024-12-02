
<meta http-equiv=refresh content=2;url='gateway.php'>
<h1>Ketik</h1>
<h4> INFO (Spaci) BUKU </h4>
<h4> INFO (Spaci) PROMO </h4>
<h4> INFO (Spaci) ARTIKEL </h4>
<?
mysql_connect("localhost","root","dlris30g");
mysql_select_db(gammu);

//ambil semua data dari tabel inbox

$sql=mysql_query("select * from inbox");
while ($data=mysql_fetch_array($sql)){
$id=$data[ID];

//ubah pesan dalam tabel inbox menjadi huruf kapital
$keyword=strtoupper($data[TextDecoded]);
$hp=$data[SenderNumber];
}
//jika keyword : INFO BUKU 
if ($keyword=='INFO BUKU'){
$pesan="Ada buku  baru loh dari lokomedia tentang Apikasi SMS";
$masuk=mysql_query("insert into outbox(InsertIntoDB,SendingDateTime,DestinationNumber,TextDecoded,SendingTimeOut,DeliveryReport,
CreatorID)values (sysdate(),sysdate(),'$hp','$pesan',sysdate(),'yes','system')");

//Jika pengeiriman berhasil 
if($masuk){
$hapus=Mysql_query("delete from inbox where ID='$id'");}
}
