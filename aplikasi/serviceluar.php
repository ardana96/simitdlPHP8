<?php
include('config.php');
	
?>  
 <?php
 $jam = date("H:i");
?>
<?php
$tanggal = date("Y-m-d");
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

function send(nomor){
if(nomor==""){
alert("Anda belum memilih permasalahan  !");}
else{   
http.open('GET', 'aplikasi/filterservice.php?nomor=' + encodeURIComponent(nomor) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('nomoredit').value = string[0];  
document.getElementById('tgledit').value = string[1];
document.getElementById('nama').value = string[2];  
document.getElementById('bag').value = string[3]; 
document.getElementById('div').value = string[4];
document.getElementById('per').value = string[5]; 
document.getElementById('kasus').value = string[6];
document.getElementById('penerima').value = string[7]; 
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


                        <h2>Daftar Service Keluar</h2>



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
										 
										  <th>Tgl Keluar</th>
										 <th>Jam</th>
                                            <th>Nama</th>
                                            <th>IPPC</th>
                                            <th>Bagian</th>
											
											<th>Divisi</th>
											<th>Perangkat</th>
											<th>Permasalahan</th>
											<th>IT Penerima</th>
											<th>Ubah</th>
											<th>Pengerjaan</th>
										
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                $query = "SELECT * FROM service WHERE status = 'proses'";
                $stmt = sqlsrv_query($conn, $query);
                
                
                // Periksa apakah ada data yang ditemukan
                if (sqlsrv_has_rows($stmt)) {
                    while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                
				$tgl=$data['tgl'] ? $data['tgl']->format('Y-m-d') : '';
				$tgl2=$data['tgl2'] ? $data['tgl2']->format('Y-m-d') : '';
				$jam=$data['jam'];
				$nama=$data['nama'];
				$ippc=$data['ippc'];
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
							
										<td><?php echo $tgl2 ?></td>
									<td><?php echo $jam ?></td>
                                            <td><?php echo $nama ?></td>
                                            <td><?php echo $ippc?></td>
                                            <td><?php echo $bagian ?></td>
											
											<td><?php echo $divisi ?></td>
											<td><?php echo $perangkat ?></td>
											<td><?php echo $kasus ?></td>
											<td><?php echo $penerima ?></td>
											
											 <td class="center">
											 <!--<form action="user.php?menu=feditbarang" method="post" >
											<input type="hidden" name="idbarang" value=
											// />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Edit</button>
											</form>-->
											<button class="btn btn-primary" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReggg" onclick="new send(this.value)">
                                Edit 
                            </button>
											
											</td>
                            
											 <td class="center"><button class="btn btn-danger" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReg" onclick="new sendRequest(this.value)">
                               Selesai 
                            </button> </td>
							
											
											
                                            
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
                                            <h4 class="modal-title" id="H4">Reparasi Teknisi Dalam </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpanprosesservicekeluar.php" method="post"  enctype="multipart/form-data" name="postform2">
<input type="hidden" name="nomor" id="nomorganti"  class="texbox" size="25px"  required="required" readonly >

			Tanggal
                    <input  type="date" name="tgl3"  value='<?php echo $tanggal;?>' required="required">
	  Jam    <input  type="text" name="jam3" value='<?php echo $jam;?>' required="required" ><br><br>
									


 Tindakan
 <textarea cols="45" rows="7" name="tindakan2" class="form-control" id="tindakan" size="15px" placeholder="" required="required"></textarea>


                                       
                                
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
                                            <h4 class="modal-title" id="H4">Edit Service </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/updateservice.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="nomor" id="nomoredit"  readonly>
                                    
                                        </div>
									 Tanggal 
									   <div class="form-group">
                    <input  type="text" name="tgl2" id="tgledit"   required="required">
					    </div>
<div class="form-group">
Nama                                            
                                            <input class="form-control" type="text" name="nama" id="nama" >
                                    
                                        </div>
										 Bagian                                      
                                         <select class="form-control" name='bagian' id='bag' required='required'>
                                            <?php
                                            $query = "SELECT * FROM bagian ORDER BY bagian ASC";
                                            $stmt = sqlsrv_query($conn, $query);

                                            if ($stmt === false) {
                                                // Tangani kesalahan
                                                $errors = sqlsrv_errors();
                                                foreach ($errors as $error) {
                                                    echo "SQLSTATE: " . $error['SQLSTATE'] . "<br>";
                                                    echo "Kode Kesalahan: " . $error['code'] . "<br>";
                                                    echo "Pesan Kesalahan: " . $error['message'] . "<br>";
                                                }
                                            } else {
                                                while ($datas = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                    $idbagian = $datas['idbagian'];
                                                    $bagian = $datas['bagian'];
                                                    ?>
                                                    <option value="<?php echo htmlspecialchars($bagian); ?>"> <?php echo htmlspecialchars($bagian); ?> </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

		
                                           
    Divisi                                    
       <select class="form-control" name="divisi" id="div" required='required' >

 <option value="A">AMBASSADOR</option>
 <option value="E">EFRATA</option>
 <option value="G">GARMENT</option>
 <option value="M">MAS</option>
 <option value="T">TEXTILE</option>
  <option value="D">DIV.UMUM</option>
</select>

<div class="form-group">
Perangkat                                            
                                            <input class="form-control" type="text" name="perangkat" id="per" >
                                    
                                        </div>										
	
<div class="form-group">
Kasus                                        
                                            <input  placeholder="Alamat" class="form-control" type="text" name="kasus" id="kasus" >
                                    
                                        </div>	
<div class="form-group">
  Penerima                                    
                                            <input  placeholder="Telp" class="form-control" type="text" name="penerima" id="penerima">
                                    
                                        </div>	
                                       
                                
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-danger" name='tombol'>Update</button>
                                        </div>
										    </form>
                                    </div>
                                </div>
                            </div>
                    </div>
                        
              						
					
					
					
					
					