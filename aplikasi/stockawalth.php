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
function sendRequest(idbarang){
if(idbarang==""){
alert("Anda belum memilih ID barang !");}
else{   
http.open('GET', 'aplikasi/filterstockth.php?idbarang=' + (idbarang) , true);
http.onreadystatechange = handleResponse;
http.send(null);}}

function handleResponse(){
if(http.readyState == 4){
var string = http.responseText.split('&&&');
document.getElementById('idbarang').value = string[0];  
document.getElementById('blnth').value = string[1];
document.getElementById('stocka').value = string[2]; 


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


                        <h2> Data Stock Awal TH </h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                       <!--<a href="user.php?menu=tasupplier"><button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Tambah Supplier</button></a>
                       

                            <button class="btn btn-primary" data-toggle="modal"  data-target="#newReg">
                                Tambah 
                            </button>
                       -->      
                    


					   </div>
                        <div class="panel-body">
                            <div class="table-responsive" style='overflow: scroll;'>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>ID Barang</th>
                                            <th>Tahun</th>
                                            <th>Stock</th>
											<th>Edit</th>
											
											
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM stockth,tbarang where stockth.idbarang=tbarang.idbarang ");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$idbarang=$data['idbarang'];
				$namabarang=$data['namabarang'];
				$blnth=$data['blnth'];
				$stock=$data['stocka'];
				$kataku=$idbarang.'&blnth='.$blnth;
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $namabarang ?></td>
                                            <td><? echo $idbarang ?></td>
                                            <td><? echo $blnth ?></td>
                                            <td class="center"><? echo $stock ?></td>
											 <td class="center">
											
											
										
											 <button type="submit" class="btn btn-primary" value='<?php echo $kataku; ?>' data-toggle="modal"  data-target="#newReggg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Edit
                            </button>
												
											</td>
											  <!--<td class="center"><form action="aplikasi/deletesupplier.php" method="post" >
											<input type="hidden" name="idsupp" value=<?php echo $idsupp; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-danger" type="submit" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')">X</button>
											</form> </td>
                                            -->
                                        </tr>
                <?}}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
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
                                            <h4 class="modal-title" id="H4">Edit Stock  </h4>
                                        </div>
                                        <div class="modal-body">
                                       <form action="aplikasi/updatestockth.php" method="post"  enctype="multipart/form-data" name="postform2">
                                         <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="idbarang" id="idbarang"  readonly>
                                    
                                        </div>
										   <div class="form-group">
                                         
                                            <input class="form-control" type="text" name="blnth" id="blnth"  readonly>
                                    
                                        </div>
									  <div class="form-group">
                                           Stock
                                            <input  class="form-control" type="text" name="stocka" id="stocka"  >
                                    
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
                        
              				