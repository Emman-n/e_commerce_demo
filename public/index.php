<?php
session_start(); 

require_once '../vendor/autoload.php';

include 'navbar.php';  


use App\Controllers\CategoryController;
use App\Controllers\ProductController;

// Default to admin mode if not set
if (!isset($_SESSION['mode'])) {
    $_SESSION['mode'] = 'admin';
}

// Instantiate controller
$categoryController = new CategoryController();
$productController = new ProductController();


// Handle Actions
$action = $_GET['action'] ?? null;

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
    
            // Handle image upload
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageTmpPath = $_FILES['image']['tmp_name'];
                $imageName = time() . '_' . basename($_FILES['image']['name']);
                $uploadDir = 'public/images/categories/';
                $targetFilePath = $uploadDir . $imageName;
    
                // Make sure the folder exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
    
                if (move_uploaded_file($imageTmpPath, $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }
    
            $categoryController->store($name, $imagePath);
        }
        exit();

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $categoryController->update($id, $name);
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $categoryController->destroy($id);
        }
        break;


    // -------------------- Cart Actions --------------------



    case 'add_to_cart':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
    
            // Initialize cart if it doesn't exist
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
    
            // Check if product already in cart
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'product_id' => $product_id,
                    'name' => $name,
                    'price' => $price,
                    'quantity' => 1
                ];
            }
    
            // Redirect to the cart or product list (your choice)
            header('Location: index.php?action=view_cart');
            exit();
        }
        break;

    case 'view_cart':
        $cart = $_SESSION['cart'] ?? [];
        include '../app/views/cart.view.php';
        exit();

    case 'remove_from_cart':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'];

            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
            }

            header('Location: index.php?action=view_cart');
            exit();
        }
        break;


    case 'checkout':
        unset($_SESSION['cart']);
        include '../app/views/checkout.view.php';
        exit();
        break;

        // -------------------- Product Actions --------------------


    case 'view_product_detail':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $product_id = $_GET['product_id'] ?? '';

            if (empty($product_id)) {
                header('Location: index.php');
                exit();
            }

            $product = $productController->show($product_id);

            include '../app/views/productDetail.view.php';
        }
        exit();




    case 'view_products':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $category_id = $_GET['category_id'] ?? '';

            if (empty($category_id)) {
                // Optional: redirect or handle error
                header('Location: index.php');
                exit();
            }

            $products = $productController->index($category_id);

            include '../app/views/products.view.php';
        }
        exit();



    case 'create_product':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_GET['category_id'];
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;

            // Handle the image
            $imagePath = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageTmpPath = $_FILES['image']['tmp_name'];
                $imageName = basename($_FILES['image']['name']);
                $uploadDir = 'images/';
                $targetFilePath = $uploadDir . time() . '_' . $imageName;

                if (move_uploaded_file($imageTmpPath, $targetFilePath)) {
                    $imagePath = $targetFilePath;
                }
            }

            // Pass image path to store method
            $productController->store($category_id, $name, $description, $price, $imagePath);
            include '../app/views/products.view.php';
        }
        break;

    case 'update_product':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_GET['category_id'];
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $productsController = new App\Controllers\ProductController();
            $productsController->update($id, $category_id, $name, $description, $price);
        }
        exit();

    case 'delete_product':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $category_id = $_GET['category_id'];
            $id = $_POST['id'];
            $productsController = new App\Controllers\ProductController();
            $productsController->destroy($id, $category_id);
        }
        break;



    case 'switch_mode':
        // Toggle mode
        $_SESSION['mode'] = ($_SESSION['mode'] === 'admin') ? 'client' : 'admin';
        header('Location: index.php');
        exit();
        // break;


    default:
        // No action, just show the page
        break;
}





// Get categories list and load the view
$categories = $categoryController->index();

// $products = $productController->index(  1 );

// Show the categories view and pass the data
require_once '../app/views/categories.view.php';
