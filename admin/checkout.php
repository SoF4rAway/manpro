<?=template_header($userName, $date)?>

<div class="placeorder content-wrapper">
    <h1>Your Order Has Been Placed</h1>
    <p>Thank you for ordering with us! We'll contact you by email with your order details.</p>
</div>

<?php

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $koneksi->begin_transaction();

        // Retrieve the subtotal from the form (assuming it's posted as 'subtotal')
        $totalHarga = floatval($_POST['subtotal']);
        $tanggal_pembelian = date('Y-m-d');

        // Insert into 'pembelian' table
        $stmt = $koneksi->prepare("INSERT INTO pembelian (tanggal_pembelian, total_pembelian) VALUES (?, ?)");
        $stmt->bind_param("sd", $tanggal_pembelian, $totalHarga);
        $stmt->execute();

        $id_pembelian = $koneksi->insert_id;
        $total_pembelian = 0;

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id_obat => $product) {
                $jumlah_obat = 1;
                $tanggal_penjualan = $tanggal_pembelian;

                // Insert into 'penjualan' table
                $stmt = $koneksi->prepare("INSERT INTO penjualan (jumlah_obat, tanggal, id_obat, id_pembelian) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("issi", $jumlah_obat, $tanggal_penjualan, $id_obat, $id_pembelian);
                $stmt->execute();

                // Update stock in 'obat' table
                $stmt = $koneksi->prepare("UPDATE obat SET stok = stok - ? WHERE id_obat = ?");
                $stmt->bind_param("ii", $jumlah_obat, $id_obat);
                $stmt->execute();

                $total_pembelian += $product['harga'] * $jumlah_obat;
            }

            // Clear the cart
            $_SESSION['cart'] = array();
        }

        // Update total_pembelian in 'pembelian' table
        $stmt = $koneksi->prepare("UPDATE pembelian SET total_pembelian = ? WHERE id_pembelian = ?");
        $stmt->bind_param("di", $total_pembelian, $id_pembelian);
        $stmt->execute();

        // Commit the transaction
        $koneksi->commit();

        // Output success message and order details
        echo "<p>Checkout successful. Your order has been processed. Thank you for shopping!</p>";
        echo "<p>Order details:</p>";
        echo "<p>ID Pembelian: {$id_pembelian}</p>";
        echo "<p>Tanggal Pembelian: {$tanggal_pembelian}</p>";
        echo "<p>Total Harga: Rp" . number_format($totalHarga, 0, ',', '.') . "</p>";
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $koneksi->rollback();
        echo "Error: " . $e->getMessage();
    }
}
?>
