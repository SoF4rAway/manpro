<style>
    .btn-primary:hover {
        color: white;
        background-color: red;
        border-color: red;
    }

    .btn-primary {
        color: red;
        background-color: white;
        border: 1px solid red;
        border-radius: 20px;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s, border-radius 0.3s;
    }
</style>

<?php
template_header($userName,$date);

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

// Check if form is submitted for quantity adjustment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quantity_adjust'])) {
    // Loop through the submitted quantities
    foreach ($_POST['quantity_adjust'] as $id_obat => $quantity) {
        // Update the quantity in the shopping cart
        if (isset($_SESSION['keranjang'][$id_obat])) {
            $_SESSION['keranjang'][$id_obat]['quantity'] = $quantity;
        }
    }
}

// Fetch data from the obat table
$stmt = $koneksi->prepare("SELECT * FROM obat");
$stmt->execute();
$result = $stmt->get_result();

// Display the contents of the shopping cart
echo "<h2>Keranjang </h2>";
echo "<form method='post' action='index.php?page=keranjang' style='margin-top: 20px;'>";
 // Form for quantity adjustment
echo "<table style='border-collapse: collapse; width: 100%; margin-top: 20px;'>
        <tr>
            <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>ID Obat</th>
            <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Nama Obat</th>
            <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Harga</th>
            <th style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Jumlah</th>
        </tr>";

$totalHarga = 0; // Initialize total price variable

while ($row = mysqli_fetch_assoc($result)) {
    $id_obat = $row['id_obat'];
    $quantity = isset($_SESSION['keranjang'][$id_obat]['quantity']) ? $_SESSION['keranjang'][$id_obat]['quantity'] : 0;
    $harga = $row['harga'];
    $subTotal = $harga * $quantity;

    echo "<tr>
            <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>{$row['id_obat']}</td>
            <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>{$row['nama_obat']}</td>
            <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>Rp" . number_format($harga, 0, ',', '.') . "</td>
            <td style='border: 1px solid #dddddd; text-align: left; padding: 8px;'>
                <input type='number' name='quantity_adjust[{$row['id_obat']}]' value='{$quantity}' min='0'>
            </td>
        </tr>";

    // Update the total price based on the adjusted quantities
    $totalHarga += $subTotal;
}

echo "</table>";

echo "<h3>Total Harga: Rp" . number_format($totalHarga, 0, ',', '.') . "</h3>"; // Display total price

echo "<button type='submit' class='btn-primary' style='padding: 10px; cursor: pointer;'>Update Keranjang</button>";
echo "</form>"; // Close form for quantity adjustment

// Checkout button with the primary styles
echo '<form action="index.php?page=checkout" method="post" style="margin-top: 10px;">
        <input type="hidden" name="total_harga" value="' . $totalHarga . '">
        <button type="submit" class="btn-primary" style="padding: 10px; cursor: pointer;">Checkout</button>
      </form>';

// Close the prepared statement
$stmt->close();
?>
