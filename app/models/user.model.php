<?php
require_once "./app/controllers/user.controller.php";

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
    public function insertUser ($user_name, $user_lastname, $user_email, $user_username, $user_password){
        $query =$this->db-> prepare ('INSERT INTO Users (user_name, user_lastname, user_email, user_username, user_password) VALUES (?, ?, ?, ?, ?)');
        $query ->execute ([$user_name, $user_lastname, $user_email, $user_username, $user_password]);
        
        return $this->db->lastInsertId();
    }
}