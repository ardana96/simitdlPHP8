<?php
include('config.php');
	
?>  
 <?php
 $jam = date("H:i");
?>
<?php
$tanggal = date("Y-m-d ");
?>
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




</script>

<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(idsupp){
if(idsupp==""){
alert("Anda belum memilih kode Data !");}
else{   
http.open('GET', 'aplikasi/filterriwayatsemua.php?id_user=' + encodeURIComponent(idsupp) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('tgl').value = string[0];  
document.getElementById('tgl2').value = string[1];
document.getElementById('tgl3').value = string[2];
document.getElementById('nomor').value = string[3]; 
                                        


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


                        <h2>Daftar Riwayat Kerusakan Printer & Laptop </h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                    
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
									 <th>Nomor</th>
										 <th>Tgl</th>
									
                                            <th>Nama</th>
											<th>IP PC</th>
                                            <th>No Printer</th>
                                            <th>Bagian</th>
											
											<th>Divisi</th>
											<th>Perangkat</th>
											<th>Permasalahan</th>
											<th>Tindakan</th>
											<th>Status</th>
											<th>Keterangan</th>
											<th>Edit</th>
										
										
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php 
                 $query = "SELECT * FROM service WHERE status = 'selesai' ORDER BY nomor DESC";
                 $stmt = sqlsrv_query($conn, $query);
                 
                 if ($stmt === false) {
                     // Tangani kesalahan jika query gagal
                     $errors = sqlsrv_errors();
                     foreach ($errors as $error) {
                         echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                         echo "Kode Kesalahan: " . $error['code'] . "<br>";
                         echo "Pesan Kesalahan: " . $error['message'] . "<br>";
                     }
                 } else {
                     // Jika ada data, iterasi hasil query
                     while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$tgl=$data['tgl'] ? $data['tgl']->format('Y-m-d') : '';
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
					$status=$data['status'];
					$noprinter=$data['noprinter'];
						$teknisi=$data['teknisi'];
						$tindakan=$data['tindakan'];
						$tgl2=$data['tgl2'] ? $data['tgl2']->format('Y-m-d') : '';
						$luar=$data['luar'];
						$tgl3=$data['tgl3'] ? $data['tgl3']->format('Y-m-d') : '';
							$keterangan=$data['keterangan'];
						$nomor=$data['nomor'];
						$statup=$data['statup'];
				
			// 	$sqlll = mysql_query("SELECT * FROM bulan where id_bulan='$bulan' ");
			// while($dataa = mysql_fetch_array($sqlll)){
			// $namabulan=$dataa['bulan'];}
				?>
				
                                        <tr class="gradeC">
									<td><?php echo $nomor ?></td>	
								
									<td><?php echo $tgl ?></td>
                                            <td><?php echo $nama ?></td>
											<td><?php echo $ippc ?></td>
                                            <td><?php echo $noprinter?></td>
                                            <td><?php echo $bagian ?></td>
											
											<td><?php echo $divisi ?></td>
											<td><?php echo $perangkat ?></td>
											<td><?php echo $kasus ?></td>
												<td><?php echo $tindakan ?></td>
											<td><?php echo $status; ?>,<?php echo $teknisi; ?>,<?php echo $tgl2; ?>,<?php echo $luar; ?>,<?php echo $tgl3; ?></td>
											<td><?php echo $keterangan ?></td>
                            
											 <td>
											
											
										
											 <button type="submit" class="btn btn-primary btn-line" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReggg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Edit
                            </button>
												
											</td> 
											
											
                                            
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
                                            <h4 class="modal-title" id="H4"> Tambah Account</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanaccount.php" method="post"  enctype="multipart/form-data" name="postform2">
                                     
									  
										<div class="form-group">
                                      
                                            <input placeholder="Nama User" class="form-control" type="text" name="user" required='required' >
                                    
                                        </div>	
	
<div class="form-group">

                                            <input  placeholder="Isikan Password" class="form-control" type="password" name="password" required='required'>
                                    
                                        </div>	

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-line" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger btn-line" name='tombol'>Simpan</button>
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
                                            <h4 class="modal-title" id="H4">Edit Tanggal Service</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/updateriwayatservice.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         <div class="form-group">
                                         
                                            <input class="form-control" type="hidden" name="nomor" id="nomor"  readonly>
                                    
                                        </div>
									
										<div class="form-group">
                                      Tanggal Masuk Service
                                            <input placeholder="Nama User" class="form-control" type="date" name="tgl" id="tgl" required='required' >
                                    
                                        </div>	
											<div class="form-group">
                                      Tanggal  Selesai Service Dalam
                                            <input placeholder="Nama User" class="form-control" type="date" name="tgl2" id="tgl2" required='required' >
                                    
                                        </div>	
										
										<div class="form-group">
                                      Tanggal  Selesai Service Luar
                                            <input placeholder="Nama User" class="form-control" type="date" name="tgl3" id="tgl3"  >
                                    
                                        </div>	
	
	


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success btn-line" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger btn-line" name='tombol'>Update</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                        
		   

					

					