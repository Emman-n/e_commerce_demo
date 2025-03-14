<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="UTF-8">
    <title>Products in Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-2">

 <!-- Switch Mode Button -->
 <form action="index.php?action=switch_mode" method="POST" class="mt-4">
        <!-- <button type="submit" class="btn btn-secondary">
            Switch to <?= ($_SESSION['mode'] === 'admin') ? 'Client' : 'Admin' ?> Mode
        </button> -->
    </form>


            <h1 class="mb-4">Products</h1>

            <!-- Add Product Form -->
            <?php if ($_SESSION['mode'] === 'admin'): ?>
                <div class="card mb-2">
                    <div class="card-body p-1">
                        <h6 class="mb-3">Add Product</h6>
                        <form action="index.php?action=create_product&category_id=<?= $_GET['category_id'] ?>" method="POST" enctype="multipart/form-data">

                            <div class="mb-1">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Product Name" required>
                                <input type="number" step="0.01" name="price" class="form-control form-control-sm" placeholder="Price" required>
                            </div>

                            <div class="mb-2">
                                <textarea name="description" class="form-control form-control-sm" placeholder="Description" rows="2"></textarea>
                            </div>

                            <div class="mb-2">
                                <input type="file" name="image" class="form-control form-control-sm">
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary w-100">Add</button>
                        </form>
                    </div>
                </div>

            <?php endif; ?>

            <!-- Products List -->
            <div class="row">
                <?php if (!empty($products)) { ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-4 mb-4">
                            <div
                                class="card h-100"
                                style="cursor: pointer;"
                                onclick="window.location.href='index.php?action=view_product_detail&product_id=<?= $product['id'] ?>'">

                                <!-- Product Image -->
                                <?php if (!empty($product['image'])): ?>
                                    <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" style="height: 200px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                        <span class="text-muted">No Image</span>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                    <!-- <h6 class="card-subtitle mb-2 text-muted">ID: <?= htmlspecialchars($product['id']) ?></h6> -->
                                    <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                    <p class="card-text fw-bold">$<?= htmlspecialchars($product['price']) ?></p>
                                  

                                    <?php if ($_SESSION['mode'] === 'admin'): ?>

                                        <button type="submit" class="btn btn-warning btn-sm w-100">Update</button>
                                        <br><br>

                                        <!-- Delete Product Form -->
                                        <form action="index.php?action=delete_product&category_id=<?= $_GET['category_id'] ?>" method="POST">
                                            <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                                        </form>

                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php } ?>
            </div>



</body>

</html>