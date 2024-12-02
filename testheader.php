<form method="POST" action="save_order.php">
    <h2>Header Data</h2>
    <label>Order Date:</label>
    <input type="date" name="order_date" required>
    
    <label>Customer Name:</label>
    <input type="text" name="customer_name" required>
    
    <h2>Item Data</h2>
    <table id="itemTable">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="product_name[]" required></td>
                <td><input type="number" name="quantity[]" required></td>
                <td><input type="number" step="0.01" name="price[]" required></td>
                <td><button type="button" onclick="removeRow(this)">Remove</button></td>
            </tr>
        </tbody>
    </table>
    <button type="button" onclick="addRow()">Add Item</button>
    <button type="submit">Save Order</button>
</form>

<script>
// Fungsi untuk menambah baris item di tabel
function addRow() {
    var table = document.getElementById("itemTable").getElementsByTagName("tbody")[0];
    var newRow = table.rows[0].cloneNode(true);
    table.appendChild(newRow);
}

// Fungsi untuk menghapus baris item di tabel
function removeRow(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
</script>
