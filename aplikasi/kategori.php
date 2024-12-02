<?include('config.php');?>  
<?
// function kdauto($tabel, $inisial){
// 	$struktur	= mysql_query("SELECT * FROM $tabel");
// 	$field		= mysql_field_name($struktur,0);
// 	$panjang	= mysql_field_len($struktur,0);

//  	$qry	= mysql_query("SELECT max(".$field.") FROM ".$tabel);
//  	$row	= mysql_fetch_array($qry); 
//  	if ($row[0]=="") {
//  		$angka=0;
// 	}
//  	else {
//  		$angka		= substr($row[0], strlen($inisial));
//  	}
	
//  	$angka++;
//  	$angka	=strval($angka); 
//  	$tmp	="";
//  	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
// 		$tmp=$tmp."0";	
// 	}
//  	return $inisial.$tmp.$angka;
// }?>

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

//     return $inisial . str_pad($angka, 5, "0", STR_PAD_LEFT); // Misalnya SUPP0001
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
<script language="javascript">
function createRequestObject() {
var ajax;
if (navigator.appName == 'Microsoft Internet Explorer') {
ajax= new ActiveXObject('Msxml2.XMLHTTP');} 
else {
ajax = new XMLHttpRequest();}
return ajax;}

var http = createRequestObject();
function sendRequest(idkategori){
if(idkategori==""){
alert("Anda belum memilih kode kategori !");}
else{   
http.open('GET', 'aplikasi/filterkategori.php?idkategori=' + encodeURIComponent(idkategori) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('idkategori').value = string[0];  
document.getElementById('kategori').value = string[1];
                                       
document.getElementById('jumlah').value="";
document.getElementById('jumlah').focus();

}}

var mywin; 
function popup(idkategori){
	if(idkategori==""){
alert("Anda kategori");}
else{   
mywin=window.open("manager/lap_jumkat.php?idkategori=" + idkategori ,"_blank",	"toolbar=yes,location=yes,menubar=yes,copyhistory=yes,directories=no,status=no,resizable=no,width=500, height=400"); mywin.moveTo(100,100);}
}



</script>
            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Data Kategori</h2>



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
                                            <th>ID Kategori</th>
                                            <th>Kategori</th>
											 <th>Jml/Ketegori</th>
											 <th>Detail</th>
											 <th>Edit</th>
                                          
											
											<th>Hapus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                        <?php 
                                            //$sql = $mysql->query("SELECT * FROM tkategori");

                                            // Periksa apakah ada hasil
                                            // if ($sql->num_rows > 0) {
                                            // while ($data = $sql->fetch_assoc()) {
                                            //     $idkategori=$data['idkategori'];
                                            //     $kategori=$data['kategori'];

                                            //     $tt = $mysql->query("SELECT sum(stock)as jumlahh FROM  tbarang WHERE idkategori ='$idkategori' ");

                                            //     while($datatt = $tt->fetch_assoc()){
                                            //         $jumlahh=$datatt['jumlahh'];
                                            //         }
                                            

                                                    $query_kategori = "SELECT * FROM tkategori";
                                                    $stmt_kategori = sqlsrv_query($conn, $query_kategori);
                                                    
                                                    // Periksa apakah query berhasil
                                                    if ($stmt_kategori === false) {
                                                        die(print_r(sqlsrv_errors(), true));
                                                    }
                                                    
                                                    // Periksa apakah ada hasil
                                                    if (sqlsrv_has_rows($stmt_kategori)) {
                                                        while ($data = sqlsrv_fetch_array($stmt_kategori, SQLSRV_FETCH_ASSOC)) {
                                                            $idkategori = $data['idkategori'];
                                                            $kategori = $data['kategori'];
                                                    
                                                            // Query untuk menghitung jumlah stok berdasarkan kategori
                                                            $query_stock = "SELECT SUM(stock) AS jumlahh FROM tbarang WHERE idkategori = ?";
                                                            $params_stock = array($idkategori);
                                                            $stmt_stock = sqlsrv_query($conn, $query_stock, $params_stock);
                                                    
                                                            if ($stmt_stock === false) {
                                                                die(print_r(sqlsrv_errors(), true));
                                                            }
                                                    
                                                            while ($datatt = sqlsrv_fetch_array($stmt_stock, SQLSRV_FETCH_ASSOC)) {
                                                                $jumlahh = $datatt['jumlahh'];
                                                            }
                                                    
                                                            // Bebaskan resource statement untuk `stmt_stock`
                                                            sqlsrv_free_stmt($stmt_stock);       

                                        ?>
				
                                        <tr class="gradeC">
                                            <td><?php echo $idkategori ?></td>
                                            <td><?php echo $kategori ?></td>
											    <td><?php echo $jumlahh ?></td>
												 <td align="center">
				<button class="btn btn-primary" value="<?php echo $idkategori; ?>" onclick="popup(this.value)" name='tombol'>
                                Detail
                            </button>
		</td>
                                           <td class="center">
											
											
										
											 <button type="submit" class="btn btn-primary" value='<?php echo $idkategori; ?>' data-toggle="modal"  data-target="#newReggg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Edit
                            </button>
												
											</td>
                             
											  <td class="center"><form action="aplikasi/deletekategori.php" method="post" >
											<input type="hidden" name="idkategori" value=<?php echo $idkategori; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">X</button>
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
                                            <h4 class="modal-title" id="H4"> Tambah Kategori</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/simpankategori.php" method="post"  enctype="multipart/form-data" name="postform2">
                                 
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idkategori" value="<?php echo kdauto("tkategori",""); ?>" readonly>
                                    
                                        </div>
											
<div class="form-group">
                                           
                                            <input placeholder="Kategori" class="form-control" type="text" name="kategori"  >
                                    
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
                                            <h4 class="modal-title" id="H4">Edit Kategori</h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/updatekategori.php" method="post"  enctype="multipart/form-data" name="postform2">
                                 
   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idkategori" id="idkategori" readonly>
                                    
                                        </div>
											
<div class="form-group">
                                           
                                            <input placeholder="Kategori" class="form-control" type="text" name="kategori" id="kategori"  >
                                    
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
					
					
					