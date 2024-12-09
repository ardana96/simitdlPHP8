<?php
include('config.php');
?>
<script language="JavaScript" type="text/javascript" src="suggest.js"></script>
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
document.getElementById('tglup').value="";
document.getElementById('tglup2').value="";
document.getElementById('tglup3').value="";
document.getElementById('tglup4').value="";
document.getElementById('tglup5').value="";
document.getElementById('tglup6').value="";
document.getElementById('tglup7').value="";
document.getElementById('tglup8').value="";
document.getElementById('tglup9').value="";
document.getElementById('tglup10').value="";
document.getElementById('tglup11').value="";
document.getElementById('tglup12').value="";
document.getElementById('tglup13').value="";
document.getElementById('tglup14').value="";
document.getElementById('tglup15').value="";}
else{
document.getElementById('tglup').value=(isi);
document.getElementById('tglup2').value=(isi);
document.getElementById('tglup3').value=(isi);
document.getElementById('tglup4').value=(isi);
document.getElementById('tglup5').value=(isi);
document.getElementById('tglup6').value=(isi);
document.getElementById('tglup7').value=(isi);
document.getElementById('tglup8').value=(isi);
document.getElementById('tglup9').value=(isi);
document.getElementById('tglup10').value=(isi);
document.getElementById('tglup11').value=(isi);
document.getElementById('tglup12').value=(isi);
document.getElementById('tglup13').value=(isi);
document.getElementById('tglup14').value=(isi);
document.getElementById('tglup15').value=(isi);
}}

 function permintaan2(isi2){
if(isi2==""){
document.getElementById('supup').value="";
document.getElementById('supup2').value="";
document.getElementById('supup3').value="";
document.getElementById('supup4').value="";
document.getElementById('supup5').value="";
document.getElementById('supup6').value="";
document.getElementById('supup7').value="";
document.getElementById('supup8').value="";
document.getElementById('supup9').value="";
document.getElementById('supup10').value="";
document.getElementById('supup11').value="";
document.getElementById('supup12').value="";
document.getElementById('supup13').value="";
document.getElementById('supup14').value="";
document.getElementById('supup15').value="";}
else{
document.getElementById('supup').value=(isi2);
document.getElementById('supup2').value=(isi2);
document.getElementById('supup3').value=(isi2);
document.getElementById('supup4').value=(isi2);
document.getElementById('supup5').value=(isi2);
document.getElementById('supup6').value=(isi2);
document.getElementById('supup7').value=(isi2);
document.getElementById('supup8').value=(isi2);
document.getElementById('supup9').value=(isi2);
document.getElementById('supup10').value=(isi2);
document.getElementById('supup11').value=(isi2);
document.getElementById('supup12').value=(isi2);
document.getElementById('supup13').value=(isi2);
document.getElementById('supup14').value=(isi2);
document.getElementById('supup15').value=(isi2);
}}


 function permintaan3(isi3){
if(isi3==""){
document.getElementById('ketup').value="";
document.getElementById('ketup2').value="";
document.getElementById('ketup3').value="";
document.getElementById('ketup4').value="";
document.getElementById('ketup5').value="";
document.getElementById('ketup6').value="";
document.getElementById('ketup7').value="";
document.getElementById('ketup8').value="";
document.getElementById('ketup9').value="";
document.getElementById('ketup10').value="";
document.getElementById('ketup11').value="";
document.getElementById('ketup12').value="";
document.getElementById('ketup13').value="";
document.getElementById('ketup14').value="";
document.getElementById('ketup15').value="";}
else{
document.getElementById('ketup').value=(isi3);
document.getElementById('ketup2').value=(isi3);
document.getElementById('ketup3').value=(isi3);
document.getElementById('ketup4').value=(isi3);
document.getElementById('ketup5').value=(isi3);
document.getElementById('ketup6').value=(isi3);
document.getElementById('ketup7').value=(isi3);
document.getElementById('ketup8').value=(isi3);
document.getElementById('ketup9').value=(isi3);
document.getElementById('ketup10').value=(isi3);
document.getElementById('ketup11').value=(isi3);
document.getElementById('ketup12').value=(isi3);
document.getElementById('ketup13').value=(isi3);
document.getElementById('ketup14').value=(isi3);
document.getElementById('ketup15').value=(isi3);
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
$date=date('d-m-20y');
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
$no_faktur=kdauto("tpembelian",'');
	
	

// Koneksi ke SQL Server
// Pastikan Anda telah membuat koneksi $conn sebelumnya, misalnya:
// $conn = sqlsrv_connect($serverName, $connectionOptions);

if (isset($_POST['nofaktur'])) {
    $no_faktur = $_POST['nofaktur'];

    // Query untuk ambil data dari tpembelian
    $sql_pembelian = "SELECT * FROM tpembelian WHERE nofaktur = ?";
    $params = array($no_faktur);
    $query_pembelian = sqlsrv_query($conn, $sql_pembelian, $params);

    if ($query_pembelian) {
        while ($hpembelian = sqlsrv_fetch_array($query_pembelian, SQLSRV_FETCH_ASSOC)) {
            $no_faktur = $hpembelian['nofaktur'];
            $idsupp = $hpembelian['idsupp'];
            $tglawal = $hpembelian['tglbeli'];

            // Format tanggal
            // $tahunawal = substr($tglawal, 0, 4);
            // $bulanawal = substr($tglawal, -5, 2);
            // $tanggalawal = substr($tglawal, -2, 2);
            $tglbeli = $tglawal->format("Y-m-d");
            $keterangan = $hpembelian['keterangan'];

            // Query untuk ambil data supplier
            $sql_supplier = "SELECT * FROM tsupplier WHERE idsupp = ?";
            $params_supplier = array($idsupp);
            $query_supplier = sqlsrv_query($conn, $sql_supplier, $params_supplier);

            if ($query_supplier) {
                while ($datasss = sqlsrv_fetch_array($query_supplier, SQLSRV_FETCH_ASSOC)) {
                    $idsupp = $datasss['idsupp'];
                    $namasupp = $datasss['namasupp'];
                }
            }

            // Query untuk ambil data rincian permintaan
            $sql_rinci = "SELECT * FROM rincipermintaan WHERE nofaktur = ?";
            $params_rinci = array($no_faktur);
            $query_rinci = sqlsrv_query($conn, $sql_rinci, $params_rinci);

            if ($query_rinci) {
                while ($datakk = sqlsrv_fetch_array($query_rinci, SQLSRV_FETCH_ASSOC)) {
                    $noper = $datakk['nomor'];
                }
            }

            // Query untuk ambil data permintaan berdasarkan nomor
            $sql_permintaan = "SELECT * FROM permintaan WHERE nomor = ?";
            $params_permintaan = array($noper);
            $query_permintaan = sqlsrv_query($conn, $sql_permintaan, $params_permintaan);

            if ($query_permintaan) {
                while ($datakkk = sqlsrv_fetch_array($query_permintaan, SQLSRV_FETCH_ASSOC)) {
                    $nmpeminta = $datakkk['nama'];
                }
            }
        }
    }
}


	
if(isset($_GET['tglbeli'])){
$tglbeli=$_GET['tglbeli'];
$namasupp=$_GET['namasupp'];
$keterangan=$_GET['keterangan'];
	}

?>

<?php
$query_rinci_jual = "SELECT MAX(idbarang), MAX(namabarang),  SUM(jumlah) AS jum FROM trincipembelian WHERE nofaktur = ? GROUP BY idbarang";
$params = array($no_faktur);

// Eksekusi query menggunakan sqlsrv_query
$get_hitung_rinci = sqlsrv_query($conn, $query_rinci_jual, $params);

// Inisialisasi variabel total
$total_jual = 0;
$total_item = 0;

// Mengecek apakah query berhasil
if ($get_hitung_rinci) {
    // Loop untuk mengambil hasil query
    while ($hitung_total = sqlsrv_fetch_array($get_hitung_rinci, SQLSRV_FETCH_ASSOC)) {
        $jml = $hitung_total['jum']; // Jumlah barang
        // $sub_total = $hitung_total['total_jual']; // Total penjualan

        // // Menjumlahkan total jual dan total item
        // $total_jual += $sub_total;
        $total_item += $jml;
    }
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
document.location.href="aplikasi/simpanrincipemasukan.php?kd_barang="+kd_barang+"&no_faktur="+no_faktur;} }
</script>
</head>

<body onload="document.getElementById('kd_barang').focus()">
<h4 >PEMASUKAN BARANG </h4>


<div style="overflow:scroll;width:600px;height:450px;" id="data_barang">
        <div class="panel-bod">
                            <div class="table-responsiv">
							
							<form action="aplikasi/simpanrincireturmasuk.php" method="post" >
							
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
<input  class="form-control"  type="hidden" id="tglup"  name="tglbeli" value="<?php echo $tglbeli; ?>"   >	  
 <input  class="form-control"  type="hidden" id="supup"  name="namasupp"  value="<?php echo $namasupp; ?>" >	 
 <input  class="form-control"  type="hidden" id="ketup"  name="keterangan" value="<?php echo $keterangan; ?>"  >
 
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

		<td>
			<form action="aplikasi/deleterincireturmasuk.php" method="post" >
				<input  class="form-control"  type="hidden" id="tglup<?php echo $angka++; ?>"  name="tglbeli" value="<?php echo $tglbeli; ?>"   >	  
				<input  class="form-control"  type="hidden" id="supup<?php echo $angka2++; ?>"  name="namasupp"  value="<?php echo $namasupp; ?>" >	 
				<input  class="form-control"  type="hidden" id="ketup<?php echo $angka3++; ?>"  name="keterangan" value="<?php echo $keterangan; ?>"  >
				<input type="hidden" name="kd_barang" value=<?php echo $idbarang; ?> />
				<input type="hidden" name="no_faktur" value=<?php echo $no_faktur; ?> />	
				<input type="hidden" name="noper" id="noper" value="<? echo $noper;?>"   />										
					<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
			</form>
		</td>
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

 

    <form id="form_penjualan" name="form_penjualan" method="post" action="aplikasi/updatereturmasuk.php" >

        <input class="form-control" name="no_faktur" type="hidden" id="no_faktur" value="<?php echo $no_faktur; ?>" size="16" readonly="readonly" />
		<input class="form-control" name="id_user" type="hidden" id="id_user" value="<?php echo $id_user; ?>" size="16" readonly="readonly" />
     

		
		
            Tanggal
            <input  class="form-control" value="<?php echo $tglbeli; ?>" type="text" name="tglbeli" onchange="new permintaan(this.value)" >                           
            <input  class="form-control" value="<?php echo $jam; ?>" type="hidden" name="jam" readonly >											
                                
    		Nama Supplier                                    
			<select class="form-control" name='idsupp' required='required' onchange="new permintaan2(this.value)">
				<option selected="selected" value="<?php echo $idsupp; ?>"><?php echo $namasupp; ?></option>
				<?php
				// Koneksi ke database
				$query = "SELECT * FROM tsupplier"; // Query SQL untuk mengambil data dari tsupplier
				$result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query
				
				// Mengecek apakah query berhasil
				if ($result === false) {
					die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
				}

				// Mengambil data dari hasil query
				while($datas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
					$idsupp = $datas['idsupp'];
					$namasupp = $datas['namasupp'];
				?>
				<option value="<?php echo $idsupp; ?>"> <?php echo $namasupp; ?>
				</option>
				<?php } ?>
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
             
             Keterangan Pembelian
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" placeholder="" onchange="new permintaan3(this.value)"><?php echo $keterangan;?></textarea>                                    
                                

                                   
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
 				<button  name="button_selesai" id="button_selesai" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
				<?php } ?>
	  </form>
    </div> 
</body>
</html>



	   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Barang</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanbarangmasuk.php" method="post"  enctype="multipart/form-data" name="postform2">
                                       <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idbarang" value="<? echo kdauto("tbarang",""); ?>" readonly>
                                    
                                        </div>
										 <div class="form-group">
                                         Barcode Barang
                                            <input class="form-control" type="text" name="barcode" placeholder="Barcode Barang"  >
                                    
                                        </div>
											
<div class="form-group">
                                           
Kategori                                         
<select class="form-control" name='idkategori' required="required">
    <option></option>
    <?php
    // Query untuk mengambil data dari tabel tkategori
    $query = "SELECT * FROM tkategori";
    $result = sqlsrv_query($conn, $query); // Eksekusi query menggunakan sqlsrv_query

    // Mengecek apakah query berhasil
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
    }

    // Mengambil data hasil query
    while ($datas = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $idkategori = $datas['idkategori'];
        $kategori = $datas['kategori'];
    ?>
        <option value="<?php echo $idkategori; ?>"><?php echo $kategori; ?></option>
    <?php } ?>
</select>

                                    
                                        </div>	
	
<div class="form-group">
         Nama Barang                                   
                                            <input  placeholder="Nama Barang" class="form-control" type="text" name="namabarang" >
                                    
                                        </div>	
										<div class="form-group">
    Inventaris ( Barang bisa dipinjam )
                                         
        <select class="form-control" name='inventory' required="required">
			 <option ></option>
		 <option  value='Y' >YA</option>
		 <option  value='T' >TIDAK</option>
            
			
			
    
        </select>
                                    
                                        </div>	

																				<div class="form-group">
    Refil
                                         
        <select class="form-control" name='refil' required="required">
			 <option ></option>
		 <option  value='Y' >YA</option>
		 <option  value='T' >TIDAK</option>
            
			
			
    
        </select>
                                    
                                        </div>	
                                    Keterangan / Spesifikasi 
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="ket" size="15px" placeholder="" ></textarea>                                    
                    
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>
					
					
					  <div class="col-lg-12">
                        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Tambah Supplier</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpansuppliermasuk.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idsupp" value="<?php echo kdauto("tsupplier",""); ?>" readonly>
                                    
                                        </div>
									  <div class="form-group">
                                           Nama Supplier
                                            <input placeholder="Nama Supplier" class="form-control" type="text" name="namasupp"  >
                                    
                                        </div>	
	
<div class="form-group">
Alamat Supplier                                            
                                            <input  placeholder="Alamat" class="form-control" type="text" name="alamatsupp" >
                                    
                                        </div>	
<div class="form-group">
                Telp Supplier                         
                                            <input  placeholder="Telp" class="form-control" type="text" name="telpsupp" >
                                    
                                        </div>	
                                       
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Simpan</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>