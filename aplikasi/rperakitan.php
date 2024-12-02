<?include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Hasil Proses Perakitan </h2>



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
											<th>Tgl Rakit </th>
                                            <th>Motherboard</th>
                                            <th>Prosesor</th>
											<th>Power Supply</th>
											<th>Casing</th>
											<th>Harddisk I</th>
											<th>Harddisk II</th>
											<th>Ram I</th>
											<th>Ram II</th>
												<th>Keterangan</th>
									
											<th>Status</th>
												<th>Lokasi</th>
												<th>Penerima</th>
									
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM tpc where status<>'digudang'");
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
				$status=$data['status'];
				$lokasi=$data['lokasi'];
				$penerima=$data['penerima'];
				$tgl_rakit=$data['tglrakit'];
					$keterangan=$data['keterangan'];
			
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $idpc ?></td>
											<td><? echo $tgl_rakit ?></td>
                                            <td><? echo $mobo ?></td>
                                            <td><? echo $prosesor ?></td>
											<td><? echo $ps ?></td>
											<td><? echo $casing ?></td>
											<td><? echo $hd1 ?></td>
											<td><? echo $hd2 ?></td>
											<td><? echo $ram1 ?></td>
											<td><? echo $ram2 ?></td>
										
											<td><? echo $keterangan ?></td>
										<td><? echo $status ?></td>
											<td><? echo $lokasi ?></td>
											<td><? echo $penerima ?></td>
                               
											
                                            
                                        </tr>
                <?}}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
           