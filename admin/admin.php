<?php
$koneksi = new mysqli("localhost", "root", "", "farmasi");

$userRole = $_SESSION['role'] ?? '';
$userId = $_SESSION['user_id'] ?? '';
?>

<h4>Anda adalah : <?php echo ($userRole === 'User') ? 'Pegawai' : $userRole; ?></h4>

<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 20px;
        margin-top: 20px;
    }

    .card {
        flex: 1 1 calc(100% - 20px); 
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.5s ease;
        margin-bottom: 20px;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .card-body {
        text-align: center;
        padding: 15px;
    }
     .btn-warning:hover {
        color: white;
        background-color: red;
        border-color: red;
    }
    .btn-warning {
        color: red;
        background-color: white;
        border: 1px solid red;
        border-radius: 20px; 
        transition: background-color 0.3s, color 0.3s, border-color 0.3s, border-radius 0.3s;
 
     
    }
    .output-title {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: bold;
        color: #E32636;
    }

    .product-name {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
        color: red;
    }

    .product-quantity,
    .product-price {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .btn-small {
        width: 30px;
    }
</style>

<div class="card-container">
    <?php $nomor = 1; ?>

    <?php
    // Query to retrieve admin data
    $adminQuery = $koneksi->query("SELECT id_admin as id, nama as nama, telepon as telepon, 'Admin' as status FROM admin");
    while ($admin = $adminQuery->fetch_assoc()) {
    ?>
        <div class="card">
            <div class="card-body">
                <div class="product-name">Nama : <?php echo $admin['nama']; ?></div>
                <div class="product-quantity">Telepon : <?php echo $admin['telepon']; ?></div>
                <div class="product-price">Status : <?php echo $admin['status']; ?></div>
                <?php if ($userRole === 'Admin') : ?>
                    <div class="text-right">
                        <a href="index.php?halaman=ubahadmin&id=<?php echo $admin['id']; ?>" class="btn btn-warning">Ubah</a>
                    </div>
                <?php elseif ($userRole === 'User') : ?>
                    <div class="text-right">
                        <a href="#" class="btn btn-warning disabled">Ubah</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php $nomor++; ?>
    <?php } ?>
     <?php
    // Query to retrieve admin data
    $adminQuery = $koneksi->query("SELECT id_user as id, nama as nama, telepon as telepon, 'User' as status FROM user");
    while ($admin = $adminQuery->fetch_assoc()) {
    ?>
        <div class="card">
            <div class="card-body">
                <div class="product-name">Nama : <?php echo $admin['nama']; ?></div>
                <div class="product-quantity">Telepon : <?php echo $admin['telepon']; ?></div>
                <div class="product-price">Status : <?php echo $admin['status']; ?></div>
                <?php if ($userRole === 'Admin') : ?>
                    <div class="text-right">
                        <a href="index.php?halaman=ubahadmin&id=<?php echo $admin['id']; ?>" class="btn btn-warning">Ubah</a>
                    </div>
                <?php elseif ($userRole === 'User') : ?>
                    <div class="text-right">
                        <a href="#" class="btn btn-warning disabled">Ubah</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php $nomor++; ?>
    <?php } ?>
</div>

<?php if ($userRole === 'Admin') : ?>
    <a href="index.php?halaman=tambahadmin" class="btn btn-warning">Tambah Admin atau Pegawai</a>
<?php elseif ($userRole === 'User') : ?>
    <button class="btn btn-warning disabled">Tambah Admin atau Pegawai</button>
<?php endif; ?>
