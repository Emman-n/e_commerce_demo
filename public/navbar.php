<nav class="navbar navbar-expand-lg navbar-dark bg-light text-dark ">
  <div class="container px-0">
    <!-- Brand / Logo on the left -->
    <a class="navbar-brand text-dark" href="index.php">Product Catalog</a>

    <!-- Collapse Button for Mobile -->
    <button class="navbar-toggler text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Links on the right -->
    <div class="collapse navbar-collapse text-dark" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        
        <!-- Home Link -->
        <li class="nav-item ">
          <a class="nav-link text-dark" href="index.php">Home</a>
        </li>

        <!-- Admin Mode Switch -->
        <li class="nav-item ">
          <a class="nav-link text-dark" href="index.php?action=switch_mode">
            Switch to <?= ($_SESSION['mode'] === 'admin') ? 'Client' : 'Admin' ?> Mode
          </a>
        </li>

        <!-- View Cart -->
        <li class="nav-item  ">
          <a class="nav-link text-dark" href="index.php?action=view_cart">
            Cart
            <?php
              $cart = $_SESSION['cart'] ?? [];
              $totalItems = array_sum(array_column($cart, 'quantity'));
            ?>
            <span class="badge bg-dark text-light"><?= $totalItems ?></span>
          </a>
        </li>

      </ul>
    </div>
  </div>
</nav>
