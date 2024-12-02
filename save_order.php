<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "dlris30g";
$dbname = "sitdl";

// Membuat koneksi
$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysql_error());
}

// Memilih database
mysql_select_db($dbname, $conn);

// Ambil data header dari form
$order_date = $_POST['order_date'];
$customer_name = $_POST['customer_name'];

// Mulai transaksi
mysql_query("START TRANSACTION", $conn);

// Insert data ke tabel headers
$insertHeaderQuery = sprintf(
    "INSERT INTO headers (order_date, customer_name) VALUES ('%s', '%s')",
    mysql_real_escape_string($order_date),
    mysql_real_escape_string($customer_name)
);

$result = mysql_query($insertHeaderQuery, $conn);
if (!$result) {
    mysql_query("ROLLBACK", $conn);
    die("Error inserting header: " . mysql_error());
}

// Ambil ID header yang baru saja disimpan
$header_id = mysql_insert_id();

// Insert data items yang terkait dengan header_id
for ($i = 0; $i < count($_POST['product_name']); $i++) {
    $product_name = $_POST['product_name'][$i];
    $quantity = $_POST['quantity'][$i];
    $price = $_POST['price'][$i];

    $insertItemQuery = sprintf(
        "INSERT INTO items (header_id, product_name, quantity, price) VALUES (%d, '%s', %d, %f)",
        $header_id,
        mysql_real_escape_string($product_name),
        (int)$quantity,
        (float)$price
    );

    $result = mysql_query($insertItemQuery, $conn);
    if (!$result) {
        mysql_query("ROLLBACK", $conn);
        die("Error inserting item: " . mysql_error());
    }
}

// Commit transaksi jika semua insert berhasil
mysql_query("COMMIT", $conn);
echo "Order saved successfully!";

// Tutup koneksi
mysql_close($conn);
?>
