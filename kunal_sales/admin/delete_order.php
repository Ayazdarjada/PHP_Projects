<?php
include '../config/db.php';

$id = $_GET['id'];

/* Delete order items first */
mysqli_query($conn, "DELETE FROM order_items WHERE order_id='$id'");

/* Delete order */
mysqli_query($conn, "DELETE FROM orders WHERE order_id='$id'");

header("Location: view_orders.php");
exit;
