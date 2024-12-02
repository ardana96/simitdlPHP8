<?php
include('config.php');

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
                        <h4>PERAKITAN KOMPUTER</h4>
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
						
                            <form action="aplikasi/simpanperakitan.php" method="post"  enctype="multipart/form-data" name="postform2">
   
									
		
   <div class="form-group">
   <b>Nama Komputer</b>                                              
                                            <input class="form-control" type="text" name="idpc" value="<? echo kdauto("tpc","PC"); ?>" readonly  >
                                    
                                        </div>
										   <div class="form-group">
                                          
                                            <input class="form-control" type="hidden" name="nofaktur" value="<? echo kdauto("tpengambilan",""); ?>" readonly  >
                                    
                                        </div>
										 <div class="form-group">
<b>Tanggal Perakitan </b><br>
                                            
                                          <input required='required' type="text" id="from" name="tglrakit" class="isi_tabel" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;"/><a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.postform2.from);return false;">
	  <img name="popcal" align="absmiddle" style="border:none" src="calender/calender.jpeg" width="34" height="29" border="0" alt=""></a>
                    
			               
				 </div>	

										
	
   <div class="form-group">
 <b>Motherboard </b><font color=red>'00001'</font>         
      <select class="form-control" name='mobo' >	 <option> </option>
            
			<?	$s1 = mysql_query("SELECT * FROM tbarang where idkategori='00001' and stock > '0' ");
				if(mysql_num_rows($s1) > 0){
			 while($datas1 = mysql_fetch_array($s1)){
				$idbarang=$datas1['idbarang'];
				$namabarang=$datas1['namabarang'];
				$stock=$datas1['stock'];?>
			 <option value="<? echo $idbarang; ?>"> <? echo $namabarang; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Prosesor</b><font color=red>'00002'</font>           
      <select class="form-control" name='prosesor'><option> </option>
            
			<?	$s2 = mysql_query("SELECT * FROM tbarang where idkategori='00002' and stock > '0'");
				if(mysql_num_rows($s2) > 0){
			 while($datas2 = mysql_fetch_array($s2)){
				$idbarang2=$datas2['idbarang'];
				$namabarang2=$datas2['namabarang'];?>
			 <option value="<? echo $idbarang2; ?>"> <? echo $namabarang2; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Power Supply</b><font color=red>'00003'</font>          
      <select class="form-control" name='ps'><option> </option>
            
			<?	$s3 = mysql_query("SELECT * FROM tbarang where idkategori='00003' and stock > '0'");
				if(mysql_num_rows($s3) > 0){
			 while($datas3 = mysql_fetch_array($s3)){
				$idbarang3=$datas3['idbarang'];
				$namabarang3=$datas3['namabarang'];?>
			 <option value="<? echo $idbarang3; ?>"> <? echo $namabarang3; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Cassing</b><font color=red>'00004'</font>           
      <select class="form-control" name='casing' ><option> </option>
            
			<?	$s4 = mysql_query("SELECT * FROM tbarang where idkategori='00004' and stock > '0' ");
				if(mysql_num_rows($s4) > 0){
			 while($datas4 = mysql_fetch_array($s4)){
				$idbarang4=$datas4['idbarang'];
				$namabarang4=$datas4['namabarang'];?>
			 <option value="<? echo $idbarang4; ?>"> <? echo $namabarang4; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
   <div class="form-group">
 <b>Harddisk Slot 1</b><font color=red>'00005'</font>           
      <select class="form-control" name='hd1' ><option> </option>
            
			<?	$s5 = mysql_query("SELECT * FROM tbarang where idkategori='00005' and stock > '0'");
				if(mysql_num_rows($s5) > 0){
			 while($datas5 = mysql_fetch_array($s5)){
				$idbarang5=$datas5['idbarang'];
				$namabarang5=$datas5['namabarang'];?>
			 <option value="<? echo $idbarang5; ?>"> <? echo $namabarang5; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>Harddisk Slot 2</b><font color=red>'00005'</font>           
      <select class="form-control" name='hd2' ><option> </option>
            
			<?	$s5 = mysql_query("SELECT * FROM tbarang where idkategori='00005' and stock > '0'");
				if(mysql_num_rows($s5) > 0){
			 while($datas5 = mysql_fetch_array($s5)){
				$idbarang5=$datas5['idbarang'];
				$namabarang5=$datas5['namabarang'];?>
			 <option value="<? echo $idbarang5; ?>"> <? echo $namabarang5; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>RAM Slot 1</b><font color=red>'00006'</font>          
      <select class="form-control" name='ram1' ><option> </option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00006' and stock > '0'");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $idbarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>RAM Slot 2</b><font color=red>'00006'</font>          
      <select class="form-control" name='ram2' ><option> </option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00006' and stock > '0'");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $idbarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>Fan Prosesor</b><font color=red>'00007'</font>         
      <select class="form-control" name='fan' ><option> </option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00007' and stock > '0'");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $idbarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
  <div class="form-group">
 <b>DVD Internal</b> <font color=red>'00008'</font>         
      <select class="form-control" name='dvd' ><option> </option>
            
			<?	$s6 = mysql_query("SELECT * FROM tbarang where idkategori='00008' and stock > '0'");
				if(mysql_num_rows($s6) > 0){
			 while($datas6 = mysql_fetch_array($s6)){
				$idbarang6=$datas6['idbarang'];
				$namabarang6=$datas6['namabarang'];?>
			 <option value="<? echo $idbarang6; ?>"> <? echo $namabarang6; ?>
			 </option>
			 
			 <?}}?>
			
    
        </select> 
                                        
                                    
                                        </div>
	



									
                                    <button  name="tombol" class="btn text-muted text-center btn-danger" type="submit">Simpan</button>
            <button  name="button_tambah" class="btn text-muted text-center btn-primary" type="reset">Reset</button>
			 </td>

                                    </form>
									<br>
									
                            </div>
                        </div>
                            </div>
                </div>
				</div>
				<iframe width=174 height=189 name="gToday:normal:calender/agenda.js" id="gToday:normal:calender/agenda.js" src="calender/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>