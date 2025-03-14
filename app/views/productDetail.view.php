<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">

    <h1 class="mb-4">Product Details</h1>

    <?php if ($product): ?>
        <div class="card">
            <div class="row g-0"> <!-- g-0 removes space between columns -->

                <!-- Left Side: Image -->
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-light">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid p-3" style="max-height: 300px; object-fit: cover;">
                    <?php else: ?>
                        <span class="text-muted">No Image Available</span>
                    <?php endif; ?>
                </div>

                <div class="col-md-8">

                    <!-- Right Side: Product Details -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text">Price: $<?= htmlspecialchars($product['price']) ?></p>

                          
                            <td>
                                <!-- Add to Cart button -->
                                <form action="index.php?action=add_to_cart" method="POST" class="d-inline ms-2">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                                    <input type="hidden" name="price" value="<?= $product['price'] ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Add to Cart</button>
                                </form>
                            </td>
                         
                            <?php if ($_SESSION['mode'] === 'admin'): ?>
                            <!-- Edit Product Form -->
                            <form action="index.php?action=update_product&category_id=<?= htmlspecialchars($product['category_id']) ?>" method="POST" class="mb-2">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">

                                <div class="mb-2">
                                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="form-control form-control-sm" required>
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="description" value="<?= htmlspecialchars($product['description']) ?>" class="form-control form-control-sm">
                                </div>
                                <div class="mb-2">
                                    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="form-control form-control-sm" required>
                                </div>
                                <button type="submit" class="btn btn-warning btn-sm w-100">Update</button>
                            </form>
                            <?php endif; ?>

                        </div>
                    </div>



                </div>

            </div>
        </div>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>

    <!-- <a href="index.php?action=view_products&category_id=<?= htmlspecialchars($product['category_id']) ?>" class="btn btn-secondary mt-4">Back to Products</a> -->

</body>

</html>