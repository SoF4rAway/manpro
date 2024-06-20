<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['id_obat'], $_POST['quantity']) && is_numeric($_POST['id_obat']) && is_numeric($_POST['quantity'])) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = (int)$_POST['id_obat'];
    $quantity = (int)$_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our databaser
    $stmt = $koneksi->prepare('SELECT * FROM obat WHERE id_obat = ?');
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    // Store the result so we can check if the record exists in the database
    $result = $stmt->get_result();

    // Fetch the product from the database and return the result as an Array
    $product = $result->fetch_assoc();
    // Check if the product exists (array is not empty)
    if ($product > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index.php?page=cart');
    exit;
}

// Check for the URL param "remove", make sure it's a number
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    // Check if it's in the cart
    if (isset($_SESSION['cart'][$_GET['remove']])) {
        // Remove the product from the shopping cart
        unset($_SESSION['cart'][$_GET['remove']]);
        header('Location: index.php?page=keranjang');
    }
}


// Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('Location: index.php?page=cart');
    exit;
}

if (isset($_POST['placeorder']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=checkout');
    exit;
}

// Check the session variable for products in cart
$products_in_cart = $_SESSION['cart'] ?? array();
$products = array();
$subtotal = 0.00;

// If there are products in cart
if ($products_in_cart) {
    // Create a comma-separated list of product IDs for the query
    $product_ids = implode(',', array_keys($products_in_cart));

    // Prepare the query using a placeholder for the product IDs
    $query = 'SELECT * FROM obat WHERE id_obat IN (' . str_repeat('?,', count($products_in_cart) - 1) . '?)';

    // Prepare the statement
    $stmt = $koneksi->prepare($query);

    // Bind the product IDs as parameters
    $param_types = str_repeat('i', count($products_in_cart)); // Assuming product IDs are integers
    $stmt->bind_param($param_types, ...array_keys($products_in_cart));

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the products from the result
    while ($product = $result->fetch_assoc()) {
        $product_id = $product['id_obat'];
        $subtotal += (float)$product['harga'] * (int)$products_in_cart[$product_id];
        $products[] = $product;
    }

    // Close the statement
    $stmt->close();
}


?>

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

<?=template_header($userName,$date)?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="index.php?page=cart" method="post">
        <table>
            <thead>
            <tr>
                <td colspan="2">Product</td>
                <td>Price</td>
                <td>Quantity</td>
                <td>Total</td>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="img">
                            <a href="index.php?page=product&id=<?=$product['id_obat']?>">
                                <img src="../foto_produk/<?=$product['foto_obat']?>" width="50" height="50" alt="<?=$product['nama_obat']?>">
                            </a>
                        </td>
                        <td>
                            <a href="index.php?page=detail&id=<?=$product['id_obat']?>"><?=$product['nama_obat']?></a>
                            <br>
                            <a href="index.php?page=keranjang&remove=<?=$product['id_obat']?>" class="remove">Remove</a>
                        </td>
                        <td class="price">Rp;<?=$product['harga']?></td>
                        <td class="quantity">
                            <input type="number" name="quantity-<?=$product['id_obat']?>" value="<?=$products_in_cart[$product['id_obat']]?>" min="1" max="<?=$product['stok']?>" placeholder="Quantity" required>
                        </td>
                        <td class="price">Rp;<?=$product['harga'] * $products_in_cart[$product['id_obat']]?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">Rp;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Update" name="update">
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>