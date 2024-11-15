<?php
require_once './app/controllers/library.api.controller.php';
require_once './app/controllers/authors.api.controller.php';

    class JSONView {
        public function response($data, $status = 200) {
            header('Content-Type: application/json');
            $statusText = $this->_requestStatus($status);
            header('HTTP/1.1 ' . $status . ' ' . $statusText);
            echo json_encode($data);
        }
        

        private function _requestStatus($code) {
            $status = [
                200 => "OK",
                201 => "Created",
                204 => "No content",
                400 => "Bad request",
                401 => "Unauthorized",
                404 => "Not found",
                500 => "Internal server error",
            ];
            return $status[$code];
        }
    }