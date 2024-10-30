<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = $_POST['total_price'];

// إضافة الطلب الجديد إلى جدول orders
$sql = "INSERT INTO orders (user_id, total_price, status) VALUES ($user_id, $total_price, 'قيد التجهيز')";
$conn->query($sql);
$order_id = $conn->insert_id;

// جلب بيانات السلة مع السعر من جدول products
$sql = "SELECT cart.product_id, cart.quantity, products.price 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = $user_id";
$result = $conn->query($sql);

// التحقق من نجاح الاستعلام
if ($result === false) {
    die("Error fetching cart data: " . $conn->error);
}

// إضافة المنتجات المطلوبة إلى جدول order_items
while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    $price = $row['price'];
    
    $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)";
    
    if (!$conn->query($sql)) {
        die("Error inserting into order_items: " . $conn->error);
    }
}

// إفراغ السلة
$conn->query("DELETE FROM cart WHERE user_id = $user_id");

header("Location: orders.php");
exit();
