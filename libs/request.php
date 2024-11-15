<?php
    class Request {
        public $body = null;
        public $params = null;
        public $query = null;

        public function __construct() {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    
            try {

                if (strpos($contentType, 'application/json') !== false) {
                    $this->body = json_decode(file_get_contents('php://input'));
                } elseif (strpos($contentType, 'multipart/form-data') !== false) {
                    $this->body = (object) array_merge($_POST, $_FILES);
                } else {
                    $this->body = null;
                }

            } catch (Exception $e) {
                
                $this->body = null;
            }
    
            $this->query = (object) $_GET;
        }
    }