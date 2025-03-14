<?php
namespace App\Controllers;

use App\Models\Product;

class ProductController {

    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    // Get products by category
    public function index($category_id) {
        return $this->productModel->getByCategory($category_id);
    }


    public function show($product_id) {
        return $this->productModel->getById($product_id);
    }


    // Create product
    public function store($category_id, $name, $description, $price, $imagePath = null) {
        if (empty($name) || empty($price)) {
            return "Name and Price are required.";
        }

         $this->productModel->create($category_id, $name, $description, $price, $imagePath);
        header("Location: index.php?action=view_products&category_id={$category_id}");
        exit();
    }

    // Update product
    public function update($id, $category_id, $name, $description, $price) {
        $this->productModel->update($id, $name, $description, $price);
        header("Location: index.php?action=view_products&category_id={$category_id}");
        exit();
    }

    // Delete product
    public function destroy($id, $category_id) {
        $this->productModel->delete($id);
        header("Location: index.php?action=view_products&category_id={$category_id}");
        exit();
    }
}
