<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Laporan Pesanan</h2>

        <!-- Form Pencarian -->
        <form method="GET" action="report.php">
            <label for="customer_name">Nama Pelanggan:</label>
            <input type="text" name="customer_name" id="customer_name" placeholder="Nama Pelanggan">

            <label for="start_date">Dari Tanggal:</label>
            <input type="date" name="start_date" id="start_date">

            <label for="end_date">Sampai Tanggal:</label>
            <input type="date" name="end_date" id="end_date">

            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

        <br>

        <!-- Tabel Laporan -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Koneksi ke database
                $conn = mysql_connect("localhost", "root", "dlris30g");
                mysql_select_db("sitdl", $conn);

                $query = "SELECT * FROM orders WHERE 1=1";
                if (!empty($_GET['customer_name'])) {
                    $customer_name = mysql_real_escape_string($_GET['customer_name']);
                    $query .= " AND customer_name LIKE '%$customer_name%'";
                }
                if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
                    $start_date = mysql_real_escape_string($_GET['start_date']);
                    $end_date = mysql_real_escape_string($_GET['end_date']);
                    $query .= " AND order_date BETWEEN '$start_date' AND '$end_date'";
                }

                $result = mysql_query($query, $conn);
                if (mysql_num_rows($result) > 0) {
                    while ($row = mysql_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td>" . $row['customer_name'] . "</td>";
                        echo "<td>" . $row['product_name'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . number_format($row['total_price'], 2) . "</td>";
                        echo "<td>
                                <button type='button' class='btn btn-info' onclick='showDetails(" . json_encode($row) . ")'>Detail</button>
                                <button type='button' class='btn btn-warning' onclick='showEdit(" . json_encode($row) . ")'>Edit</button>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Tidak ada data ditemukan.</td></tr>";
                }
                mysql_close($conn);
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal untuk Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="modalOrderId"></span></p>
                    <p><strong>Tanggal Pesanan:</strong> <span id="modalOrderDate"></span></p>
                    <p><strong>Nama Pelanggan:</strong> <span id="modalCustomerName"></span></p>
                    <p><strong>Nama Produk:</strong> <span id="modalProductName"></span></p>
                    <p><strong>Jumlah:</strong> <span id="modalQuantity"></span></p>
                    <p><strong>Total Harga:</strong> <span id="modalTotalPrice"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" method="POST" action="edit_order.php">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editOrderId">
                        <div class="form-group">
                            <label for="editOrderDate">Tanggal Pesanan:</label>
                            <input type="date" class="form-control" name="order_date" id="editOrderDate">
                        </div>
                        <div class="form-group">
                            <label for="editCustomerName">Nama Pelanggan:</label>
                            <input type="text" class="form-control" name="customer_name" id="editCustomerName">
                        </div>
                        <div class="form-group">
                            <label for="editProductName">Nama Produk:</label>
                            <input type="text" class="form-control" name="product_name" id="editProductName">
                        </div>
                        <div class="form-group">
                            <label for="editQuantity">Jumlah:</label>
                            <input type="number" class="form-control" name="quantity" id="editQuantity">
                        </div>
                        <div class="form-group">
                            <label for="editTotalPrice">Total Harga:</label>
                            <input type="text" class="form-control" name="total_price" id="editTotalPrice">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // Fungsi untuk menampilkan data di modal Detail
        function showDetails(data) {
            document.getElementById("modalOrderId").textContent = data.id;
            document.getElementById("modalOrderDate").textContent = data.order_date;
            document.getElementById("modalCustomerName").textContent = data.customer_name;
            document.getElementById("modalProductName").textContent = data.product_name;
            document.getElementById("modalQuantity").textContent = data.quantity;
            document.getElementById("modalTotalPrice").textContent = data.total_price;
            $('#detailModal').modal('show');
        }

        // Fungsi untuk menampilkan data di modal Edit
        function showEdit(data) {
            document.getElementById("editOrderId").value = data.id;
            document.getElementById("editOrderDate").value = data.order_date;
            document.getElementById("editCustomerName").value = data.customer_name;
            document.getElementById("editProductName").value = data.product_name;
            document.getElementById("editQuantity").value = data.quantity;
            document.getElementById("editTotalPrice").value = data.total_price;
            $('#editModal').modal('show');
        }
    </script>
</body>
</html>
