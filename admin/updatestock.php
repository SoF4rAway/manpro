<?php
$koneksi = new mysqli("localhost", "root", "", "farmasi");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id_obat']; // Adjust here
    $change = $_POST['change'];

    // Update the stock in the database
    $koneksi->query("UPDATE obat SET stok = stok + $change WHERE id_obat = $productId");

    // Redirect to home.php after updating the stock
    header('Location: index.php');
    exit();
} else {
    // Handle invalid request method
    header('HTTP/1.1 405 Method Not Allowed');
    header('Allow: POST');
    echo 'Invalid request method';
}
?>
