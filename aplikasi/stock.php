<?include('config.php');?>  

            <div class="inner">
                <div class="row">
                    <div class="col-lg-12">


                        <h2>Stock Barang</h2>



                    </div>
                </div>

                <hr />


                <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                    
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID Barang</th>
                                            <th>Kategori</th>
                                            <th>Nama Barang</th>
											<th>Stock</th>
									
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?$sql = mysql_query("SELECT * FROM tbarang,tkategori where tbarang.idkategori=tkategori.idkategori");
				if(mysql_num_rows($sql) > 0){
				while($data = mysql_fetch_array($sql)){
				$idbarang=$data['idbarang'];
				$idkategori=$data['idkategori'];
				$namabarang=$data['namabarang'];
				$kategori=$data['kategori'];
				$stock=$data['stock'];
			
				?>
				
                                        <tr class="gradeC">
                                            <td><? echo $idbarang ?></td>
                                            <td><? echo $kategori ?></td>
                                            <td><? echo $namabarang ?></td>
											<td><? echo $stock ?></td>
                             
											
                                            
                                        </tr>
                <?}}?>                      
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
           