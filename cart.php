<?php
include 'db.php';
include 'navbar.php';


$sql = "SELECT * FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = $user_id";
$result = $conn->query($sql);
$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="ar">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <div class="confirmation-dialog" id="confirmation-dialog">
    <div class="confirmation-box">
      <p>Are you sure you want to remove from your cart?</p>
      <button class="btn btn-danger" id="confirm-delete">Yes</button>
      <button class="btn btn-secondary" id="cancel-delete">No</button>
    </div>
  </div>

  <div class="container">
    <div class="cart-container">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): $totalItemPrice = $row['price'] * $row['quantity'];
          $totalPrice += $totalItemPrice; ?>
          <div class="cart-card" data-product-id="<?= $row['product_id'] ?>">
            <button class="delete-button" onclick="showDeleteConfirmation(<?= $row['product_id'] ?>)">X</button>
            <img src="./images/<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
            <h2><?= $row['name'] ?></h2>
            <p>Total price: <span class="item-total-price" data-price="<?= $row['price'] ?>"><?= $totalItemPrice ?></span> $</p>
            <div class="quantity-controls">
              <button class="btn btn-secondary" onclick="updateQuantity(<?= $row['product_id'] ?>, -1)">-</button>
              <span class="item-quantity"><?= $row['quantity'] ?></span>
              <button class="btn btn-secondary" onclick="updateQuantity(<?= $row['product_id'] ?>, 1)">+</button>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">Shopping cart is empty.</p>
      <?php endif; ?>
    </div>
  </div>
  <div class="checkout-container">
    <p class="total-price">Total: <span id="total-price"><?= $totalPrice ?></span> $</p>
    <a href="checkout.php" class="btn btn-primary mt-2">Complete the order</a>
  </div>

  <?php
  include 'footer.php';
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>

</html>