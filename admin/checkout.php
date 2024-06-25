<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}
if (!empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
/*    echo "<p>Cart contents:</p>";
    echo "<ul>";
    foreach ($cart as $product_id => $quantity) {
        echo "<li>Product ID: $product_id, Quantity: $quantity</li>";
    }
    echo "</ul>";
    if (isset($_GET['subtotal'])) {
        $subtotal = floatval($_GET['subtotal']);
        echo "<p>Subtotal from URL: $subtotal</p>";
    }*/
    try{
        $koneksi->beginTransaction();

        $subtotal = floatval($_GET['subtotal']);
        $tanggal = date('Y-m-d');

        $stmt = $koneksi->prepare("INSERT INTO penjualan (tanggal, total_pembelian) VALUES (:tanggal, :subtotal)");
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->execute();

        $id_penjualan = $koneksi->lastInsertId();
        echo "<p>id : $id_penjualan</p>";
        foreach ($cart as $product_id => $quantity) {
            $stmt = $koneksi->prepare("SELECT harga FROM obat WHERE id_obat = :product_id");
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            $currentPrice = $stmt->fetchColumn();

            $stmt = $koneksi->prepare("INSERT INTO detail_penjualan (id_penjualan, id_obat, quantity, harga) VALUES (:id_penjualan, :id_obat, :quantity, :harga)");
            $stmt->bindParam(':id_penjualan', $id_penjualan);
            $stmt->bindParam(':id_obat', $product_id);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':harga', $currentPrice);
            $stmt->execute();

            $stmt = $koneksi->prepare("UPDATE obat SET stok = stok - :quantity WHERE id_obat = :product_id");
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
        }
        $koneksi->commit();
        // Output success message and order details
        echo "<p>Checkout successful. Your order has been processed. Thank you for shopping!</p>";
        echo '<a href="index.php?page=report_page&id=' . $id_penjualan . '"><button>View Transaction Report</button></a>';

        unset($_SESSION['cart']);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $koneksi->rollBack();
    }
}


/*if (isset($_POST['subtotal'])){
    try {
        $koneksi->beginTransaction();

        // Retrieve the subtotal from the form (assuming it's posted as 'subtotal')
        $totalHarga = floatval($_GET['subtotal']);
        $tanggal_pembelian = date('Y-m-d');

        // Insert into 'pembelian' table
        $stmt = $koneksi->prepare("INSERT INTO pembelian (tanggal_pembelian, total_pembelian) VALUES (?, ?)");
        $stmt->bindParam(1, $tanggal_pembelian, PDO::PARAM_STR);
        $stmt->bindParam(2, $totalHarga, PDO::PARAM_STR);
        $stmt->execute();

        $id_pembelian = $koneksi->lastInsertId();
        $total_pembelian = 0;

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id_obat => $product) {
                $jumlah_obat = 1;
                $tanggal_penjualan = $tanggal_pembelian;

                // Insert into 'penjualan' table
                $stmt = $koneksi->prepare("INSERT INTO penjualan (jumlah_obat, tanggal, id_obat, id_pembelian) VALUES (?, ?, ?, ?)");
                $stmt->bindParam(1, $jumlah_obat, PDO::PARAM_INT);
                $stmt->bindParam(2, $tanggal_penjualan, PDO::PARAM_STR);
                $stmt->bindParam(3, $id_obat, PDO::PARAM_INT);
                $stmt->bindParam(4, $id_pembelian, PDO::PARAM_INT);
                $stmt->execute();

                // Update stock in 'obat' table
                $stmt = $koneksi->prepare("UPDATE obat SET stok = stok - ? WHERE id_obat = ?");
                $stmt->bindParam(1, $jumlah_obat, PDO::PARAM_INT);
                $stmt->bindParam(2, $id_obat, PDO::PARAM_INT);
                $stmt->execute();

                $total_pembelian += $product['harga'] * $jumlah_obat;
            }

            // Clear the cart
            $_SESSION['cart'] = array();
        }

        // Update total_pembelian in 'pembelian' table
        $stmt = $koneksi->prepare("UPDATE pembelian SET total_pembelian = ? WHERE id_pembelian = ?");
        $stmt->bindParam(1, $total_pembelian, PDO::PARAM_STR);
        $stmt->bindParam(2, $id_pembelian, PDO::PARAM_INT);
        $stmt->execute();

        // Commit the transaction
        $koneksi->commit();

        // Output success message and order details
        echo "<p>Checkout successful. Your order has been processed. Thank you for shopping!</p>";
        echo "<p>Order details:</p>";
        echo "<p>ID Pembelian: {$id_pembelian}</p>";
        echo "<p>Tanggal Pembelian: {$tanggal_pembelian}</p>";
        echo "<p>Total Harga: Rp" . number_format($totalHarga, 0, ',', '.') . "</p>";
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $koneksi->rollBack();
        echo "Error: " . $e->getMessage();
    }
}*/
?>