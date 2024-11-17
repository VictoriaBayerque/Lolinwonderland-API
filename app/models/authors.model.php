<?php
require_once "./app/controllers/authors.api.controller.php";
    class AuthorsModel {
        private $db;

        public function __construct() {
            $this->db = new PDO('mysql:host=localhost;dbname=Lolinwonderland_db;charset=utf8', 'root', '');
        }
        
        public function getAuthors($authorFilter = null, $orderBy = null){
            $sql = 'SELECT * FROM Authors';

            if($authorFilter !== null) {
                $sql .= ' WHERE book_authorid = ' . $authorFilter;
            }
            
            if($orderBy !== null) {
                switch($orderBy) {
                    case 'name':
                        $sql .= ' ORDER BY author_name';
                        break;
                    case 'age':
                        $sql .= ' ORDER BY author_age';
                        break;
                    case 'activity':
                        $sql .= ' ORDER BY author_activity';
                        break;
                }
            }
            
            $query = $this->db->prepare($sql);
            $query->execute();
            $authors = $query->fetchAll(PDO::FETCH_OBJ);

            return $authors;
        }
        public function getAuthor($authorid) {
            $query = $this->db->prepare('SELECT * FROM Authors WHERE author_id = ?');
            $query->execute([$authorid]);   
            $author = $query->fetch(PDO::FETCH_OBJ);
            return $author;
        }

        public function insertAuthor ($author_name, $author_age, $author_activity, $author_img = null){
            $newFileName = null;
            if ($author_img) {
                $newFileName = $this->moveImg($author_img);
            }

            $query =$this->db-> prepare ('INSERT INTO Authors (author_name, author_age, author_activity, author_img) VALUES (?, ?, ?, ?)');
            $query->execute([$author_name, $author_age, $author_activity, $newFileName]);
            
            return $this->db->lastInsertId();
        }

        private function moveImg($img) {
            if(is_array($img)) {
                $newFileName = uniqid() . "." . strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
                $filepath = "./public/statics/images/authors/" . $newFileName ;
                move_uploaded_file($img['tmp_name'], $filepath);
            }
            if(is_string($img)) {
                $newFileName = uniqid() . "." . strtolower(pathinfo($img, PATHINFO_EXTENSION));
                $filepath = "./public/statics/images/authors/" . $newFileName ;
            }
            
            return $newFileName;
        }

        public function eraseAuthor($authorid){
            $query = $this->db->prepare ('DELETE FROM Authors WHERE author_id = ?');
            $query->execute([$authorid]);
        }

        function updateAuthor ($authorid, $author_name, $author_age, $author_activity){
            $query = $this->db->prepare('UPDATE Authors SET author_name = ?, author_age = ?, author_activity = ? WHERE author_id = ?');
            $query->execute([$author_name, $author_age, $author_activity, $authorid]);    
        } 
    }
