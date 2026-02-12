<?php
include '../header.php';
include '../config/db.php';

$q = mysqli_query($conn, "SELECT * FROM products");
?>

<section class="products-section">
  <div class="product-grid">

  <?php while ($p = mysqli_fetch_assoc($q)) { ?>
    <div class="product-card">

      <img src="../uploads/<?php echo $p['image']; ?>"
     alt="<?php echo $p['product_name']; ?>"
     class="product-img">


      <h3><?php echo $p['product_name']; ?></h3>

      <div class="price">₹<?php echo $p['price']; ?></div>

      <a href="../cart/add_to_cart.php?id=<?php echo $p['product_id']; ?>"
         class="add-btn">
         Add to Cart
      </a>

    </div>
  <?php } ?>

  </div>
</section>

<?php include '../footer.php'; ?>
