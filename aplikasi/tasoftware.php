<?php
include('config.php');
date_default_timezone_set("Asia/Jakarta");
$tglini=date("d-m-20y");
$jamini=date("H:i");

?>
 <script type="text/javascript">

function dontEnter(evt) { 
var evt = (evt) ? evt : ((event) ? event : null); 
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
} 
document.onkeypress = dontEnter;

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
                        <h4>Input Permintaan Support Software</h4>
						<hr>
                    </div>
                </div>
			   <div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-12">
               <div class="panel panel-danger">
			   <?php if(isset($_GET['stt'])){
$stt=$_GET['stt'];
echo "".$stt."";?><img src="img/centang.png" style="width: 50px; height: 30px; "><?}
?> 
                        <div class="panel-heading">
                   
                        </div>
                        <div class="panel-body">
						
                            <form action="aplikasi/simpansoftware.php" method="post"  enctype="multipart/form-data" name="postform2">

										 <div class="form-group">
<b>Tanggal Pengerjaan</b> &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 


<b>Jam</b><br>
                                            
                                             <input type="text" name="tgl" value=<?echo $tglini;?>  required="required" >  
	  &nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

	  <input type="text" name="jam" value=<?echo $jamini;?> required="required">    <br><br>           
<b>Tanggal Request</b> 

&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp

 
<b>Tanggal Approve</b> <br>
<input type="text" name="tglRequest" value=<?echo $tglini;?>  required="required" >       
&nbsp &nbsp &nbsp &nbsp 
&nbsp &nbsp &nbsp &nbsp
&nbsp &nbsp &nbsp &nbsp 

<input type="text" name="tglApprove" value=<?echo $tglini;?>  required="required" >  <br>    
				 </div>	

						<div class="form-group">
         
                                            <input  placeholder="Nama user" class="form-control" type="text" name="nama"  required="required" >
                                    
                                        </div>						
	
   <div class="form-group">
     
      <select class="form-control" name='bagian' required="required">	 <option value="">.: Nama Bagian :. </option>
            
			<?	$s1 = mysql_query("SELECT * FROM bagian order by bagian asc");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$id_bagian=$datas1['id_bagian'];
				$bagian=$datas1['bagian'];
				?>
			 <option value="<? echo $bagian; ?>"> <? echo $bagian; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
			
	   <div class="form-group">
     
      <select class="form-control" name='divisi'  required="required">	 <option value="">.: Nama Divisi :. </option>
            
			<?	$s1 = mysql_query("SELECT * FROM divisi order by namadivisi asc");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$kd=$datas1['kd'];
				$namadivisi=$datas1['namadivisi'];
				?>
			 <option value="<? echo $kd; ?>"> <? echo $namadivisi; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
     
	   <div class="form-group">
     
      <select class="form-control" name='penerima' required="required">	 <option value="">.: IT Penerima :. </option>
            
			<?	$s1 = mysql_query("SELECT * FROM it order by username asc");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$username=$datas1['username'];
				$nama=$datas1['nama'];
				?>
			 <option value="<? echo $nama; ?>"> <? echo $username; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
	<div class="form-group">
                                           
                                         <textarea cols="45" rows="5" name="kasus" class="form-control" id="kasus" placeholder="Isikan Diskripsi Permintaan Support " size="15px" placeholder="" required="required"></textarea>                              
      
                                        </div>

 <button  name="tombol_new" class="btn text-muted text-center btn-info" type="reset">New</button>

									
                                    <button  name="tombol_simpan" class="btn text-muted text-center btn-primary" type="Submit">Simpan</button>
									
           
			   <button class="btn btn-danger" data-toggle="modal"  data-target="#newReg">
                                Selesai Dikerjakan
                            </button>
			 </td>
				
                                  
									<br>
									
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
                                            <button type="Submit" class="btn btn-danger" name='tombol_selesai'>Simpan</button>
                                        </div>
				
										
										
										  </form>
										
										
										
										
                                    </div>
                                </div>
                            </div>
                    </div>
<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>	