 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

</script>
<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<script language="JavaScript" type="text/javascript" src="suggest2.js"></script>
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


function sendRequest2(barang2){
if(barang2==""){
alert("Anda belum memilih  barang");}
else{   
http.open('GET','koneksi/ajax.php?barang=' + encodeURIComponent(barang2) , true);
http.onreadystatechange = handleResponse2;
http.send(null);}}

function handleResponse2(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');       
document.getElementById('asfa2').value = string[2]; 
document.getElementById('www2').value = string[0];                                 
}}


</script>
<?php
include('config.php');
?>

<?php
$tglkasus='';
$jamkasus='';
if (isset($_GET['nomor'])) {
    $nomor = $_GET['nomor'];
    // $tdk = $_GET['tindakan'];
    // $teknisi = $_GET['teknisi'];

    // Query untuk mendapatkan data dari tabel service
    $query_service = "SELECT * FROM service WHERE nomor = ?";
    $params_service = array($nomor);
    $stmt_service = sqlsrv_query($conn, $query_service, $params_service);

    if ($stmt_service === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    while ($result = sqlsrv_fetch_array($stmt_service, SQLSRV_FETCH_ASSOC)) {
        $nomorkasus = $result['nomor'];
        $tglkasus = $result['tgl'];
        $jamkasus = $result['jam'];
        $nama = $result['nama'];
        $bagian = $result['bagian'];
        $divisi = $result['divisi'];
        $perangkat = $result['perangkat'];
        $kasus = $result['kasus'];
        $ippckasus = $result['ippc'];

        // Query untuk mendapatkan data dari tabel pcaktif
        $query_pcaktif = "SELECT * FROM pcaktif WHERE ippc = ? OR idpc LIKE ?";
        $params_pcaktif = array($ippckasus, '%' . $ippckasus . '%');
        $stmt_pcaktif = sqlsrv_query($conn, $query_pcaktif, $params_pcaktif);

        if ($stmt_pcaktif === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        while ($dataa = sqlsrv_fetch_array($stmt_pcaktif, SQLSRV_FETCH_ASSOC)) {
            $nomorpc = $dataa['nomor'];
            $userpc = $dataa['user'];
            $divisipc = $dataa['divisi'];
            $bagianpc = $dataa['bagian'];
            $idpc = $dataa['idpc'];
            $namapc = $dataa['namapc'];
            $ospc = $dataa['os'];
            $bulanpc = $dataa['bulan'];
            $prosesorpc = $dataa['prosesor'];
            $mobopc = $dataa['mobo'];
            $monitorpc = $dataa['monitor'];
            $rampc = $dataa['ram'];
            $harddiskpc = $dataa['harddisk'];
            $jumlahpc = $dataa['jumlah'];
            $ram1pc = $dataa['ram1'];
            $ram2pc = $dataa['ram2'];
            $hd1pc = $dataa['hd1'];
            $hd2pc = $dataa['hd2'];
            $ippcpc = $dataa['ippc'];
            $powersuplypc = $dataa['powersuply'];
            $cassingpc = $dataa['cassing'];
            //$tglmasukc = $dataa['tglmasuk'];
            $dvdpc = $dataa['dvd'];
            $model = $dataa['model'];

            // Query untuk mendapatkan nama bulan
            $query_bulan = "SELECT * FROM bulan WHERE id_bulan = ?";
            $params_bulan = array($bulanpc);
            $stmt_bulan = sqlsrv_query($conn, $query_bulan, $params_bulan);

            if ($stmt_bulan === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            while ($databulan = sqlsrv_fetch_array($stmt_bulan, SQLSRV_FETCH_ASSOC)) {
                $bulannama = $databulan['bulan'];
            }
        }
    }
}
?>




<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
<style>
.isi_tabelll {
border:1px;
	font-size: 14pt; color: black;
	background-color: #FFF;}
</style>

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
$nofakturbeli=kdauto("tpembelian",'');
$query = "SELECT * FROM trincipengambilan WHERE nofaktur = ? AND sesi = ?";
$params = array($no_faktur, 'USR');
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

if (sqlsrv_has_rows($stmt)) {
    $keadaan = 'aktif';
} else {
    $keadaan = 'nonaktif';
}
?>

<?php

$query_rinci_jual = "SELECT  SUM(jumlah) as jum FROM trincipengambilan WHERE nofaktur = ? GROUP BY idbarang";
$params = array($no_faktur);
$stmt = sqlsrv_query($conn, $query_rinci_jual, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$total_jual = 0;
$total_item = 0;

while ($hitung_total = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $jml = $hitung_total['jumlah'];
    // $sub_total = $hitung_total['sub_total_jual']; // Pastikan kolom ini benar-benar ada di database Anda.
    // $total_jual += $sub_total;
    $total_item += $jml;
}


?>


<?php
// $query_rinci_beli="SELECT *,sum(jumlah) as jum FROM trincipembelian WHERE nofaktur='".$no_faktur."' group by idbarang";
// $get_hitung_beli=mysql_query($query_rinci_beli);
// $hitungbeli=mysql_num_rows($get_hitung_beli);
// $total_beli=0; $total_beli=0;
// while($hitung_beli=mysql_fetch_array($get_hitung_beli)){
// $jmlbeli=$hitung_beli['jumlah'];
// $sub_totalbeli=$hitung_beli['sub_total_beli'];
// $total_beli=$sub_totalbeli+$total_beli;
// $total_item=$jmlbeli+$total_item;}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
#info_transaksi{
	height: 455px; width: 20%; float: left;
	background-color: #E8E8E8;
	font-family: Arial, Helvetica, sans-serif;}
#data_barang{
	background-color: white; height: 450px; width:20%;
	float: left; overflow: scroll; padding-top: 5px;}
	#data_barang2{
	background-color: white; height: 450px; width:45%;
	float: left; overflow: scroll; padding-top: 5px;}
	

#info_service{
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
document.location.href="aplikasi/simpanrincipengeluaran.php?kd_barang="+kd_barang+"&no_faktur="+no_faktur;} }
</script>
</head>

<body onload="document.getElementById('kd_barang').focus()">
<?php if($keadaan<>'aktif'){ ?>
<h4 align='center'>UPDATE KERUSAKAN PC</h4>

<form action="aplikasi/simpanrincikeluarservice.php" method="post" >

<!-- DAFTAR PERMINTAAN SERVICE -->

<div id="info_transaksi">
<font color='blue'>PERMINTAAN SERVICE </font><br>
 Tanggal &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Jam
	<br>	                                    
   <input   type="text" size='10' name="TglKasus" value="<?php echo $tglkasus->format('Y-m-d'); ?>" readonly> 
   <input   type="text" size='10' name="JamKasus" value="<?php echo $jamkasus; ?>" readonly><br>
     
Nama / Bagian / Divisi
<input type="text" name="namakasus" id="nama" class="form-control" value="<?php echo $nama.'/'.$bagian.'/'.$divisi; ?>"  readonly  >
Permasalahan
<input type="text" name="kasuskasus" id="kasus" class="form-control" value="<?php echo $kasus; ?>"  readonly  > 
IP PC
<input type="text" name="ippckasus" id="ippckasus" class="form-control" value="<?php echo $ippckasus; ?>"  readonly  >     

    
    </div>
</div>

  

  
  <!-- DAFTAR PENGAMBILAN BARANG SERVICE -->
  <div style="overflow:scroll;height:450px;" id="data_barang2">
        <div class="panel-bod">
                            <div class="table-responsiv">
<font color='blue'>PENGAMBILAN BARANG SAAT SERVICE </font> 
							
							
<input class="form-control" name="nofaktur" type="hidden" id="no_faktur" value="<?php echo $no_faktur; ?>" size="16" readonly="readonly" />
<input class="form-control" name="nomorkasus" type="hidden" id="nomorkasus" value="<?php echo $nomorkasus; ?>" size="16" readonly="readonly" />							
							                            <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                       
											<th>ID Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>+</th>
										
										
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
// $rinci_jual=mysql_query($query_rinci_jual);
// while( $data_rinci=mysql_fetch_array($rinci_jual)){

	$rinci_jual = sqlsrv_query($conn, $query_rinci_jual, $params);

	if ($stmt === false) {
		die(print_r(sqlsrv_errors(), true));
	}
	
	$total_jual = 0;
	$total_item = 0;
	
	while ($data_rinci = sqlsrv_fetch_array($rinci_jual, SQLSRV_FETCH_ASSOC)) {
$idbarang=$data_rinci['idbarang'];
$namabarang=$data_rinci['namabarang'];
$jumlah=$data_rinci['jumlah'];
$jum=$data_rinci['jum'];
 
  ?>
  <tr class="tr_isi">
    <td><?php echo $idbarang; ?>&nbsp;</td>
    <td><?php echo $namabarang; ?>&nbsp;</td>
    <td><?php echo $jum; ?>&nbsp;</td>

	 <td><form action="aplikasi/deleterincikeluarservice.php" method="post" >
											<input type="hidden" name="kd_barang" value=<?php echo $idbarang; ?> />
<input type="hidden" name="no_faktur" value=<?php echo $no_faktur; ?> />	

<input type="hidden" name="TeknisiPerbaikan" id="teknisi" value="<? echo $teknisi; ?>"  >
<input type="hidden" name="TindakanPerbaikan" id="tindakan" value="<? echo $tdk; ?>"  >
<input type="hidden" name="nomorkasus" id="nomorkasus" value="<? echo $nomorkasus; ?>"  >



									
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
                           
						   
						   
		<!-- DAFTAR PEMASUKAN BARANG SERVICE -->				   
						                      <div class="table-responsiv">
				<font color="blue">PEMASUKAN BARANG SAAT SERVICE </font>
							<form action="aplikasi/simpanrincimasukservice.php" method="post" >
			<input type="hidden" name="TeknisiPerbaikan" id="teknisi" value="<? echo $teknisi; ?>"  >
<input type="hidden" name="TindakanPerbaikan" id="tindakan" value="<? echo $tdk; ?>"  >
<input type="hidden" name="nomorkasus" id="nomorkasus" value="<? echo $nomorkasus; ?>"  >

							                            <table class="table table-striped table-bordered table-hove" id="dataTables-exampl">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                       
											<th>ID Barang</th>
										
                                            <th>Jumlah</th>
											   
													    <th>+</th>
										
										
                                        </tr>
										
  <tr class="tr_isi">
  <td><div id="suggestSearch2">
<input name="barang2" type="text" id="dbTxt2" alt="Search Criteria" onKeyUp="searchSuggest2();"  onchange="new sendRequest2(this.value)"  autocomplete="off"/>
<div  id="layer2" onclick="new sendRequest2(this.value)"  class="isi_tabelll" ></div></div></td>
  <td ><label>
        <input type="text" name="idbarangbeli" id="www2" readonly />
		<input  class="form-contro" type="hidden"  id="asfa2" name="kategori" readonly >
      </label>
 </td>
 <td><input  class="form-contro" type="text"  name="jumlahbeli"  ></td>

	 <td>
										
<input type="hidden" name="nofakturbeli" value=<?php echo $nofakturbeli; ?> />										
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
$query_rinci_beli = "SELECT MAX(idbarang) as idbarang, MAX(namabarang) as namabarang,  SUM(jumlah) as jum FROM trincipembelian WHERE nofaktur = ? GROUP BY idbarang";
$rinci_beli = sqlsrv_query($conn, $query_rinci_beli, $params);

if ($rinci_beli === false) {
    die(print_r(sqlsrv_errors(), true));
}

while ($data_beli = sqlsrv_fetch_array($rinci_beli, SQLSRV_FETCH_ASSOC)) {


$idbarangbeli=$data_beli['idbarang'];
$namabarangbeli=$data_beli['namabarang'];
//$jumlahbeli=$data_beli['jumlah'];
$jumbeli=$data_beli['jum'];
$total_itembeli =+ $jumbeli;
 
  ?>
  <tr class="tr_isi">
    <td><?php echo $idbarangbeli; ?>&nbsp;</td>
    <td><?php echo $namabarangbeli; ?>&nbsp;</td>
    <td><?php echo $jumbeli; ?>&nbsp;</td>

	 <td><form action="aplikasi/deleterincimasukservice.php" method="post" >
				<input type="hidden" name="TeknisiPerbaikan" id="teknisi" value="<? echo $teknisi; ?>"  >
<input type="hidden" name="TindakanPerbaikan" id="tindakan" value="<? echo $tdk; ?>"  >
<input type="hidden" name="nomorkasus" id="nomorkasus" value="<? echo $nomorkasus; ?>"  >
											<input type="hidden" name="kd_barang" value=<?php echo $idbarangbeli; ?> />
<input type="hidden" name="no_faktur" value=<?php echo $nofakturbeli; ?> />										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form></td>
  </tr>
<?php } ?>
  <tr class="header_tabel">
    <td>&nbsp;</td>

    <td>Total</td>
    <td><?php echo $total_itembeli; ?>Items</td>

	  <td></td>
  </tr>
                                    </thead>
                    
                                </table>
                            </div>
						   
						   
                        </div>
</div>


<!-- UPDATE TOTAL SERVICE  -->
<div style="overflow:scroll;height:450px;" id="data_barang">
       
	                           <div class="panel-body">
		<form action="aplikasi/simpantotalservice.php" method="post" >				
	
	
	<font color='blue'>PERMINTAAN PERBAIKAN</font> <br>

  Tanggal &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Jam
	<br>	                                    
   <input   type="text" size='10' name="TglPerbaikan" value="<?php echo date('d-m-20y'); ?>" > 
   <input   type="text" size='10' name="JamPerbaikan" value="<?php echo date("H:i"); ?>" >
   <br>
Status Service / Update                                    
       <select class="form-control" name="statup" required='required'>
 <option  ></option>
 <option value="service">SERVICE</option>
 <option value="update">UPDATE</option>
</select>

Kategori                                  
       <select class="form-control" name="svc_kat" required='required'>
 <option  ></option>
 <option value="NON_SP">NON SPAREPART</option>
 <option value="SP">SPAREPART</option>
</select>		
	Permintaan Dari                                     
        <select class="form-control" name='noper' >
             <option selected="selected" ></option>
			
			 <?php
				$query = "SELECT * FROM permintaan WHERE status <> 'selesai' ORDER BY nama";
				$sss = sqlsrv_query($conn, $query);

				if ($sss === false) {
					die(print_r(sqlsrv_errors(), true));
				}

				if (sqlsrv_has_rows($sss)) {
					while ($datasss = sqlsrv_fetch_array($sss, SQLSRV_FETCH_ASSOC)) {
						$nomor = $datasss['nomor'];
						$bagian = $datasss['bagian'];
						$nama = $datasss['nama'];
						$namabarang = $datasss['namabarang'];
						$divisi = $datasss['divisi'];
						?>
						<option value="<?php echo $nomor; ?>">
							<?php echo $nama . '    /    ' . $bagian . '    /    ' . $divisi . '    /    ' . $namabarang; ?>
						</option>
						<?php
					}
				}
				?>
    
        </select>
Teknisi 
<input type="text" name="TeknisiPerbaikan" id="teknisi" class="form-control" size="25px" placeholder="" required="required"  >
 Tindakan

  <textarea cols="45" rows="7" name="TindakanPerbaikan" class="form-control" id="tindakan" size="15px" placeholder="" required="required"></textarea> 
<input class="form-control" name="nofaktur" type="hidden" id="no_faktur" value="<?php echo $no_faktur; ?>" size="16" readonly="readonly" />
	<input class="form-control" name="bagian" type="hidden" id="bagian" value="<?php echo $bagian; ?>" size="16" readonly="readonly" />
<input type="hidden" name="nomorkasus" id="nomorkasus" value="<?php echo $nomorkasus; ?>"  >
Keterangan  
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="keterangan" size="15px" placeholder="" ></textarea>                              
                  
					<font color='blue'>UPDATE SPESIFIKASI KOMPUTER </font><br>
 Bagian Pengambilan Barang                                     
 <select class="form-control" name='bagianambil' required='required'>
    <option></option>
    <?php
    $query = "SELECT * FROM bagian ORDER BY bagian ASC";
    $s = sqlsrv_query($conn, $query);

    if ($s === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($s)) {
        while ($datas = sqlsrv_fetch_array($s, SQLSRV_FETCH_ASSOC)) {
            $id_bagianambil = $datas['id_bagian'];
            $bagianambil = $datas['bagian'];
            ?>
            <option value="<?php echo $id_bagianambil; ?>"> <?php echo $bagianambil; ?>
            </option>
            <?php
        }
    }
    ?>
</select>

								
         

   		Divisi                                    
       <select class="form-control" name="divisiup" required='required'>
 <option value=<?php echo $divisipc; ?> ><?php echo $divisipc; ?></option>
 <option value="AMBASADOR">AMBASADOR</option>
 <option value="EFRATA">EFRATA</option>
 <option value="GARMENT">GARMENT</option>
 <option value="MAS">MAS</option>
 <option value="TEXTILE">TEXTILE</option>
</select>											
 Bagian Pemakai                                     
 <select class="form-control" name='bagianup' required='required'>
    <option value="<?php echo $bagianpc; ?>"><?php echo $bagianpc; ?></option>
    <?php
    $query = "SELECT * FROM bagian_pemakai ORDER BY bag_pemakai ASC";
    $s = sqlsrv_query($conn, $query);

    if ($s === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($s)) {
        while ($datas = sqlsrv_fetch_array($s, SQLSRV_FETCH_ASSOC)) {
            $id_bag_pemakai = $datas['id_bag_pemakai'];
            $bag_pemakai = $datas['bag_pemakai'];
            ?>
            <option value="<?php echo $bag_pemakai; ?>"> <?php echo $bag_pemakai; ?></option>
            <?php
        }
    }
    ?>
</select>

		User
		
                                            
                                            <input  class="form-control"  type="text" name="userup" value="<?php echo $userpc; ?>">
                                    
 ID Komputer
		
                                            
                                            <input  class="form-control"  type="text" name="idpcup" value="<?php echo $idpc; ?>" >
                                           
Nama Komputer
		
                                            
                                            <input  class="form-control"  type="text" name="namapcup" value="<?php echo $namapc; ?>">   
                                    
	
	   <div class="form-group">
 <b>Monitor </b>      
           <input  class="form-control"  type="text" name="monitorup" value="<?php echo $monitorpc; ?>" >
                                        
                                    
                                        </div>
										<b>Model</b>                                   
       <select class="form-control" name="model" required='required'>
 <option  value="<? echo $model; ?>" ><? echo $model; ?></option>
 <option value="CPU">CPU</option>
 <option value="LAPTOP">LAPTOP</option>
</select>
	   <div class="form-group">
 <b>Operation System</b>         
        <input  class="form-control"  type="text" name="osup" value="<?php echo $ospc; ?>" >
                                        
                                    
                                        </div>	
											   <div class="form-group">
 <b>IP Komputer</b>         
        <input    class="form-control"  type="text" name="ippcup"  value="<?php echo $ippcpc; ?>">
                                        
                                    
                                        </div>
						
	                                       <div class="form-group">
 <b>Total Kapasitas Harddsik</b>         
        <input  class="form-control"  type="text" name="harddiskup" value="<?php echo $harddiskpc; ?>">
                                        </div>
                                    
 
	   <div class="form-group">
 <b>Total Kapasitas RAM</b>         
        <input   class="form-control"  type="text" name="ramup" value="<?php echo $rampc; ?>">
                                        
                                    
                                        </div>		

  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>Tidak mengurangi Stock</font>          
 <select class="form-control" name='ram1up'>
    <option value="<?php echo $ram1pc; ?>"> <?php echo $ram1pc; ?></option>
    <?php
    $query = "SELECT * FROM tbarang WHERE idkategori = '00006'";
    $s6 = sqlsrv_query($conn, $query);

    if ($s6 === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($s6)) {
        while ($datas6 = sqlsrv_fetch_array($s6, SQLSRV_FETCH_ASSOC)) {
            $idbarang6 = $datas6['idbarang'];
            $namabarang6 = $datas6['namabarang'];
            ?>
            <option value="<?php echo $namabarang6; ?>"> <?php echo $namabarang6; ?></option>
            <?php
        }
    }
    ?>
</select>

                                        
                                    
                                        </div>

										
									  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>Tidak mengurangi Stock</font>          
      <select class="form-control" name='ram2up' >
	  <option value="<? echo $ram2pc; ?>" ><? echo $ram2pc; ?> </option>
            
	  <?php
    $query = "SELECT * FROM tbarang WHERE idkategori = '00006'";
    $s6 = sqlsrv_query($conn, $query);

    if ($s6 === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($s6)) {
        while ($datas6 = sqlsrv_fetch_array($s6, SQLSRV_FETCH_ASSOC)) {
            $idbarang6 = $datas6['idbarang'];
            $namabarang6 = $datas6['namabarang'];
            ?>
            <option value="<?php echo $namabarang6; ?>"> <?php echo $namabarang6; ?></option>
            <?php
        }
    }
    ?>
</select>
                                        
                                    
                                        </div>
 
										
   <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>Tidak mengurangi Stock</font>           
 <select class="form-control" name='hd1up'>
    <option value="<?php echo $hd1pc; ?>"><?php echo $hd1pc; ?></option>
    <?php
    $query = "SELECT * FROM tbarang WHERE idkategori = '00005'";
    $s5 = sqlsrv_query($conn, $query);

    if ($s5 === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($s5)) {
        while ($datas5 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
            $idbarang5 = $datas5['idbarang'];
            $namabarang5 = $datas5['namabarang'];
            ?>
            <option value="<?php echo $namabarang5; ?>"><?php echo $namabarang5; ?></option>
            <?php
        }
    }
    ?>
</select>

                                        
                                    
                                        </div>


  <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>Tidak mengurangi Stock</font>           
      <select class="form-control" name='hd2up' >
	  <option value="<? echo $hd2pc; ?>" ><? echo $hd2pc; ?> </option>
            
	<?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00005'";
		$s5 = sqlsrv_query($conn, $query);

		if ($s5 === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		if (sqlsrv_has_rows($s5)) {
			while ($datas5 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
				$idbarang5 = $datas5['idbarang'];
				$namabarang5 = $datas5['namabarang'];
				?>
				<option value="<?php echo $namabarang5; ?>"><?php echo $namabarang5; ?></option>
				<?php
			}
		}
    ?>
			
    
        </select> 
                                        
                                    
                                        </div>										
	
	   <div class="form-group">
 <b>Motherboard </b><font color=red>Tidak mengurangi Stock</font>         
      <select class="form-control" name='moboup' >	
	  <option value="<? echo $mobopc; ?>"><? echo $mobopc; ?> </option>
            
	  <?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00001'";
		$s5 = sqlsrv_query($conn, $query);

		if ($s5 === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		if (sqlsrv_has_rows($s5)) {
			while ($datas5 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
				$idbarang5 = $datas5['idbarang'];
				$namabarang5 = $datas5['namabarang'];
				?>
				<option value="<?php echo $namabarang5; ?>"><?php echo $namabarang5; ?></option>
				<?php
			}
		}
    ?>
			
    
        </select> 
                                        
                                    
                                        </div>
 
   <div class="form-group">
 <b>Prosesor</b><font color=red>Tidak mengurangi Stock</font>           
      <select class="form-control" name='prosesorup'>
	  <option value="<? echo $prosesorpc; ?>"><? echo $prosesorpc; ?> </option>
            
	  <?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00002'";
		$s5 = sqlsrv_query($conn, $query);

		if ($s5 === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		if (sqlsrv_has_rows($s5)) {
			while ($datas5 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
				$idbarang5 = $datas5['idbarang'];
				$namabarang5 = $datas5['namabarang'];
				?>
				<option value="<?php echo $namabarang5; ?>"><?php echo $namabarang5; ?></option>
				<?php
			}
		}
    ?>
			
    
        </select> 
                                        
                                    
                                        </div>

   <div class="form-group">
 <b>Power Supply</b><font color=red>Tidak mengurangi Stock</font>          
      <select class="form-control" name='powersuplyup'>
	  <option value="<? echo $powersuplypc; ?>"><? echo $powersuplypc; ?> </option>
            
			<?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00003'";
		$s5 = sqlsrv_query($conn, $query);

		if ($s5 === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		if (sqlsrv_has_rows($s5)) {
			while ($datas3 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
				?>
				<option value="<?php echo $namabarang3; ?>"><?php echo $namabarang3; ?></option>
				<?php
			}
		}
    ?>
			
    
        </select> 
                                        
                                    
                                        </div>
  
   <div class="form-group">
 <b>Cassing</b><font color=red>Tidak mengurangi Stock</font>           
      <select class="form-control" name='cassingup' >
	  <option value="<? echo $cassingpc; ?>"><? echo $cassingpc; ?> </option>
            
	  <?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00004'";
		$s5 = sqlsrv_query($conn, $query);

		if ($s5 === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		if (sqlsrv_has_rows($s5)) {
			while ($datas4 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
				$idbarang4 = $datas4['idbarang'];
				$namabarang4 = $datas4['namabarang'];
				?>
				<option value="<?php echo $namabarang4; ?>"><?php echo $namabarang4; ?></option>
				<?php
			}
		}
    ?>
			
    
        </select> 
                                        
                                    
                                        </div>
   
<div class="form-group">
 <b>DVD Internal</b> <font color=red>Tidak mengurangi Stock</font>         
      <select class="form-control" name='dvdup' >
	  <option value="<? echo $dvdpc; ?>" ><? echo $dvdpc; ?> </option>
            
	  <?php
		$query = "SELECT * FROM tbarang WHERE idkategori = '00008'";
		$s5 = sqlsrv_query($conn, $query);

		if ($s5 === false) {
			die(print_r(sqlsrv_errors(), true));
		}

		if (sqlsrv_has_rows($s5)) {
			while ($datas3 = sqlsrv_fetch_array($s5, SQLSRV_FETCH_ASSOC)) {
				$idbarang3 = $datas3['idbarang'];
				$namabarang3 = $datas3['namabarang'];
				?>
				<option value="<?php echo $namabarang3; ?>"><?php echo $namabarang3; ?></option>
				<?php
			}
		}
    ?>
			
    
        </select> 
                                        
                                    
                                        </div>
										 <div class="form-group">
 Bulan Perawatan         
      <input readonly class="form-control"  type="text" name="bulanup" value="<?php echo $bulannama; ?>" >    
                                        
                                    
                                        </div>	
   <input  class="form-control"  type="hidden" name="nomorup" value="<?php echo $nomorpc; ?>" >
   
   <input type="hidden" name="nofakturbeli" value=<?php echo $nofakturbeli; ?> />	
   
   
   
   
   
 <button  name="tombol" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>


									
       
			 </td>

                                    </form>
									<br>
									
                            </div>

	   
</div>
  
  
  <?php } else { ?>


	<div class="col-lg-12">
		<ul class="pricing-table" >

		<li class="active danger col-lg-4">
		<h4>MOHON MAAF</h4>
			<h4>Silahkan tunggu sebentar </h4>
		<h4>halaman masih digunakan user</h4>
		<h4>halaman akan automatis REFRESH</h4>
		<h4>klik menu pengambilan kembali </h4>
		<h4>Setelah REFRESH</h4>
			
			
			<div class="footer">
				<font color='black'>TERIMA KASIH ATAS WAKTU YANG TELAH DIBERIKAN</font>
			</div>
		</li>

				
	</ul>

	</div>
	</div>
	<br /><br />    <br />                                   
	<meta http-equiv=refresh content=60;url='pemakai.php?menu=home'>
	<?php } ?>
</body>
</html>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
           
		   