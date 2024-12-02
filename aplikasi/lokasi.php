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
                                <?
                                $sql = mysql_query("SELECT * FROM lokasi");
								if(mysql_num_rows($sql) > 0){
								while($data = mysql_fetch_array($sql)){
								$lokasi_id=$data['lokasi_id'];
								$lokasi_nama=$data['lokasi_nama'];
								?>

	                            <tr class="gradeC">
	                                <td><? echo $lokasi_id ?></td>
	                                <td><? echo $lokasi_nama ?></td>
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
                				<?}}?>                      
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
                            	<input class="form-control" type="text" name="lokasi_id" value="<? echo kdauto("lokasi","LK"); ?>" readonly>  
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
                       <form action="aplikasi/updatesubbagian.php" method="post"  enctype="multipart/form-data" name="postform2">
                                    
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