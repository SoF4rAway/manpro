<?php
include 'template.php';
$koneksi = db_conn();

// Check if logged in user is an admin
if (isset($_SESSION['isLoggedIn'])) {
    if ($_SESSION['isAdmin']) {
        $userRole = 'Admin';
    } else {
        $userRole = 'User';
    }
} else {
    // Redirect to login.php if 'isAdmin' is not set
    header('Location: /login.php');
    exit();
}

$userName = $_SESSION['nama'];

$date = date("Y-m-d");

// Routing logic
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'home.php';
        break;
    default:
        http_response_code(404);
        exit('Not Found');
}
?>
