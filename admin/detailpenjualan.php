<?php
$koneksi = new mysqli("localhost", "root", "", "farmasi");

if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
    exit();
}

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

?>

<h2>Data Penjualan</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Penjualan</th>
            <th>Jumlah Obat</th>
            <th>Tanggal</th>
            <th>ID Obat</th>
            <th>ID Pembelian</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 1;
        $ambil = $koneksi->query("SELECT penjualan.*, obat.harga FROM penjualan JOIN obat ON penjualan.id_obat = obat.id_obat");

        while ($pecah = $ambil->fetch_assoc()) {
            $total = $pecah['jumlah_obat'] * $pecah['harga'];
            ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $pecah['no_penjualan']; ?></td>
                <td><?php echo $pecah['jumlah_obat']; ?></td>
                <td><?php echo $pecah['tanggal']; ?></td>
                <td><?php echo $pecah['id_obat']; ?></td>
                <td><?php echo $pecah['id_pembelian']; ?></td>
                <td><?php echo $total; ?></td>
            </tr>
            <?php $nomor++; ?>
        <?php } ?>
    </tbody>
</table>
