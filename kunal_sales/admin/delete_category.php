<?php
include '../config/db.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM categories WHERE category_id='$id'");

header("Location: manage_categories.php");
exit;
