<?php
include('config.php');

?>
<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

</script>
<style>
.isi_tabelll {
border:1px;
	font-size: 14pt; color: black;
	background-color: #FFF;}
</style>
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(barang){
if(barang==""){
alert("Anda belum memilih  barang");}
else{   
http.open('GET','koneksi/ajax.php?barang=' + encodeURIComponent(barang) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');       
document.getElementById('asfa').value = string[2]; 
document.getElementById('www').value = string[0];                                 
}}
 

 function permintaan(isi){
if(isi==""){
document.getElementById('namaup').value="";
document.getElementById('namaup2').value="";
document.getElementById('namaup3').value="";
document.getElementById('namaup4').value="";
document.getElementById('namaup5').value="";
document.getElementById('namaup6').value="";
document.getElementById('namaup7').value="";
document.getElementById('namaup8').value="";
document.getElementById('namaup9').value="";
document.getElementById('namaup10').value="";
document.getElementById('namaup11').value="";
document.getElementById('namaup12').value="";
document.getElementById('namaup13').value="";
document.getElementById('namaup14').value="";
document.getElementById('namaup15').value="";}
else{
document.getElementById('namaup').value=(isi);
document.getElementById('namaup2').value=(isi);
document.getElementById('namaup3').value=(isi);
document.getElementById('namaup4').value=(isi);
document.getElementById('namaup5').value=(isi);
document.getElementById('namaup6').value=(isi);
document.getElementById('namaup7').value=(isi);
document.getElementById('namaup8').value=(isi);
document.getElementById('namaup9').value=(isi);
document.getElementById('namaup10').value=(isi);
document.getElementById('namaup11').value=(isi);
document.getElementById('namaup12').value=(isi);
document.getElementById('namaup13').value=(isi);
document.getElementById('namaup14').value=(isi);
document.getElementById('namaup15').value=(isi);
}}

 function permintaan2(isi2){
if(isi2==""){
document.getElementById('bagianup').value="";
document.getElementById('bagianup2').value="";
document.getElementById('bagianup3').value="";
document.getElementById('bagianup4').value="";
document.getElementById('bagianup5').value="";
document.getElementById('bagianup6').value="";
document.getElementById('bagianup7').value="";
document.getElementById('bagianup8').value="";
document.getElementById('bagianup9').value="";
document.getElementById('bagianup10').value="";
document.getElementById('bagianup11').value="";
document.getElementById('bagianup12').value="";
document.getElementById('bagianup13').value="";
document.getElementById('bagianup14').value="";
document.getElementById('bagianup15').value="";}
else{
document.getElementById('bagianup').value=(isi2);
document.getElementById('bagianup2').value=(isi2);
document.getElementById('bagianup3').value=(isi2);
document.getElementById('bagianup4').value=(isi2);
document.getElementById('bagianup5').value=(isi2);
document.getElementById('bagianup6').value=(isi2);
document.getElementById('bagianup7').value=(isi2);
document.getElementById('bagianup8').value=(isi2);
document.getElementById('bagianup9').value=(isi2);
document.getElementById('bagianup10').value=(isi2);
document.getElementById('bagianup11').value=(isi2);
document.getElementById('bagianup12').value=(isi2);
document.getElementById('bagianup13').value=(isi2);
document.getElementById('bagianup14').value=(isi2);
document.getElementById('bagianup15').value=(isi2);
}}


 function permintaan3(isi3){
if(isi3==""){
document.getElementById('divisiup').value="";
document.getElementById('divisiup2').value="";
document.getElementById('divisiup3').value="";
document.getElementById('divisiup4').value="";
document.getElementById('divisiup5').value="";
document.getElementById('divisiup6').value="";
document.getElementById('divisiup7').value="";
document.getElementById('divisiup8').value="";
document.getElementById('divisiup9').value="";
document.getElementById('divisiup10').value="";
document.getElementById('divisiup11').value="";
document.getElementById('divisiup12').value="";
document.getElementById('divisiup13').value="";
document.getElementById('divisiup14').value="";
document.getElementById('divisiup15').value="";}
else{
document.getElementById('divisiup').value=(isi3);
document.getElementById('divisiup2').value=(isi3);
document.getElementById('divisiup3').value=(isi3);
document.getElementById('divisiup4').value=(isi3);
document.getElementById('divisiup5').value=(isi3);
document.getElementById('divisiup6').value=(isi3);
document.getElementById('divisiup7').value=(isi3);
document.getElementById('divisiup8').value=(isi3);
document.getElementById('divisiup9').value=(isi3);
document.getElementById('divisiup10').value=(isi3);
document.getElementById('divisiup11').value=(isi3);
document.getElementById('divisiup12').value=(isi3);
document.getElementById('divisiup13').value=(isi3);
document.getElementById('divisiup14').value=(isi3);
document.getElementById('divisiup15').value=(isi3);
}}

 function noper(noper){
if(noper==""){
document.getElementById('noper').value="";
}
else{
document.getElementById('noper').value=(noper);
}}

</script>
<?php
$datee=date('20y-m-d');
 $jam = date("H:i");
$date=date('ymd');
function kdauto($tabel, $inisial) {
    global $conn; // Pastikan koneksi sqlsrv tersedia

    // Ambil nama kolom pertama dan panjang maksimum kolom
  
    $query_struktur = "
    WITH ColumnInfo AS (
        SELECT 
            COLUMN_NAME,
            ROW_NUMBER() OVER (ORDER BY ORDINAL_POSITION) AS RowNum,
            CHARACTER_MAXIMUM_LENGTH  AS Columnlength
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_NAME = ?
    )
    SELECT 
        Columnlength AS TotalColumns,
        COLUMN_NAME AS SecondColumnName
    FROM ColumnInfo
    WHERE RowNum = 2;
    ";
    $params_struktur = array($tabel);
    $stmt_struktur = sqlsrv_query($conn, $query_struktur, $params_struktur);

    if ($stmt_struktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $field = null;
    $maxLength = null; // Default jika tidak ditemukan panjang kolom
    if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
        $field = $row['SecondColumnName']; // Ambil nama kolom pertama
        $maxLength = $row['TotalColumns'] ?? $maxLength;
    }
    sqlsrv_free_stmt($stmt_struktur);

    if ($field === null) {
        die("Kolom tidak ditemukan pada tabel: $tabel");
    }

    // Ambil nilai maksimum dari kolom tersebut
    $query_max = "SELECT MAX($field) AS maxKode FROM $tabel";
    $stmt_max = sqlsrv_query($conn, $query_max);

    if ($stmt_max === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt_max, SQLSRV_FETCH_ASSOC);

    $angka = 0;
    if (!empty($row['maxKode'])) {
        $angka = (int) substr($row['maxKode'], strlen($inisial));
    }
    $angka++;

    sqlsrv_free_stmt($stmt_max);

    // Tentukan padding berdasarkan panjang kolom
    $padLength = $maxLength - strlen($inisial);
    if ($padLength <= 0) {
        die("Panjang padding tidak valid untuk kolom: $field");
    }

    // Menghasilkan kode baru
    return  $inisial. str_pad($angka, $padLength, "0", STR_PAD_LEFT); // Misalnya SUPP0001
}
$no_faktur=kdauto("tpengambilan",'');


if (isset($_POST['nofaktur'])) {
    $nofaktur = $_POST['nofaktur'];

    // Query untuk mengambil data dari tabel tpengambilan
    $query_pengambilan = "SELECT * FROM tpengambilan WHERE nofaktur = ?";
    $params_pengambilan = array($nofaktur);
    $lihatpengambilan = sqlsrv_query($conn, $query_pengambilan, $params_pengambilan);

    if ($lihatpengambilan === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    while ($hpengambilan = sqlsrv_fetch_array($lihatpengambilan, SQLSRV_FETCH_ASSOC)) {
        $no_faktur = $hpengambilan['nofaktur'];
        $tglambil = $hpengambilan['tglambil'];
        $jam = $hpengambilan['jam'];
        $nama = $hpengambilan['nama'];
        $bagian = $hpengambilan['bagian'];
        $divisi = $hpengambilan['divisi'];

        // Query untuk mengambil data dari tabel bagian
        $query_bagian = "SELECT * FROM bagian WHERE id_bagian = ?";
        $params_bagian = array($bagian);
        $sss = sqlsrv_query($conn, $query_bagian, $params_bagian);

        if ($sss === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($datasss = sqlsrv_fetch_array($sss, SQLSRV_FETCH_ASSOC)) {
            $id_bagianup = $datasss['id_bagian'];
            $bagianup = $datasss['bagian'];
        }
    }

    // Query untuk mengambil data dari tabel rincipermintaan
    $query_rinci = "SELECT * FROM rincipermintaan WHERE nofaktur = ?";
    $params_rinci = array($nofaktur);
    $kk = sqlsrv_query($conn, $query_rinci, $params_rinci);

    if ($kk === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($datakk = sqlsrv_fetch_array($kk, SQLSRV_FETCH_ASSOC)) {
        $noper = $datakk['nomor'];
    }

    // Query untuk mengambil data dari tabel permintaan
    $query_permintaan = "SELECT * FROM permintaan WHERE nomor = ?";
    $params_permintaan = array($noper);
    $kkk = sqlsrv_query($conn, $query_permintaan, $params_permintaan);

    if ($kkk === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($datakkk = sqlsrv_fetch_array($kkk, SQLSRV_FETCH_ASSOC)) {
        $nmpeminta = $datakkk['nama'];
    }
}




if (isset($_GET['nama'])) {
    $nama = $_GET['nama'];
    $bagianca = $_GET['bagian'];
    $divisi = $_GET['divisi'];
    $no_faktur = $_GET['no_faktur'];

    // Query untuk mengambil data dari tabel bagian
    $query_bagian = "SELECT * FROM bagian WHERE id_bagian = ?";
    $params_bagian = array($bagianca);
    $ss = sqlsrv_query($conn, $query_bagian, $params_bagian);

    if ($ss === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    while ($datass = sqlsrv_fetch_array($ss, SQLSRV_FETCH_ASSOC)) {
        $id_bagianup = $datass['id_bagian'];
        $bagianup = $datass['bagian'];
    }
}
?>

<?php
// $query_rinci_jual="SELECT *,sum(jumlah) as jum FROM trincipengambilan WHERE nofaktur='".$no_faktur."' group by idbarang";
// $get_hitung_rinci=mysql_query($query_rinci_jual);
// $hitung=mysql_num_rows($get_hitung_rinci);
// $total_jual=0; $total_item=0;
// while($hitung_total=mysql_fetch_array($get_hitung_rinci)){
// $jml=$hitung_total['jumlah'];
// $jum=$hitung_total['jum'];
// $sub_total=$hitung_total['sub_total_jual'];
// $total_jual=$sub_total+$total_jual;
// $total_item=$jml+$total_item;}

$query_rinci_jual = "SELECT idbarang, SUM(jumlah) AS jum 
                     FROM trincipengambilan 
                     WHERE nofaktur = ? 
                     GROUP BY idbarang";

$params_rinci_jual = array($no_faktur); // Parameterized query to prevent SQL injection

// Eksekusi query
$get_hitung_rinci = sqlsrv_query($conn, $query_rinci_jual, $params_rinci_jual);

// Cek jika query berhasil dijalankan
if ($get_hitung_rinci === false) {
    die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
}

$total_jual = 0;
$total_item = 0;

// Mengambil hasil query
while ($hitung_total = sqlsrv_fetch_array($get_hitung_rinci, SQLSRV_FETCH_ASSOC)) {
    $jml = $hitung_total['jum'];  // Jumlah total barang
    //$sub_total = $hitung_total['total_jual'];  // Subtotal per item
    //$total_jual += $sub_total;  // Total keseluruhan untuk penjualan
    $total_item += $jml;  // Total jumlah item
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#info_transaksi{
	height: 455px; width: 25%; float: left;
	background-color: #E8E8E8;
	font-family: Arial, Helvetica, sans-serif;}
#info_user{
	background-color: #CCC;
	height: 450px; width: 20%; float: left;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10pt; color: #000;
	font-weight: bold; padding-top: 5px;}

#kalkulator{
	height: 90px; width: 100%; border-bottom-width: 2px;
	border-bottom-color:#933; border-bottom-style:solid;
	padding-left: 10px; padding-top: 10px;}
#scanner{
	height:50px; width: 100%;
	border-bottom-width: 2px; border-bottom-color: #933;
	border-bottom-style: solid;
	padding-top: 10px; padding-left: 10px;}
#button_transaksi{
	height:45px; width: 100%;
	padding-top: 5px; padding-left: 10px;}
#data_barang{
	background-color: white; height: 450px; width:50%;
	float: left; overflow: scroll; padding-top: 5px;}
.td_total{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold; color: #03F;
	text-decoration: none;}
.td_cash{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold; color: #FF0;
	text-decoration: none;}
.td_kembali{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 25px; font-weight: bold;
	color: #F00; text-decoration: none;}
.tr_header_footer{
	background-color: #09F;
	font-size: 14px; color: #FFF; font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;}
.tr_isi{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px; color: #000;
	background-color: #FFF;}
</style>

<script language="javascript">
function onEnter(e){
var key=e.keyCode || e.which;
var kd_barang=document.getElementById('kd_barang').value;
var no_faktur=document.getElementById('no_faktur').value;
if(key==13){
document.location.href="aplikasi/simpanrinciambil.php?kd_barang="+kd_barang+"&no_faktur="+no_faktur;} }
</script>
</head>

<body onload="document.getElementById('kd_barang').focus()">

<h4 ><?php if(isset($_GET['stt'])){
$stt=$_GET['stt'];
echo "".$stt."";?><img src="img/centang.png" style="width: 50px; height: 30px; "><?php }
?> PENGAMBILAN BARANG </h4>


<div style="overflow:scroll;width:600px;height:450px;" id="data_barang">
        <div class="panel-bod">
                            <div class="table-responsiv">
							
							<form action="aplikasi/simpanrincireturpengambilanadmin.php" method="post" name="fsimpan" >
	  <input  class="form-control"  type="hidden" id="namaup"  name="nama" value="<?php echo $nama; ?>"   >	  
 <input  class="form-control"  type="hidden" id="bagianup"  name="bagian"  value="<?php echo $id_bagianup; ?>" >	 
 <input  class="form-control"  type="hidden" id="divisiup"  name="divisi" value="<?php echo $divisi; ?>"  >	  
							                            <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                       
											<th>ID Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>Tambah</th>
										
										
                                        </tr>
										
  <tr class="tr_isi">
  <td><div id="suggestSearch">
<input name="barang" type="text" id="dbTxt" alt="Search Criteria" onKeyUp="searchSuggest();"  onchange="new sendRequest(this.value)"  autocomplete="off"/>
<div  id="layer1" onclick="new sendRequest(this.value)"  class="isi_tabelll" ></div></div></td>
  <td ><label>
        <input type="text" name="idbarang" id="www" readonly />
		<input  class="form-contro" type="hidden"  id="asfa" name="kategori" readonly >
      </label>
 </td>
 <td><input  class="form-contro" type="text"  name="jumlah"  ></td>

	 <td>
										
<input type="hidden" name="nofaktur" value=<?php echo $no_faktur; ?> />										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">+</button>
											</td>
  </tr>


                                    </thead>
                    
                                </table>
							
							</form>
							
							
							
							
							
							
							
							
                                <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>ID Barang</th>
                                       
											<th>Nama Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>Hapus</th>
										
										
                                        </tr>
										  <?php
$rinci_jual_query = "SELECT * FROM trincipengambilan WHERE nofaktur = ?";
$params_rinci_jual = array($no_faktur);
// Menjalankan query menggunakan sqlsrv_query
$rinci_jual = sqlsrv_query($conn, $rinci_jual_query, $params_rinci_jual);
$angka = 2;
$angka2 = 2;
$angka3 = 2;
// Mengambil hasil query
while ($data_rinci = sqlsrv_fetch_array($rinci_jual, SQLSRV_FETCH_ASSOC)) {
$idbarang=$data_rinci['idbarang'];
$namabarang=$data_rinci['namabarang'];
//$jumlah=$data_rinci['jumlah'];
$jum=$data_rinci['jumlah'];
 
  ?>
  <tr class="tr_isi">
    <td><?php echo $idbarang; ?>&nbsp;</td>
    <td><?php echo $namabarang; ?>&nbsp;</td>
    <td><?php echo $jum; ?>&nbsp;</td>

	 <td><form action="aplikasi/deleterincireturpengambilanadmin.php" method="post" >
	  <input  class="form-control"  type="hidden" id="namaup<?php echo $angka++; ?>"  name="nama" value="<?php echo $nama; ?>"   >	  
 <input  class="form-control"  type="hidden" id="bagianup<?php echo $angka2++; ?>"  name="bagian"  value="<?php echo $id_bagianup; ?>" >	 
 <input  class="form-control"  type="hidden" id="divisiup<?php echo $angka3++; ?>"  name="divisi" value="<?php echo $divisi; ?>"  >
											<input type="hidden" name="kd_barang" value=<?php echo $idbarang; ?> />
<input type="hidden" name="no_faktur" value=<?php echo $no_faktur; ?> />
<input type="hidden" name="noper" id="noper" value="<?php echo $noper;?>"  />										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form></td>
  </tr>
<?php } ?>
  <tr class="header_tabel">
    <td>&nbsp;</td>

    <td>Total</td>
    <td><?php echo $total_item; ?>Items</td>

	  <td></td>
  </tr>
                                    </thead>
                    
                                </table>
                            </div>
                           
                        </div>
</div>
    


<div id="info_transaksi">
<!--
  <div id="scanner">Barcode: 
      <input  type="text" name="kd_barang" id="kd_barang" onkeypress="onEnter(event)" />
  </div>

-->


      <form id="form_penjualan" name="form_penjualan" method="post" action="aplikasi/updatereturpengambilanadmin.php" >

        <input class="form-control" name="no_faktur" type="hidden" id="no_faktur" value="<?php echo $no_faktur; ?>" size="16" readonly="readonly" />
		<input class="form-control" name="id_user" type="hidden" id="id_user" value="<?php echo $id_user; ?>" size="16" readonly="readonly" />
        <br >

	
		
                                            
                                            <input  class="form-control" value="<?php echo $datee; ?>" type="hidden" name="tglambil" readonly>
		
		
                                            
                                            <input  class="form-control" value="<?php echo $jam; ?>" type="hidden" name="jam" readonly >											

		Nama
		
                                            
   <input  class="form-control"  type="text" name="nama"  value="<?php echo $nama; ?>" required='required' onchange="new permintaan(this.value)"  >
                                    

                                           
Bagian                                      
<select class="form-control" name='bagian' required='required' onchange="new permintaan2(this.value)">
    <option selected="selected" value="<?php echo $id_bagianup; ?>"><?php echo $bagianup; ?></option>
    <?php
    // Query untuk mengambil data dari tabel bagian
    $query = "SELECT * FROM bagian ORDER BY bagian ASC";
    $s = sqlsrv_query($conn, $query);

    // Periksa apakah query berhasil
    if ($s === false) {
        die(print_r(sqlsrv_errors(), true)); // Tampilkan error jika query gagal
    }

    // Loop untuk menampilkan data
    while ($datas = sqlsrv_fetch_array($s, SQLSRV_FETCH_ASSOC)) {
        $idbagian = $datas['id_bagian'];
        $bagian = $datas['bagian'];
        ?>
        <option value="<?php echo $idbagian; ?>"> <?php echo $bagian; ?>
        </option>
    <?php } ?>
</select>

                                    

                                           
Divisi                                    
<select class="form-control" name="divisi" required='required' onchange="new permintaan3(this.value)">
    <option selected="selected" value="<?php echo $divisi; ?>"><?php echo $divisi; ?></option>
    <option value="AMBASADOR">AMBASADOR</option>
    <option value="EFRATA">EFRATA</option>
    <option value="GARMENT">GARMENT</option>
    <option value="MAS">MAS</option>
    <option value="TEXTILE">TEXTILE</option>
</select>
       
Permintaan Dari                                     
<select class="form-control" name='nomor'>
    <option selected="selected"></option>
    <?php
    // Query untuk mengambil data dari tabel permintaan
    $query = "SELECT * FROM permintaan WHERE 'status' != 'selesai' AND aktif != 'nonaktif' ORDER BY nama ";
    
    // Menjalankan query menggunakan SQL Server
    $sss = sqlsrv_query($conn, $query);
    
    // Mengecek apakah query berhasil dijalankan
    if ($sss === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Mengambil hasil query dan menampilkan data
    while ($datasss = sqlsrv_fetch_array($sss, SQLSRV_FETCH_ASSOC)) {
        $nomor = $datasss['nomor'];
        $keterangan = $datasss['keterangan'];
        $tgllll = $datasss['tgl'];
        
        // Memformat tanggal (menggunakan substring untuk memisah bagian tahun, bulan, hari)
        // $t = substr($tgllll, 0, 4);
        // $b = substr($tgllll, -5, 2);
        // $h = substr($tgllll, -2, 2);
        // $tglllll = $h . '-' . $b . '-' . $t;
        
        $bagian = $datasss['bagian'];
        $nama = $datasss['nama'];
        $qty = $datasss['qty'];
        $sisa = $datasss['sisa'];
        $namabarang = $datasss['namabarang'];
        $divisi = $datasss['divisi'];
    ?>
        <option value="<?php echo $nomor; ?>">
            <?php echo $nama . '/' . $bagian . '/' . $divisi . '/' . $namabarang . '/' .$tgllll->format("Y-m-d") .'/'. $keterangan . '/' . '/JUMLAH:' . $qty; ?>
        </option>
    <?php } ?>
</select>
<br>
<?php	
			$query = "SELECT * FROM trincipengambilan WHERE nofaktur = ?";
			$params = array($no_faktur);

			// Eksekusi query
			$sss = sqlsrv_query($conn, $query, $params);

			// Periksa apakah ada baris yang ditemukan
			if ($sss && sqlsrv_has_rows($sss)) {
		?>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

 <button name="button_selesai" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
				<?php } ?>
	  </form>
    </div>	
</body>
</html>
<meta http-equiv=refresh content=180;url='user.php?menu=homeadmin'>
