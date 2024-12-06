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
function sendRequest(idsupp){
if(idsupp==""){
alert("Anda belum memilih kode Supplier !");}
else{   
http.open('GET', 'aplikasi/filtersupplier.php?idsupp=' + encodeURIComponent(idsupp) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('namasupp').value = string[0];  
document.getElementById('alamatsupp').value = string[1];
document.getElementById('telpsupp').value = string[2]; 
document.getElementById('kodesupp').value = string[3];                                        
document.getElementById('jumlah').value="";
document.getElementById('jumlah').focus();

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


                        <h2> Data Catridge</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                       <!--<a href="user.php?menu=tasupplier"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Tambah Supplier</button></a>
                       -->

                            <!-- <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah 
                            </button> -->
                             
                    


					   </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Nomor Barang</th>
                                            <th>Status</th>
											<th>Edit</th>
											<th>Hapus</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php
                                // $sql = mysql_query("SELECT * FROM tbarang a, tvalidasi b where  (a.idbarang = b.IdBarang)");
                                // if(mysql_num_rows($sql) > 0){
                                // while($data = mysql_fetch_array($sql)){


                                $query = "SELECT * FROM tbarang a, tvalidasi b where  (a.idbarang = b.IdBarang)";
                                    $stmt = sqlsrv_query($conn, $query);
                                    
                                    // Periksa apakah query berhasil
                                    if ($stmt === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }
                                    
                                    // Periksa apakah ada hasil
                                    if (sqlsrv_has_rows($stmt)) {
                                        while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $IdBarang=$data['IdBarang'];
                                $NamaBarang=$data['namabarang'];
                                $NomorBarang=$data['NomorBarang'];
                                $IsBack = $data['IsBack'];
                                $Id=$data['Id'];
				?>
				
                                        <tr class="gradeC">
                                            <td><?php echo $IdBarang ?></td>
                                            <td><?php echo $NamaBarang ?></td>
                                            <td><?php echo $NomorBarang ?></td>
                                            <td><?php 
                                                if($IsBack == 0){ ?>
                                                    <button  name="tombol" class="btn text-muted text-center btn-danger">Tidak Ada</button>
                                                    <!-- echo "Tidak Ada"; -->
                                              <?php  }else{ ?>
                                                    <button  name="tombol" class="btn text-muted text-center btn-success">Ada</button>
                                                    <!-- echo "Ada"; -->
                                               <?php } ?></td>
                                            
											 <td class="center">
											
											
										
										<!-- 	 <button type="submit" class="btn btn-primary" value='<?php echo $idsupp; ?>' data-toggle="modal"  data-target="#newReggg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Edit
                            </button>
 -->

                             <button type="submit" class="btn btn-primary" value='<?php echo $idsupp; ?>' data-toggle="modal"  data-target="#newReggg<?php echo $Id; ?>" name='tomboledit'  >
                                Edit
                            </button>
												
											</td>
											  <td class="center"><form action="aplikasi/deletecatridge.php" method="post" >
											<input type="hidden" name="Id" value=<?php echo $Id; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>
                                            
                                        </tr>

                          
                            <div class="modal fade" id="newReggg<?php echo $Id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                        
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4">Edit Catridge  </h4>
                                        </div>
                                        <div class="modal-body">
                                           <form action="aplikasi/updatecatridge.php" method="post"  enctype="multipart/form-data" name="postform2">
                                             
                                                <?php
                                                $id = $data['id']; 
                                                $query_edit = "SELECT * FROM tvalidasi WHERE Id = ?";

                                                // Siapkan parameter
                                                $params = array($Id);

                                                // Eksekusi query
                                                $stmt = sqlsrv_query($conn, $query_edit, $params);

                                          
                                                // Ambil data menggunakan sqlsrv_fetch_array
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                ?>
                                                 <div class="form-group">
                                                 
                                                    <input class="form-control" type="text" name="Id" id="Id"  readonly value="<?php echo $row['Id']; ?>">
                                            
                                                </div>
                                              <div class="form-group">
                                                   Id Barang
                                                    <input placeholder="Id Barang" class="form-control" type="text" name="IdBarang" id="IdBarang"
                                                    value="<?php echo $row['IdBarang']; ?>"  >
                                            
                                                </div>  
            
                                                <div class="form-group">
                                                    Nomor Barang                                           
                                                    <input  placeholder="Nomor Barang" class="form-control" type="text" name="NomorBarang" id="NomorBarang" value="<?php echo $row['NomorBarang']; ?>">
                                            
                                                </div>  

                                                <?php if($row['IsBack'] == 1) {?>

                                                <input type="radio" id="html" name="IsBack" value="1" checked="checked">
                                                <label for="html">Ada</label>
                                                <input type="radio" id="css" name="IsBack" value="0">
                                                <label for="css">Tidak ada </label>

                                                <?php }else {?>

                                                <input type="radio" id="html" name="IsBack" value="1" >
                                                <label for="html">Ada</label>
                                                <input type="radio" id="css" name="IsBack" value="0" checked="checked">
                                                <label for="css">Tidak ada </label>
                                                <?php }?>

                                               <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="Submit" class="btn btn-danger" name='tombol'>Update</button>
                                                </div>

                                            <?php 
                                            }
                                            ?>
                                        
                                        </div>
                                        
                                        </form>
                                    </div>
                                </div>
                            </div>
                        
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
                                            <h4 class="modal-title" id="H4"> Tambah Catridge</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpancatridge.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         
									   <div class="form-group">
                                           Id Barang
                                            <input placeholder="IdBarang" class="form-control" type="text" name="IdBarang"  >
                                    
                                        </div>	
	
                                        <div class="form-group">
                                            Nomor Barang                                            
                                            <input  placeholder="Alamat" class="form-control" type="text" name="NomorBarang" >
                                    
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


  
                       
					                               
                        
              				