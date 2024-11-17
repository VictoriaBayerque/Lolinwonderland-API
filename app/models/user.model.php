<?php
require_once "./app/controllers/user.api.controller.php";

class UserModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=Lolinwonderland_db;charset=utf8', 'root', '');
    }
    
    public function getUser($username) {
        $query = $this->db->prepare('SELECT * FROM Users WHERE user_username = ?');
        $query->execute([$username]);   
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}