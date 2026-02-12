<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$q = mysqli_query($conn, "
    SELECT cart.*, products.price 
    FROM cart 
    JOIN products ON cart.product_id = products.product_id
    WHERE cart.user_id = '$user_id'
");

if (mysqli_num_rows($q) == 0) {
    header("Location: view_cart.php");
    exit;
}

$total = 0;
$items = [];

while ($row = mysqli_fetch_assoc($q)) {
    $total += $row['price'] * $row['quantity'];
    $items[] = $row;
}

/* INSERT ORDER */
mysqli_query($conn, "
    INSERT INTO orders (user_id, total_amount, order_date)
    VALUES ('$user_id', '$total', NOW())
");

$order_id = mysqli_insert_id($conn);

/* INSERT ORDER ITEMS */
foreach ($items as $item) {
    mysqli_query($conn, "
        INSERT INTO order_items (order_id, product_id, price, quantity)
        VALUES (
            '$order_id',
            '{$item['product_id']}',
            '{$item['price']}',
            '{$item['quantity']}'
        )
    ");
}

/* CLEAR CART */
mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

header("Location: order_success.php");
exit;
