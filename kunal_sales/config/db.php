<?php
// TEMP: show errors (remove later)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create database connection
$conn = mysqli_connect("localhost", "root", "", "kunal_sales");

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
