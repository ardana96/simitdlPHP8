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
<?
function kdauto($tabel, $inisial){
	$struktur	= mysql_query("SELECT * FROM $tabel");
	$field		= mysql_field_name($struktur,0);
	$panjang	= mysql_field_len($struktur,0);

 	$qry	= mysql_query("SELECT max(".$field.") FROM ".$tabel);
 	$row	= mysql_fetch_array($qry); 
 	if ($row[0]=="") {
 		$angka=0;
	}
 	else {
 		$angka		= substr($row[0], strlen($inisial));
 	}
	
 	$angka++;
 	$angka	=strval($angka); 
 	$tmp	="";
 	for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
		$tmp=$tmp."0";	
	}
 	return $inisial.$tmp.$angka;
}?>

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Daftar Booking</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                       <!--<a href="user.php?menu=tasupplier"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Tambah Supplier</button></a>
                       -->

                           <div class="panel-heading">
            
                          	<a href="pemakai.php?menu=tabooking" class="btn text-muted text-center btn-primary">Tambah</a>
						</div>
                             
                    


					   </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang </th>
                                            <th>Tanggal </th>
                                            <th>Keperluan</th>
                                            
											
											<th>Hapus</th>
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM boking");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$id=$data['id'];
				$idbarang=$data['idbarang'];
				$tglboking=$data['tgl'];
				$t=substr($tglboking,-2,2);
							$b=substr($tglboking,-5,2);
							$th=substr($tglboking,0,4);
					$tglsek=$t.'-'.$b.'-'.$th;
				$keperluan=$data['keperluan'];
				$bb = mysql_query("SELECT namabarang FROM tbarang where idbarang='$idbarang' ");
					while($databb = mysql_fetch_array($bb)){
					$namabarang=$databb['namabarang'];}
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $namabarang ?></td>
                                            <td><? echo $tglsek ?></td>
                                            <td><? echo $keperluan ?></td>
                                            
										
											  <td class="center"><form action="aplikasi/deletebooking.php" method="post" >
											<input type="hidden" name="id" value=<?php echo $id; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>
                                            
                                        </tr>
                <?}}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
  
  