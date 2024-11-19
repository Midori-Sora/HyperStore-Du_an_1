<?php

class HomeModel {
    private $SUNNY;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getFeaturedProducts() {
        $sql = "SELECT * FROM products ORDER BY price DESC LIMIT 4";
        $result = $this->conn->query($sql);
        $products = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        return $products;
    }

    public function getNewestPhones() {
        $sql = "SELECT * FROM products ORDER BY import_date DESC LIMIT 4";
        $result = $this->conn->query($sql);
        $products = [];
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        return $products;
    }
}
?>