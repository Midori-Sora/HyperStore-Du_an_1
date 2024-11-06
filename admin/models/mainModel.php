<?php
require_once "models/authModel.php";
require_once "models/userModel.php";
require_once "models/categoryModel.php";
require_once "models/commentModel.php";
require_once "models/productModel.php";
class MainModel
{
    public $SUNNY;
    public function __construct()
    {
        $this->SUNNY = $this->connect_db();
    }
    public function connect_db()
    {
        $username = "root";
        $password = "";
        try {
            $SUNNY = new PDO(
                "mysql:host=localhost;dbname=hyperstore",
                $username,
                $password
            );
            $SUNNY->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
        return $SUNNY;
    }
}
$MainModel = new MainModel();
