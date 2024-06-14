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
        $nomor = 1;
        $ambil = $koneksi->query("SELECT * FROM pembelian ORDER BY tanggal_pembelian DESC");

        while ($pecah = $ambil->fetch_assoc()) {
        ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $pecah['id_pembelian']; ?></td>
                <td><?php echo $pecah['tanggal_pembelian']; ?></td>
                <td><?php echo $pecah['total_pembelian']; ?></td>
                <td>
                    <a href="index.php?halaman=detailpenjualan&id=<?php echo $pecah['id_pembelian']; ?>" class="btn btn-info">Detail</a>
                </td>
            </tr>
        <?php
            $nomor++;
        }
        ?>
    </tbody>
</table>
