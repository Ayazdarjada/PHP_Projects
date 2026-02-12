<?php
include 'admin_header.php';
include '../config/db.php';

/* FETCH ACTIVE CATEGORIES */
$cat_q = mysqli_query($conn, "
    SELECT * FROM categories 
    WHERE status = 1 
    ORDER BY category_name ASC
");

if (isset($_POST['add_product'])) {

    // 1️⃣ Get form data
    $name        = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $price       = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // 2️⃣ IMAGE UPLOAD
    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];

    // Rename image to avoid duplicates
    $image_new = time() . "_" . $image;

    // Upload image
    move_uploaded_file($tmp, "../uploads/" . $image_new);

    // 3️⃣ Insert into database (WITH DESCRIPTION ✅)
    $insert = mysqli_query($conn, "
        INSERT INTO products 
        (product_name, category, price, image, description)
        VALUES 
        ('$name', '$category', '$price', '$image_new', '$description')
    ");

    if ($insert) {
        echo "<div class='alert alert-success'>Product Added Successfully</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to Add Product</div>";
    }
}
?>

<h2 class="mb-4">Add Product</h2>

<div class="admin-form">
<form method="POST" enctype="multipart/form-data">

    <!-- PRODUCT NAME -->
    <div class="mb-3">
        <label class="form-label">Product Name</label>
        <input type="text" name="product_name" class="form-control" required>
    </div>

    <!-- CATEGORY DROPDOWN -->
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category" class="form-select" required>
            <option value="">-- Select Category --</option>

            <?php while ($cat = mysqli_fetch_assoc($cat_q)) { ?>
                <option value="<?= htmlspecialchars($cat['category_name']); ?>">
                    <?= htmlspecialchars($cat['category_name']); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <!-- PRICE -->
    <div class="mb-3">
        <label class="form-label">Price (₹)</label>
        <input type="number" name="price" class="form-control" required>
    </div>

    <!-- DESCRIPTION (NEW ✅) -->
    <div class="mb-3">
        <label class="form-label">Product Description</label>
        <textarea 
            name="description" 
            class="form-control" 
            rows="4" 
            placeholder="Enter product details..."
            required
        ></textarea>
    </div>

    <!-- IMAGE -->
    <div class="mb-3">
        <label class="form-label">Product Image</label>
        <input type="file" name="image" class="form-control" required>
    </div>

    <!-- SUBMIT -->
    <button type="submit" name="add_product" class="btn btn-primary">
        Add Product
    </button>

</form>
</div>

<?php include 'admin_footer.php'; ?>
