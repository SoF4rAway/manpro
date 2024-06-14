<?php
session_start();
$id_produk = $_GET['id'];
if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk] += 1;
} else {
    $_SESSION['keranjang'][$id_produk] = 1;
}

// Store the success message in a session variable
$_SESSION['success_message'] = "Produk berhasil ditambahkan ke keranjang!";



// Redirect back to the referring page
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>