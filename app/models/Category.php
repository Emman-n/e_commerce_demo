<?php
namespace App\Models;

use App\Config\Database;// database connection
use PDO; //PHP databases extension

class Category {
    private $conn;// database connection
    private $table = 'categories';//table name

    public function __construct() { // runs automatically
        $database = new Database();
        $this->conn = $database->connect();//connect to database
    }


    


    // Get All Categories
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get Category by ID
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Create Category
    public function create($name, $imagePath = null) {
        $query = "INSERT INTO {$this->table} (name, image) VALUES (:name, :image)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':image', $imagePath);
    
        return $stmt->execute();
    }

    // Update Category
    public function update($id, $name) {
        $query = "UPDATE {$this->table} SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Delete Category
    public function delete($id) {
        // First, delete products under this category
        $queryDeleteProducts = "DELETE FROM products WHERE category_id = :category_id";
        $stmtDelete = $this->conn->prepare($queryDeleteProducts);
        $stmtDelete->bindParam(':category_id', $id);
        $stmtDelete->execute();
    
        // Now, delete the category
        $queryDeleteCategory = "DELETE FROM {$this->table} WHERE id = :id";
        $stmtCategory = $this->conn->prepare($queryDeleteCategory);
        $stmtCategory->bindParam(':id', $id);
    
        return $stmtCategory->execute();
    }
}
?>