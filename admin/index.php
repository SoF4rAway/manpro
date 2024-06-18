﻿<?php
session_start();

include 'template.php';
$koneksi = db_conn();

// Check if logged in user is an admin
if (isset($_SESSION['isAdmin'])) {
    if ($_SESSION['isAdmin']) {
        $userRole = 'Admin';
    } else {
        $userRole = 'User';
    }
} else {
    // Redirect to login.php if 'isAdmin' is not set
    header('Location: login.php');
    exit();
}

$userName = $_SESSION['nama'];

$date = date("Y-m-d");

$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';

include $page . '.php';
?>
