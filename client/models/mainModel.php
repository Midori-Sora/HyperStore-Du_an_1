<?php
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
                "mysql:host=localhost;dbname=duan1",
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
?>