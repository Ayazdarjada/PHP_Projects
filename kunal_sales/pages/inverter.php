<?php
include '../header.php';
include '../config/db.php';

$q = mysqli_query($conn,"
    SELECT * FROM products WHERE category='Inverter'
");
?>

<div class="product-grid">
<?php while ($p = mysqli_fetch_assoc($q)) { ?>
  <div class="product-card">

    <img src="../assets/images/<?php echo $p['image']; ?>"
         style="width:100%; height:180px; object-fit:cover; border-radius:12px;">

    <h3 class="mt-3"><?php echo $p['product_name']; ?></h3>
    <p class="price">₹<?php echo $p['price']; ?></p>

    <a href="../cart/add_to_cart.php?id=<?php echo $p['product_id']; ?>"
       class="add-btn">Add to Cart</a>
  </div>
<?php } ?>
</div>

<?php include '../footer.php'; ?>
