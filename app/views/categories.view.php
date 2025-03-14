<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Catalog - Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">

    <h1 class="mb-4">Categories</h1>

    <div class="row">

        <!-- Admin Add Category Card -->
        <?php if ($_SESSION['mode'] === 'admin'): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-primary">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title">Add New Category</h5>
                        <form action="index.php?action=create" method="POST" enctype="multipart/form-data">
                            <input type="text" name="name" class="form-control me-2 mb-2" placeholder="Category Name" required>
                            <input type="file" name="image" class="form-control me-2 mb-2" accept="image/*">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Loop Through Categories -->
        <?php foreach ($categories as $category): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm position-relative">

                    <!-- Category Image (Click to view products) -->
                    <a href="index.php?action=view_products&category_id=<?= $category['id'] ?>">
                        <?php if (!empty($category['image'])): ?>
                            <img src="<?= htmlspecialchars($category['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($category['name']) ?>" style="max-height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <img src="public/images/placeholder.png" class="card-img-top" alt="No Image" style="max-height: 200px; object-fit: cover;">
                        <?php endif; ?>
                    </a>

                    <!-- Card Content -->
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="index.php?action=view_products&category_id=<?= $category['id'] ?>" class="text-decoration-none text-dark">
                                <?= htmlspecialchars($category['name']) ?>
                            </a>
                        </h5>

                        <?php if ($_SESSION['mode'] === 'admin'): ?>
                            <!-- Edit Form -->
                            <form action="index.php?action=update" method="POST" class="d-flex mb-2 mt-3">
                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" class="form-control me-2" required>
                                <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                            </form>

                            <!-- Delete Form -->
                            <form action="index.php?action=delete" method="POST">
                                <input type="hidden" name="id" value="<?= $category['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm w-100">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>

    </div>

</body>

</html>