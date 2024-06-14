<?php
session_start(); 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koneksi = new mysqli("localhost", "root", "", "farmasi");

    if ($koneksi->connect_error) {
        die("Connection failed: " . $koneksi->connect_error);
    }

    try {
        $koneksi->begin_transaction();

        $totalHarga = $_POST['total_harga'];
        $tanggal_pembelian = date('Y-m-d');

        $insertPembelian = $koneksi->prepare("INSERT INTO pembelian (tanggal_pembelian, total_pembelian) VALUES (?, ?)");
        $insertPembelian->bind_param("sd", $tanggal_pembelian, $totalHarga);
        $insertPembelian->execute();

        $id_pembelian = $koneksi->insert_id;
        $total_pembelian = 0;

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $id_obat => $product) {
                $jumlah_obat = 1; 
                $tanggal_penjualan = $tanggal_pembelian;

                $insertPenjualan = $koneksi->prepare("INSERT INTO penjualan (jumlah_obat, tanggal, id_obat, id_pembelian) VALUES (?, ?, ?, ?)");
                $insertPenjualan->bind_param("issi", $jumlah_obat, $tanggal_penjualan, $id_obat, $id_pembelian);
                $insertPenjualan->execute();

                $updateStokObat = $koneksi->prepare("UPDATE obat SET stok = stok - ? WHERE id_obat = ?");
                $updateStokObat->bind_param("ii", $jumlah_obat, $id_obat);
                $updateStokObat->execute();

                $total_pembelian += $product['harga'] * $jumlah_obat;
            }

            $_SESSION['cart'] = array();
        }

        $updateTotalPembelian = $koneksi->prepare("UPDATE pembelian SET total_pembelian = ? WHERE id_pembelian = ?");
        $updateTotalPembelian->bind_param("di", $total_pembelian, $id_pembelian);
        $updateTotalPembelian->execute();

        $koneksi->commit();

        echo "<p>Checkout successful. Your order has been processed. Thank you for shopping!</p>";
        echo "<p>Order details:</p>";
        echo "<p>ID Pembelian: $id_pembelian</p>";
        echo "<p>Tanggal Pembelian: $tanggal_pembelian</p>";
        echo "<p>Total Harga: Rp" . number_format($totalHarga, 0, ',', '.') . "</p>";
    } catch (Exception $e) {
        $koneksi->rollback();
        echo "Error: " . $e->getMessage();
    } finally {
        $koneksi->close();
    }
} else {
    header("Location: keranjang.php");
    exit();
}
?>
