<?include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2> Retur Pemasukan Barang </h2>



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
										 <th>No Faktur</th>
										       <th>Tanggal</th>
                                           
                                            <th>Supplier</th>
                                            
											<th>Keterangan</th>
						
										
											<th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <? $date=date('20y-m');
									   $datee=$date.'%';
									   $sql = mysql_query("SELECT * from tpembelian,tsupplier where tpembelian.idsupp=tsupplier.idsupp ");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$nofaktur=$data['nofaktur'];
				$idsupp=$data['idsupp'];
					$namasupp=$data['namasupp'];
				$tglbeli=$data['tglbeli'];
				$keterangan=$data['keterangan'];
				
		
			
				?>
				
                                        <tr class="gradeC">
										<td><? echo $nofaktur ?></td>
										<td><? echo $tglbeli ?></td>
                                            <td><? echo $namasupp ?></td>
                                            <td><? echo $keterangan?></td>
										
										
                             
										
											  <td class="center">
									<form action="user.php?menu=freturmasuk" method="post" >
									
											<input type="hidden" name="nofaktur" value=<?php echo $nofaktur; ?> />
									
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Retur</button>
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
			<meta http-equiv=refresh content=180;url='user.php?menu=homeadmin'>
           