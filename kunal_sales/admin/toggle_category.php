<?php
include '../config/db.php';

$id = $_GET['id'];

mysqli_query($conn, "
    UPDATE categories
    SET status = IF(status=1, 0, 1)
    WHERE category_id='$id'
");

header("Location: manage_categories.php");
exit;
