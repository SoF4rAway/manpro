<?php
session_start();

if (isset($_SESSION['admin']) || isset($_SESSION['user'])) {
    // Check if it's an admin or user session
    if (isset($_SESSION['admin'])) {
        // Admin logout
        session_destroy();
        echo "<script>alert('Anda telah logout sebagai admin. Logout berhasil!');</script>";
    } elseif (isset($_SESSION['user'])) {
        // User logout
        session_destroy();
        echo "<script>alert('Anda telah logout sebagai user. Logout berhasil!');</script>";
    }
} else {
    // If no valid session is found, redirect to login page
    header("Location: login.php");
    exit();
}

echo "<script>location='login.php';</script>";
?>
