<?include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Stock Komputer Rakitan Hidden</h2>



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
                                            <th>IDPC</th>
											    <th>Permintaan</th>
                                            <th>Motherboard</th>
                                            <th>Prosesor</th>
											<th>Power Supply</th>
											<th>Casing</th>
											<th>Harddisk I</th>
											<th>Harddisk II</th>
											<th>Ram I</th>
											<th>Ram II</th>
										<th>Fan Prosesor</th>
										<th>DVD</th>
											<th>Keterangan</th>
											
												<th>Show</th>
									
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM tpc where status='digudang' and aktif='nonaktif' ");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$idpc=$data['idpc'];
				$mobo=$data['mobo'];
				$prosesor=$data['prosesor'];
				$ps=$data['ps'];
				$casing=$data['casing'];
				$hd1=$data['hd1'];
				$hd2=$data['hd2'];
				$ram1=$data['ram1'];
				$ram2=$data['ram2'];
				$fan=$data['fan'];
				$dvd=$data['dvd'];
				$keterangan=$data['keterangan'];
				
				$aa="SELECT * FROM rincipermintaan WHERE namabarang='".$idpc."' ";
$aaa=mysql_query($aa);
	if(mysql_num_rows($aaa) > 0){
while($rinciaa=mysql_fetch_array($aaa)){
	$nopeminta=$rinciaa['nomor'];}
	$bb="SELECT * FROM permintaan WHERE nomor='".$nopeminta."' ";
$bbb=mysql_query($bb);
while($rincibb=mysql_fetch_array($bbb)){
$nmpeminta=$rincibb['nama'];}
	}
	
else{$nmpeminta='';}


			
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $idpc ?></td>
											  <td><? echo $nmpeminta ?></td>
                                            <td><? echo $mobo ?></td>
                                            <td><? echo $prosesor ?></td>
											<td><? echo $ps ?></td>
											<td><? echo $casing ?></td>
											<td><? echo $hd1 ?></td>
											<td><? echo $hd2 ?></td>
											<td><? echo $ram1 ?></td>
											<td><? echo $ram2 ?></td>
											<td><? echo $fan ?></td>
											<td><? echo $dvd ?></td>
											<td><? echo $keterangan ?></td>
											
												  <td class="center"><form action="aplikasi/showstockpc.php" method="post" >
											<input type="hidden" name="idpc" value=<?php echo $idpc; ?> />
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit" onclick="return confirm('Apakah anda yakin akan Memunculkan Data ini ?')">Show</button>
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
           