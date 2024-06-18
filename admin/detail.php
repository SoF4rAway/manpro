    <h2>Detail Obat</h2>
    <?php

    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Anda belum login, silahkan login terlebih dahulu.'); window.location.href = 'login.php';</script>";
        exit();
    }

    $ambil = $koneksi->query("SELECT * FROM obat WHERE id_obat='$_GET[id]'");
    $detail = $ambil->fetch_assoc();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body, html {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .card {
            display: flex;
            border: 1px solid #ddd;
            border-radius: 30px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: rgba(69, 65, 76, 0.2);
        }

        .card-title,
        .card-text,
        .btn-danger,
        .btn-warning {
            font-family: 'Arial', sans-serif;
            font-size: 18px;
        }

        .card img {
            width: 400px;   
            object-fit: contain;
            padding: 10px;
            margin-left: 30px;
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 50px;
        }

        .label {
            width: 150px;
            text-align: left;
            margin-right: 20px;
            color: black;
            display: inline-block;
        }

        .data {
            display: inline-block;
        }
        
        .btn-primary {
        color: white;
        background-color: red;
        border: 1px solid red;
        border-radius: 20px; 
        transition: background-color 0.3s, color 0.3s, border-color 0.3s, border-radius 0.3s;
    }

    .btn-primary:hover {
        color: white;
        background-color: darkred;
        border-color: darkred; 
        border-radius: 20px; 
       
    }

    </style>
</head>
<body>
    <div class="card">
        <?php
            $imagePath = '../foto_produk/' . $detail['foto_obat'];
        ?>
        <img src="<?php echo $imagePath; ?>" alt="Obat Image">
        <div class="card-body">
            <h5 class="card-title product-name">
                <span class="label">ID</span> <span class="data"><?php echo $detail['id_obat']; ?></span>
            </h5>
            <p class="card-text">
                <span class="label">Nama Produk</span> <span class="data"><?php echo $detail['nama_obat']; ?></span>
            </p>
            <p class="card-text">
                <span class="label">Harga</span> <span class="data">Rp<?php echo number_format($detail['harga'], 0, ',', '.'); ?></span>
            </p>
            <p class="card-text">
                <span class="label">Stok</span> <span class="data"><?php echo $detail['stok']; ?></span>
            </p>
             <p class="card-text">
                <span class="label">Tanggal Expire</span> <span class="data"><?php echo $detail['expired']; ?></span>
            </p>
           
             <?php
                $deskripsi = $detail['deskripsi'];
                if (!empty($deskripsi)) {
                    echo '<p class="card-text" style="text-align: justify;"><span class="label">Deskripsi</span> <span class="data">' . $deskripsi . '</span></p>';
                }
            ?>
        </div>

    </div>
    <a href="index.php?halaman=ubahproduk&id=<?php echo $detail['id_obat']; ?>" class="btn btn-primary">Edit</a>
    </form>
</body>
</html>



