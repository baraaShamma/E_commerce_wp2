<?php
include 'db.php';
include 'navbar.php';
if ($is_logged_in){
  $user_id = $_SESSION['user_id'];

}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity'])) {
  $product_id = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $sql = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
    $sql = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND product_id = $product_id";
  } else {
    $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)";
  }
  if ($conn->query($sql) === TRUE) {
  } else {
    echo "حدث خطأ أثناء إضافة المنتج إلى السلة: " . $conn->error;
  }
}
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- bootstrap links -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="script.js"></script>

</head>
</head>

<body>


  <!-- product cards -->
  <div class="container" id="product-cards">
    <div class="row" style="margin-top: 30px;">
      <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="col-md-3 py-3 py-md-0">
          <a style='text-decoration:none'
            href="Product_detail.php?image=<?= $row['image'] ?>&name=<?= $row['name'] ?>&price=<?= $row['price'] ?>&description=<?= $row['description'] ?>">
            <div class="card" id="product-detail">
              <img src="./images/<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
              <div class="card-body">
                <h3 class="text-center"><?= $row['name'] ?></h3>
                <p class="text-center">Lorem ipsum dolor sit amet.</p>
                <div class="star text-center">
                  <i class="fa-solid fa-star checked"></i>
                  <i class="fa-solid fa-star checked"></i>
                  <i class="fa-solid fa-star checked"></i>
                  <i class="fa-solid fa-star checked"></i>
                  <i class="fa-solid fa-star checked"></i>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <h2 class="mb-0 price">$<?= $row['price'] ?></h2>

                </div>
              </div>
            </div>
          </a>
          <?php if ($is_logged_in): ?>
            <form method="POST" >
              <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
              <input type="number" name="quantity" value="1" min="1">
              <button type="submit" class="btn btn-primary mt-2 mb-5 py-md-2  ">Add to cart</button>
            </form>
          <?php else: ?>
            <button onclick="requireLogin()" class="btn btn-primary mt-2">Add to cart</button>

          <?php endif; ?>
        </div>
      <?php } ?>
    </div>
  </div>


  <?php
  include 'footer.php';
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>


</body>

</html>