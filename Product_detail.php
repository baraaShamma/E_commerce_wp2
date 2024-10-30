<?php
include 'db.php';
include 'navbar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <title>Electronic Shop</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- bootstrap links -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

  <section class="bg-light">
    <div class="container pb-5">
      <div class="row">
        <div class="col-lg-5 mt-5">
          <div class="card mb-3">
            <img class="card-img img-fluid" src="" alt="Card image cap" id="product-detail">
          </div>
        </div>
        <div class="col-lg-7 mt-5">
          <div class="card">
            <div class="card-body">
              <h1 class="h2" id="product-name"></h1>
              <p class="h3 py-2" id="product-price"></p>
              <p class="py-2" id="product-rating">
                <span class="list-inline-item text-dark" id="product-description"></span>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  include 'footer.php';
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="app.js"></script>
  <script>

    var urlParams = new URLSearchParams(window.location.search);
    var imageName = urlParams.get('image');
    var productName = urlParams.get('name');
    var productPrice = urlParams.get('price');
    var productDescription = urlParams.get('description');

    var productImage = document.getElementById("product-detail");
    productImage.src = "images/" + imageName;

    var productNameElement = document.getElementById("product-name");
    productNameElement.textContent = productName;

    var productPriceElement = document.getElementById("product-price");
    productPriceElement.textContent = productPrice;

    var productDescriptionElement = document.getElementById("product-description");
    productDescriptionElement.textContent = productDescription;
  </script>
</body>

</html>