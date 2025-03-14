<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <h1 class="mb-4">Your Cart</h1>

    <?php if (!empty($cart)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($cart as $item): ?>
                    <?php $subtotal = $item['price'] * $item['quantity']; ?>
                    <?php $total += $subtotal; ?>
                            <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>$<?= htmlspecialchars($item['price']) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <!-- Remove item from cart -->
                            <form action="index.php?action=remove_from_cart" method="POST" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total: $<?= number_format($total, 2) ?></h3>

        <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
        <a href="index.php?action=checkout" class="btn btn-primary">Checkout</a>

    <?php else: ?>
        <p>Your cart is empty.</p>
        <a href="index.php" class="btn btn-secondary">Go to Products</a>
    <?php endif; ?>

</body>
</html>
