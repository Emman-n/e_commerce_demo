<?php
namespace App\Controllers;

use App\Models\Category;

class CategoryController {

    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category(); //runs when the controller is called
    }

    

    // List Categories
    public function index() {
        return $this->categoryModel->getAll();
    }

    // Create Category
    public function store($name, $imagePath = null) {
        if (empty($name)) {
            return "Category name is required.";
        }

        $this->categoryModel->create($name, $imagePath);
        header('Location: /index.php'); // Redirect after action
        exit();
    }

    // Edit Category
    public function update($id, $name) {
        if (empty($name)) {
            return "Category name is required.";
        }

        $this->categoryModel->update($id, $name);
        header('Location: /index.php');
        exit();
    }

    // Delete Category
    public function destroy($id) {
        $this->categoryModel->delete($id);
        header('Location: /index.php');
        exit();
    }
}
