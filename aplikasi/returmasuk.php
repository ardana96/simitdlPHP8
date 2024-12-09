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
                                       <?php 
                                       
                                       $date=date('20y-m');
									   $datee=$date.'%';
									   $sql = "SELECT * FROM tpembelian, tsupplier WHERE tpembelian.idsupp = tsupplier.idsupp";
                                        $query = sqlsrv_query($conn, $sql);

                                        // Memeriksa apakah ada baris yang dikembalikan
                                        if ($query !== false) {
                                            while ($data = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
                                        $nofaktur=$data['nofaktur'];
                                        $idsupp=$data['idsupp'];
                                            $namasupp=$data['namasupp'];
                                        $tglbeli=$data['tglbeli'];
                                        $keterangan=$data['keterangan'];
				
		
			
				?>
				
                                        <tr class="gradeC">
										<td><?php echo $nofaktur ?></td>
										<td><?php echo $tglbeli->format("Y-m-d") ?></td>
                                            <td><?php echo $namasupp ?></td>
                                            <td><?php echo $keterangan?></td>
										
										
                             
										
											  <td class="center">
									<form action="user.php?menu=freturmasuk" method="post" >
									
											<input type="hidden" name="nofaktur" value=<?php echo $nofaktur; ?> />
									
										
											<button  name="tombol" class="btn text-muted text-center btn-primary" type="submit">Retur</button>
											</form> 
											</td>
                                            
                                        </tr>
                <?php }} ?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
			<meta http-equiv=refresh content=180;url='user.php?menu=homeadmin'>
           