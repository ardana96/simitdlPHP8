<?include('config.php');?>
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(lokasi_id){
if(lokasi_id==""){
alert("Anda belum memilih kode Bagian !");}
else{   
http.open('GET', 'aplikasi/filterlokasi.php?lokasi_id=' + encodeURIComponent(lokasi_id) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('lokasi_id').value = string[0];  
document.getElementById('lokasi_nama').value = string[1];

                                       
// document.getElementById('jumlah').value="";
// document.getElementById('jumlah').focus();

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
            <h2> Data Lokasi </h2>
        </div>
    </div>

    <hr />

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
  					<button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah 
                    </button>                       
				</div>
                <div class="panel-body">
                    <div class="table-responsive" style='overflow: scroll;'>
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>ID Lokasi</th>
                                    <th>Lokasi</th>
									<th>Edit</th>
									<th>Hapus</th>
									
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM lokasi";
                                $stmt = sqlsrv_query($conn, $query);
                                
                                // Periksa apakah query berhasil
                                if ($stmt === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }
                                
                                // Periksa apakah ada hasil
                                if (sqlsrv_has_rows($stmt)) {
                                    while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                    $lokasi_id=$data['lokasi_id'];
                                    $lokasi_nama=$data['lokasi_nama'];
								?>

	                            <tr class="gradeC">
	                                <td><?php echo $lokasi_id ?></td>
	                                <td><?php echo $lokasi_nama ?></td>
									 <td class="center">
									 <button class="btn btn-primary" value='<?php echo $lokasi_id; ?>' data-toggle="modal"  data-target="#newReggg" onclick="new sendRequest(this.value)"> Edit </button>
									</td>
									<td class="center">
										<form action="aplikasi/deletelokasi.php" method="post" >
											<input type="hidden" name="lokasi_id" value=<?php echo $lokasi_id; ?> />
								
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
										</form> 
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
                        <h4 class="modal-title" id="H4"> Tambah Lokasi </h4>
                    </div>
                    
                    <div class="modal-body">
                       <form action="aplikasi/simpanlokasi.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
							<div class="form-group">         
                            	<input class="form-control" type="text" name="lokasi_id" value="<?php echo kdauto("lokasi","LK"); ?>" readonly>  
                            </div>
											
							<div class="form-group">             
                                <input placeholder="Lokasi" class="form-control" type="text" name="lokasi_nama" required="required" >       
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



    <div class="col-lg-12">
        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                	<div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="H4"> Edit Lokasi </h4>
                    </div>
                    
                    <div class="modal-body">
                       <form action="aplikasi/updatelokasi.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
   						<div class="form-group">
                           <input class="form-control" type="text" name="lokasi_id" id="lokasi_id"  readonly>           
                        </div>
											
						<div class="form-group">               
                            <input placeholder="Lokasi" class="form-control" type="text" name="lokasi_nama" id="lokasi_nama"  >
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
</div>                   