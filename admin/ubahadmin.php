<?php
$koneksi = new mysqli("localhost", "root", "", "farmasi");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to retrieve data based on ID
    $userQuery = $koneksi->query("SELECT * FROM user WHERE uid = $id");

    if ($userQuery->num_rows > 0) {
        $data = $userQuery->fetch_assoc();
        $tableName = 'user';
    } else {
        echo "Data not found";
        exit();
    }
} else {
    // Redirect the user to the appropriate page if 'id' is not set
    header("Location: admin.php");
    exit();
}
?>

<!-- HTML and Form for Editing Data -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <!-- Add your styles or include CSS here -->
</head>

<body>
    <h2>Edit Data</h2>

    <?php
    if (isset($_POST['update'])) {
        $nama = $_POST['nama'];
        $telepon = $_POST['telepon'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Validate and update data in the database
        // Use prepared statements to prevent SQL injection
        $stmt = $koneksi->prepare("UPDATE $tableName SET nama = ?, telepon = ?, password = ? WHERE uid = ?");
        $stmt->bind_param('ssss', $nama, $telepon, $password, $id);
        $stmt->execute();
        $stmt->close();

        // Show success message
        echo "<div class='alert alert-success'>Data updated successfully</div>";

        // Redirect to the appropriate page after updating
        header("refresh:2;url=index.php");
        exit();
    }
    ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama" value="<?php echo $data['nama']; ?>">
        </div>
        <div class="form-group">
            <label>Telepon</label>
            <input type="tel" class="form-control" name="telepon" value="<?php echo $data['telepon']; ?>">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password">
        </div>
        <button class="btn btn-primary" name="update">Update</button>
    </form>

    <!-- Add your additional HTML or scripts here -->
</body>

</html>
