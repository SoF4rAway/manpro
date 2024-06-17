<h2>Tambah Pengguna</h2>

<form method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input type="text" class="form-control" name="nama">
    </div>
    <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input type="tel" class="form-control" name="telepon">
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="status">
            <option value="admin">Admin</option>
            <option value="pegawai">Pegawai</option>
        </select>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>

<?php
if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $telepon = $_POST['telepon'];
    $status = $_POST['status'];

    // Validate the inputs (you can add more validation if needed)
    if (empty($nama) || empty($telepon) || empty($status)) {
        echo "<div class='alert alert-danger'>Harap lengkapi semua field</div>";
    } else {
        // Save the data to the appropriate table based on the selected status
        $koneksi = new mysqli('localhost', 'root', '', 'farmasi');

        if ($koneksi->connect_error) {
            die("Connection failed: " . $koneksi->connect_error);
        }

        $stmt = $koneksi->prepare("INSERT INTO user (username, nama, password ,telepon, admin) VALUES(?, ?, ?, ?, ?)");

        // Use prepared statements to prevent SQL injection
        if ($status === 'admin') {
            $role = 1;
        } else {
            $role = 0;;
        }

        // Hash the password before storing it in the database
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt->bind_param('sssss', $username, $nama, $password, $telepon, $role);
        $stmt->execute();
        $stmt->close();

        echo "<div class='alert alert-info'>Data tersimpan</div>";
        header("refresh:1;url=index.php?halaman=pelanggan");
    }
}
?>
