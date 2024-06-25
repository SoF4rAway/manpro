<?php
$stmt = $koneksi->prepare("SELECT * FROM pembelian ORDER BY tanggal_pembelian DESC");
$stmt->execute();
$ambil = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header($userName, $date)?>

<h2>Data Pembelian</h2>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>No</th>
        <th>Id Pembelian</th>
        <th>Tanggal Pembelian</th>
        <th>Total Pembelian</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'index.php?page=login';</script>";
        exit();
    }

    $nomor = 1;

    foreach ($ambil as $pecah) {
        ?>
        <tr>
            <td><?php echo $nomor; ?></td>
            <td><?php echo $pecah['id_pembelian']; ?></td>
            <td><?php echo $pecah['tanggal_pembelian']; ?></td>
            <td><?php echo $pecah['total_pembelian']; ?></td>
            <td>
                <a href="index.php?page=detailpenjualan&id=<?php echo $pecah['id_pembelian']; ?>" class="btn btn-info">Detail</a>
            </td>
        </tr>
        <?php
        $nomor++;
    }
    ?>
    </tbody>
</table>

