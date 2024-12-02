<?include('config.php');
	date_default_timezone_set("Asia/Jakarta");
$tglini=date("d-m-20y");
$jamini=date("H:i");
?>  
 <?$jam = date("H:i");
?>
<?$tanggal = date("d-m-20y ");
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

document.getElementById('noedit').value = encodeURIComponent(nomor);

 
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


                        <h2>Daftar Job Software</h2>



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
										 <th>Tanggal</th>
										 <th>Jam</th>
                                            <th>Nama</th>
                                            <th>Bagian</th>
											<th>Divisi</th>
											<th>IT Penerima</th>
											<th>Permasalahan</th>
											<th>Tindakan</th>
											<th>Status</th>
											<th>Tidak Cetak</th>
											<th>Edit</th>
											<th>Hapus</th>
								
										
										
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$nou=1;
									   $sql = mysql_query("SELECT * FROM software order by nomor desc ");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$tgl=$data['tgl'];
				$jam=$data['jam'];
				$nama=$data['nama'];
				$bagian=$data['bagian'];
				$divisi=$data['divisi'];
				$kasus=$data['kasus'];
					$nomor=$data['nomor'];
				$penerima=$data['penerima'];
					$status=$data['status'];
						$tindakan=$data['tindakan'];
						$tgl2=$data['tgl2'];
						$jam2=$data['jam2'];
												$cetak=$data['cetak'];


						
				
				$sqlll = mysql_query("SELECT * FROM divisi where kd='$divisi' ");
			while($dataa = mysql_fetch_array($sqlll)){
			$namadivisi=$dataa['namadivisi'];}
				?>
				
                                        <tr class="gradeC">
									<td><? echo $nou++ ?></td>	
								
									<td><? echo $tgl ?></td>
									<td><? echo $jam ?></td>
                                            <td><? echo $nama ?></td>
                                            <td><? echo $bagian?></td>
                                            <td><? echo $namadivisi ?></td>
											
											<td><? echo $penerima ?></td>
											<td><? echo $kasus ?></td>
											<td><? echo $tindakan ?></td>
											<td>
											<? if($status=='Selesai'){
											echo $status.' , '.$penerima.' , '.$tgl2; 
											}else{?><button type="submit" class="btn btn-info" value='<?php echo $nomor; ?>' data-toggle="modal"  data-target="#newReg" name='tomboledit'  onclick="new sendRequest(this.value)">
                                Diselesaikan
											</button><?}?>
											</td>
											<td>
<form name="testing" method="POST" action="aplikasi/updateceksoft.php">
<?


echo "<table><tr>";
    if ($data['cetak'] == 'T')
{ 

echo "<td><input type='hidden' name='nomorr' value='".$data['nomor']."' id='".$data['nomor']."'/>
<input type='checkbox' name='cek' value='' id='".$data['cetak']."' checked='checked' onclick='this.form.submit();' />";
}
else
{ 

echo "<td><input type='hidden' name='nomorr' value='".$data['nomor']."' id='".$data['nomor']."' />
<input type='checkbox' name='cek' value='T' id='".$data['nomor']."' onclick='this.form.submit();' />";
}
echo "</tr></table>";


?>
</form>	
											 </td>
										  <td class="center"><a href="user.php?menu=editsoftware&nomor=<? echo $nomor ?>" class="btn text-muted text-center btn-primary">Edit</a></td>
	  <td class="center"><form action="aplikasi/deletesoftware.php" method="post" >
											<input type="hidden" name="nomor" value=<?php echo $nomor; ?> />
										
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
           
		   
		   
		   
		   
		   
		   
		   
		   <div class="col-lg-12">
                        <div class="modal fade" id="newReg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="H4"> Selesai Proses Support</h4>
                                        </div>
                                        <div class="modal-body">
                                             <form action="aplikasi/simpanselsoft.php" method="post"  enctype="multipart/form-data" name="postform2">
				  		  <div class="form-group">
                                   
     <input type="hidden" name="nomor" id="noedit" >   

  
				 </div>	
				  <div class="form-group">
<b>Tanggal </b> &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
<b>Jam</b><br>
                                            
     <input type="text" name="tgl2" value=<?echo $tglini;?> >   
	  &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

	  <input type="text" name="jam2" value=<?echo $jamini;?>  >               
			               
				 </div>	
<div class="form-group">
<b>Kategori</b>                                  
       <select class="form-control" name="svc_kat" >
 <option  ></option>
 <option value="LOW">LOW</option>
 <option value="NORMAL">NORMAL</option>
 <option value="HIGH">HIGH</option>
 <option value="URGENT">URGENT</option>
</select>	
<b>Tindakan</b>		
                                           
                                         <textarea cols="45" rows="5" name="tindakan" class="form-control" id="tindakan" placeholder="Tindakan Dalam Supporting" size="15px" placeholder="" ></textarea>                              
      
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

					

					