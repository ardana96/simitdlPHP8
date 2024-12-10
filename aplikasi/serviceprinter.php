<?php
include('config.php');
	
?>  
<?php
$jam = date("H:i");
?>
<?php
$tanggal = date("Y-m-d");
?>
<style>
.isi_tabelll {
border:1px;
	font-size: 14pt; color: black;
	background-color: #FFF;}
</style>
<script language="JavaScript" type="text/javascript" src="suggestprinter.js"></script>
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(nomor){
if(nomor==""){
alert("Anda belum memilih permasalahan  !");}
else{   

document.getElementById('nomorganti').value = encodeURIComponent(nomor);
document.getElementById('nomoroke').value = encodeURIComponent(nomor);
 
}}

function permintaan(keterangan){
if(keterangan==""){
alert("Anda belum memilih lokasi tempat printer   !");}
else{  
http.open('GET', 'aplikasi/filteridperangkat.php?keterangan=' + encodeURIComponent(keterangan) , true);
http.onreadystatechange = handleResponse;
http.send(null);
 }}
function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('bagian').value = string[0];  
document.getElementById('devisi').value = string[1];
document.getElementById('perangkat').value = string[2];
document.getElementById('id_perangkat').value = string[2];


}}




</script>
<?php
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
}?>

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Daftar Antrian Service Printer </h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                     <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                +
                            </button>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
										<th>Nomor</th>
										 <th>Tgl</th>
										 <th>Jam</th>
                                            <th>Nama</th>
                                            <th>No Printer</th>
                                            <th>Bagian</th>
											
											<th>Divisi</th>
											<th>Perangkat</th>
											<th>Permasalahan</th>
											<th>IT Penerima</th>
											<th>Pengerjaan</th>
											<th>Pengerjaan</th>
									
										
										
										
											<th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                       
                                       $query = "SELECT * FROM service WHERE noprinter <> '' AND status = 'pending'";
                                       $stmt = sqlsrv_query($conn, $query);
                                       
                                       if ($stmt === false) {
                                           // Tangkap error jika query gagal
                                           $errors = sqlsrv_errors();
                                           foreach ($errors as $error) {
                                               echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                                               echo "Kode Kesalahan: " . $error[0] . "<br>";
                                               echo "Pesan Kesalahan: " . $error[2] . "<br>";
                                           }
                                           die("Query gagal dijalankan.");
                                       }
                                       
                                       // Periksa apakah ada data yang ditemukan
                                       if (sqlsrv_has_rows($stmt)) {
                                           while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                               $tgl = $data['tgl'];
                                               $jam = $data['jam'];
                                               $nama = $data['nama'];
                                               $bagian = $data['bagian'];
                                               $divisi = $data['divisi'];
                                               $noprinter = $data['noprinter'];
                                               $status = $data['status'];
                                                $tgl=$data['tgl'] == null ? '' : $data['tgl']->format('Y-m-d');
                                                $jam=$data['jam'];
                                                $nama=$data['nama'];
                                                $ippc=$data['ippc'];
                                                $noprinter=$data['noprinter'];
                                                $bagian=$data['bagian'];
                                                $divisi=$data['divisi'];
                                                $perangkat=$data['perangkat'];
                                                $kasus=$data['kasus'];
                                                    $nomor=$data['nomor'];
                                                $penerima=$data['penerima'];
				
			// 	$sqlll = mysql_query("SELECT * FROM bulan where id_bulan='$bulan' ");
			// while($dataa = mysql_fetch_array($sqlll)){
			// $namabulan=$dataa['bulan'];}
				?>
				
                                        <tr class="gradeC">
											<td><?php echo $nomor ?></td>
									<td><?php echo $tgl ?></td>
									<td><?php echo $jam ?></td>
                                            <td><?php echo $nama ?></td>
                                            <td><?php echo $noprinter?></td>
                                            <td><?php echo $bagian ?></td>
											
											<td><?php echo $divisi ?></td>
											<td><?php echo $perangkat ?></td>
											<td><?php echo $kasus ?></td>
											<td><?php echo $penerima ?></td>
								 <!--				 <td class="center">
<a href='user.php?menu=fkerusakanprinter&nomor=<?php echo $nomor; ?>'>			
<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Di Dalam</button>
											</a> </td>-->
											
                           
											 <td class="center"><button class="btn btn-primary" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReggg" onclick="new sendRequest(this.value)">
                                Di Dalam 
                            </button> </td>
											 <td class="center"><button class="btn btn-primary" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReggggg" onclick="new sendRequest(this.value)">
                                Di Luar
                            </button> </td>
		
	
											
									<!--			 <td class="center"><form action="user.php?menu=fkerusakanpcbaru" method="post" >
									
											<input type="hidden" name="nomor" value= />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Percobaan</button>
											</form> </td>-->
											 
											 <td class="center"><form action="aplikasi/deleteserviceprinter.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>
											
                                            
                                        </tr>
                <?php }}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
           
		   
		   
		   
		   	   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Permintaan Service Printer</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanserviceprinter.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" id="no" class="texbox" size="25px" value="<?php echo kdauto("service",""); ?>" required="required" readonly >
<input name="status" type="hidden" value="PENDING">
			Tanggal
                    <input  type="date" name="tgl"  value='<?php echo $tanggal;?>' required="required">
	  Jam            <input  type="text" name="jam" value='<?php echo $jam;?>' required="required" ><br><br>
									
					Nama
                    <input class="form-control" type="text" name="nama"  required="required" >
					Lokasi Printer
				<div id="suggestSearch">
                    <input name="barang" size='72' type="text" id="dbTxt" alt="Search Criteria" onKeyUp="searchSuggest();"  onchange="new sendRequest(this.value)"  autocomplete="off"/>
                    <div  id="layer1" onclick="new permintaan(this.value)"  class="isi_tabelll" >

                    </div>
                </div>
                                      ID Printer 
                                            <input class="form-control" type="text" name="ippc" id='id_perangkat' readonly >
                                    
                                  
											
<div class="form-group">
                                           
Bagian
 <input class="form-control" type="text" name="bagian" id='bagian' readonly >
Divisi
 <input class="form-control" type="text" name="devisi" id='devisi' readonly >
                                    
                                        </div>	
	
Perangkat 
<input type="text" name="perangkat" id="perangkat" class="form-control" size="25px" readonly  >
 Permasalahan 
 <textarea cols="45" rows="7" name="permasalahan" class="form-control" id="permasalahan" size="15px" placeholder="" required="required"></textarea>
 Diterima Oleh IT 
 <input type="text" name="it" id="it" class="form-control" size="25px"  required="required" >

                                       
                                
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
                                            <h4 class="modal-title" id="H4">Reparasi Teknisi Dalam </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanservicedalamprinter.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" id="nomorganti"  class="texbox" size="25px"  required="required" readonly >

			Tanggal
                    <input  type="date" name="tgl2"  value='<?php echo $tanggal;?>' required="required">
	  Jam            <input  type="text" name="jam2" value='<?php echo $jam;?>' required="required" ><br><br>
									

Teknisi 
<input type="text" name="teknisi" id="teknisi" class="form-control" size="25px" placeholder="" required="required"  >
 Tindakan
 <textarea cols="45" rows="7" name="tindakan" class="form-control" id="tindakan" size="15px" placeholder="" required="required"></textarea>

Keterangan
 <textarea cols="45" rows="7" name="keterangan" class="form-control" id="keterangan" size="15px" placeholder="" ></textarea>

                                       
                                
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
                        <div class="modal fade" id="newReggggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4">Dikirim ke Teknisi Luar </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanserviceluarprinter.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" id="nomoroke"  class="texbox" size="25px"  required="required" readonly >

			Tanggal
                    <input  type="date" name="tgl2"  value='<?php echo $tanggal;?>' required="required">
	  Jam            <input  type="text" name="jam2" value='<?php echo $jam;?>' required="required" ><br><br>
									

Dikirim Ke 
<input type="text" name="luar" id="luar" class="form-control" size="25px"  required="required"  >
 
                                       
                                
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
					
					
					
					
					
				