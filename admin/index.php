<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

$koneksi = new mysqli("localhost", "root", "", "farmasi");

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

// You can now use $userRole to check the role of the user in your application
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Elixir System</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="Stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="assets/favi.ico" />
    <style>
        .navbar {
            background-color: #FF2400;
            border-color: #333; 
            min-height: 80px; 
            margin-bottom: 0; 
}
        .date-display {
            position: absolute;
            top: 25px;
            left: 1300px;
            font-size: 16px;
            color: #FFF;
        }
        .welcome-message {
            position: absolute;
            top: 25px;
            left: 10px;
            font-size: 20px;
            font-weight: bold;
            color: #FFF;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Add a subtle text shadow */
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <?php
        // Add the current date display using PHP
        echo '<div class="date-display">' . date('F j, Y') . '</div>';
    ?>
               
        </nav>
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center">
                        <img src="assets/img/find_user.jpg" class="user-image img-responsive" />
                    </li>
                    <li> <a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li> <a href="index.php?halaman=history"><i class="fas fa-history"></i> History</a></li>
                    <li> <a href="index.php?halaman=admin"><i class="fas fa-tshirt"></i> Pegawai</a></li>             
                    <li> <a href="index.php?halaman=logout"><i class="fas fa-sign-out-alt"></i> logout</a></li>

                </ul>
            </div>
        </nav>
      
        <div id="page-wrapper">
        <div class="welcome-message">
            <?php echo "Selamat datang $userName"; ?>
        </div>
            <div id="page-inner">   
                <?php
                if (isset($_GET['halaman'])) {
                    if ($_GET['halaman'] == "history") {
                        include 'history.php';
                    } elseif ($_GET['halaman'] == "admin") {
                        include 'admin.php';
                    } elseif ($_GET['halaman'] == "detail") {
                        include 'detail.php';
                    } elseif ($_GET['halaman'] == "tambahproduk") {
                        include 'tambahproduk.php';
                    } elseif ($_GET['halaman'] == "hapusproduk") {
                        include 'hapusproduk.php';
                    } elseif ($_GET['halaman'] == "ubahproduk") {
                        include 'ubahproduk.php';
                    } elseif ($_GET['halaman'] == "tambahadmin") {
                        include 'tambahadmin.php';
                    } elseif ($_GET['halaman'] == "ubahadmin") {
                        include 'ubahadmin.php';
                    } elseif ($_GET['halaman'] == "logout") {
                        include 'logout.php';
                    } elseif ($_GET['halaman'] == "detailpenjualan") {
                        include 'detailpenjualan.php';
                     } elseif ($_GET['halaman'] == "keranjang") {
                        include 'keranjang.php';
                     } elseif ($_GET['halaman'] == "checkout") {
                        include 'checkoutphp';
                    } elseif ($_GET['halaman'] == "home") {
                        include 'home.php';
                    }
                } else {
                    include 'home.php';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metisMenu.js"></script>
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
