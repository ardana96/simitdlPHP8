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
// function kdauto($tabel, $inisial) {
//     global $mysql; // Pastikan koneksi tersedia
//     $struktur = $mysql->query("DESCRIBE $tabel");
//     $field = $struktur->fetch_assoc()['Field']; // Ambil kolom pertama

//     $qry = $mysql->query("SELECT MAX($field) AS maxKode FROM $tabel");
//     $row = $qry->fetch_assoc();

//     $angka = 0;
//     if (!empty($row['maxKode'])) {
//         $angka = (int) substr($row['maxKode'], strlen($inisial));
//     }
//     $angka++;

//     return $inisial . str_pad($angka, 4, "0", STR_PAD_LEFT); // Misalnya SUPP0001
// }


function kdauto($tabel, $inisial) {
    global $conn; // Pastikan koneksi sqlsrv tersedia

    // Ambil nama kolom pertama dari tabel
    $query_struktur = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = ?";
    $params_struktur = array($tabel);
    $stmt_struktur = sqlsrv_query($conn, $query_struktur, $params_struktur);

    if ($stmt_struktur === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $field = null;
    if ($row = sqlsrv_fetch_array($stmt_struktur, SQLSRV_FETCH_ASSOC)) {
        $field = $row['COLUMN_NAME']; // Ambil nama kolom pertama
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

    // Menghasilkan kode baru
    return $inisial . str_pad($angka, 5, "0", STR_PAD_LEFT); // Misalnya SUPP0001
}


// Contoh penggunaan fungsi

// Di dalam form HTML
?>

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Data Supplier</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                       <!--<a href="user.php?menu=tasupplier"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Tambah Supplier</button></a>
                       -->

                            <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah 
                            </button>
                             
                    


					   </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Supplier</th>
                                            <th>Nama </th>
                                            <th>Alamat</th>
                                            <th>Telp</th>
											<th>Edit</th>
											<th>Hapus</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php 
				                        // Jalankan query
                                        // $sql = $mysql->query("SELECT * FROM tsupplier");

                                        // // Periksa apakah ada hasil
                                        // if ($sql->num_rows > 0) {
                                        //     while ($data = $sql->fetch_assoc()) {
                                        //         $idsupp = $data['idsupp'];
                                        //         $namasupp = $data['namasupp'];
                                        //         $alamatsupp = $data['alamatsupp'];
                                        //         $telpsupp = $data['telpsupp'];


                                        $query = "SELECT * FROM tsupplier";
                                        $stmt = sqlsrv_query($conn, $query);
                                        
                                        // Periksa apakah query berhasil
                                        if ($stmt === false) {
                                            die(print_r(sqlsrv_errors(), true));
                                        }
                                        
                                        // Periksa apakah ada hasil
                                        if (sqlsrv_has_rows($stmt)) {
                                            while ($data = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                $idsupp = $data['idsupp'];
                                                $namasupp = $data['namasupp'];
                                                $alamatsupp = $data['alamatsupp'];
                                                $telpsupp = $data['telpsupp'];        
                                        ?>
				
                                        <tr class="gradeC">
                                            <td><?php echo $idsupp ?></td>
                                            <td><?php echo $namasupp ?></td>
                                            <td><?php echo $alamatsupp ?></td>
                                            <td class="center"><?php echo $telpsupp ?></td>
											 <td class="center">
											
											
										
											 <button type="submit" class="btn btn-primary" value='<?php echo $idsupp; ?>' data-toggle="modal"  data-target="#newReggg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Edit
                            </button>
												
											</td>
											  <td class="center"><form action="aplikasi/deletesupplier.php" method="post" >
											<input type="hidden" name="idsupp" value=<?php echo $idsupp; ?> />
										
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
                                            <h4 class="modal-title" id="H4"> Tambah Supplier</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpansupplier.php" method="post"  enctype="multipart/form-data" name="postform2">
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


  
                       
					                                <div class="col-lg-12">
                        <div class="modal fade" id="newReggg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

						
								<div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4">Edit Supplier  </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/updatesupplier.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idsupp" id="kodesupp"  readonly>
                                    
                                        </div>
									  <div class="form-group">
                                           Nama Supplier
                                            <input placeholder="Nama Supplier" class="form-control" type="text" name="namasupp" id="namasupp"  >
                                    
                                        </div>	
	
<div class="form-group">
Alamat supplier                                            
                                            <input  placeholder="Alamat" class="form-control" type="text" name="alamatsupp" id="alamatsupp" >
                                    
                                        </div>	
<div class="form-group">
    Telp Supplier                                     
                                            <input  placeholder="Telp" class="form-control" type="text" name="telpsupp" id="telpsupp">
                                    
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
                        
              				