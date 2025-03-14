<?php
namespace App\Models;

use App\Config\Database;// database connection
use PDO; //PHP databases extension

class Product {
    private $conn;// database connection
    private $table = 'products';//table name

    public function __construct() { // runs automatically
        $database = new Database();
        $this->conn = $database->connect();//connect to database
    }

    
    // Get Product by ID
    public function getById($product_id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $product_id);
        $stmt->execute();
        return $stmt->fetch();
    }


    // Get All Product in a Category
    public function getByCategory($category_id) {
        $query = "SELECT * FROM {$this->table} WHERE category_id = :category_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }
 

    // Create Product
    public function create($category_id, $name, $description, $price, $imagePath = null) {
        $query = "INSERT INTO {$this->table} (category_id, name, description, price, image) 
                  VALUES (:category_id, :name, :description, :price, :image)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $imagePath);
    
        return $stmt->execute();
    }

    // Update Product
    public function update($id, $name, $description, $price) {
        $query = "UPDATE {$this->table} SET name = :name, description = :description, price = :price WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Delete Product
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>