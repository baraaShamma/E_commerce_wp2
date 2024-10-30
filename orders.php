<?php
include 'db.php';
include 'navbar.php'; 

if ($is_logged_in){
    $user_id = $_SESSION['user_id'];
  
  }
$sql = "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC";
$orders = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Previous Orders</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- bootstrap links -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Previous Orders</h2>
        <?php if ($orders && $orders->num_rows > 0): ?>
        <?php while ($order = $orders->fetch_assoc()): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Order number: <?= $order['id'] ?></h5>
                <p class="card-text">Order date: <?= $order['order_date'] ?></p>
                <p class="card-text">Total price: <?= $order['total_price'] ?> $</p>
                <p class="card-text">Order status: <?= $order['status'] ?></p>

                <h6 class="mt-4">Product Details:</h6>
                <?php
                    $order_id = $order['id'];
                    $sql = "SELECT products.name, order_items.quantity, order_items.price
                            FROM order_items
                            JOIN products ON order_items.product_id = products.id
                            WHERE order_items.order_id = $order_id";
                    $items = $conn->query($sql);
                    ?>
                <ul class="list-group">
                    <?php while ($item = $items->fetch_assoc()): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?= $item['name'] ?> (<?= $item['quantity'] ?>)</span>
                        <span><?= $item['quantity'] * $item['price'] ?> $</span>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <p class="text-center mt-4">You have no previous Orders.</p>
        <?php endif; ?>
    </div>

    <?php
include 'footer.php';
?>
</body>

</html>