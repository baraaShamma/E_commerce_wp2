<?php
include 'db.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$totalPrice = 0;
$sql = "SELECT cart.product_id, cart.quantity, products.name, products.price
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Confirm order</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="list-group">
            <?php while ($row = $result->fetch_assoc()): 
                $itemTotal = $row['price'] * $row['quantity'];
                $totalPrice += $itemTotal;
            ?>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= $row['name'] ?> (Quantity: <?= $row['quantity'] ?>)</span>
                    <span><?= $itemTotal ?> $</span>
                </div>
            <?php endwhile; ?>
        </div>
        <h4 class="text-right mt-3">Total price: <span><?= $totalPrice ?> $</span></h4>
        <form action="process_checkout.php" method="POST">
            <input type="hidden" name="total_price" value="<?= $totalPrice ?>">
            <button type="submit" class="btn btn-success mt-4 w-100">Confirm order</button>
        </form>
    <?php else: ?>
        <p class="text-center mt-4">Shopping cart is empty.</p>
    <?php endif; ?>
</div>

</body>
</html>
