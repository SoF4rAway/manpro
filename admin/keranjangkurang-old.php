<?php
session_start();
// Include your database connection code here

// Assuming you have a function to connect to the database
// function connectToDatabase() {
//     // Your database connection code here
// }

// Example usage:
// $db = connectToDatabase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_obat = $_POST['id_obat'];

    // Update the quantity in the shopping cart (you need to implement this based on your logic)
    // Example query: "UPDATE obat SET quantity = quantity - 1 WHERE id_obat = $id_obat";
    
    // Redirect back to the shopping cart page after updating
    header("Location: keranjang.php");
    exit();
}
?>
