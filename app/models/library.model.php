<?php
require_once "./app/controllers/library.api.controller.php";
    class LibraryModel {
        private $db;

        public function __construct() {
            $this->db = new PDO('mysql:host=localhost;dbname=Lolinwonderland_db;charset=utf8', 'root', '');
        }

        public function getLibrary($authorFilter = null, $orderBy = null){
            $sql = 'SELECT * FROM Books';

            if($authorFilter !== null) {
                $sql .= ' WHERE book_authorid = ' . $authorFilter;
            }
            
            if($orderBy !== null) {
                switch($orderBy) {
                    case 'name':
                        $sql .= ' ORDER BY book_name';
                        break;
                    case 'author':
                        $sql .= ' ORDER BY book_authorid';
                        break;
                    case 'series':
                        $sql .= ' ORDER BY book_series';
                        break;
                }
            }

            $query = $this->db->prepare($sql);
            $query->execute();
            $library = $query->fetchAll(PDO::FETCH_OBJ);
        
            return $library;
        }

        public function getBook($id) {
            $query = $this->db->prepare('SELECT * FROM Books WHERE book_id = ?');
            $query->execute([$id]);   
            $book = $query->fetch(PDO::FETCH_OBJ);
            return $book;
        }

        public function insertBook ($book_name, $book_authorid, $book_series, $book_seriesnumber, $book_summary, $book_img = null){
            $newFileName = null;
            if ($book_img) {
                $newFileName = $this->moveImg($book_img);
            }

            $query =$this->db-> prepare ('INSERT INTO Books (book_name, book_authorid, book_series, book_seriesnumber, book_summary, book_img) VALUES (?, ?, ?, ?, ?, ?)');
            $query ->execute ([$book_name, $book_authorid, $book_series, $book_seriesnumber, $book_summary, $newFileName]);
            
            return $this->db->lastInsertId();
        }

        private function moveImg($img) {
            if(is_array($img)) {
                $newFileName = uniqid() . "." . strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
                $filepath = "./public/statics/images/books/" . $newFileName ;
                move_uploaded_file($img['tmp_name'], $filepath);
            }
            if(is_string($img)) {
                $newFileName = uniqid() . "." . strtolower(pathinfo($img, PATHINFO_EXTENSION));
                $filepath = "./public/statics/images/books/" . $newFileName ;
            }
            
            
            return $newFileName;
        }
    
        public function eraseBook($id) {
            $query = $this->db->prepare ('DELETE FROM Books WHERE book_id = ?');
            $query->execute([$id]);
        }

        public function updateBook($book_id, $book_name, $book_authorid, $book_series, $book_seriesnumber, $book_summary) {
            $query = $this->db->prepare('UPDATE Books SET book_name = ?, book_authorid = ?, book_series = ?, book_seriesnumber = ?, book_summary = ? WHERE book_id = ?');
            $query->execute([$book_name, $book_authorid, $book_series, $book_seriesnumber, $book_summary, $book_id]);
        }
}



// public function updateBook($book_id, $book_name, $book_authorid, $book_series, $book_seriesnumber, $book_summary, $book_img = null) {
//     $newFileName = null;
//     if ($book_img) {
//         $newFileName = $this->moveImg($book_img);
        
//         $query = $this->db->prepare('UPDATE Books SET book_name = ?, book_authorid = ?, book_series = ?, book_seriesnumber = ?, book_summary = ?, book_img = ? WHERE book_id = ?');
//         $query->execute([$book_name, $book_authorid, $book_series, $book_seriesnumber, $book_summary, $newFileName, $book_id]);
//     } else {
//         $query = $this->db->prepare('UPDATE Books SET book_name = ?, book_authorid = ?, book_series = ?, book_seriesnumber = ?, book_summary = ? WHERE book_id = ?');
//         $query->execute([$book_name, $book_authorid, $book_series, $book_seriesnumber, $book_summary, $book_id]);
//     }
// }