<?php

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SESSION['role'] == 'admin') {
    // Admin logout
    session_destroy();
    echo "<script>alert('Anda telah logout sebagai admin. Logout berhasil!');</script>";
} elseif ($_SESSION['role'] == 'user') {
    // User logout
    session_destroy();
    echo "<script>alert('Anda telah logout sebagai user. Logout berhasil!');</script>";
}

echo "<script>location='login.php';</script>";
?>
