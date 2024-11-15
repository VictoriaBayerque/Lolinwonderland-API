<?php
    require_once './app/models/library.model.php';
    require_once './app/models/authors.model.php';
    require_once './app/views/json.view.php';

    class LibraryController {
        private $model;
        private $view;

        public function __construct() {
            $this->model = new libraryModel();
            $this->view = new JSONView();
            $this->authorModel = new authorsModel();
        }
        public function getAllBooks($req, $res) {
            $authorFilter = null;
            if(isset($req->query->author)) {
                $authorFilter = $req->query->author;
            }
            $orderBy = null;
            if (isset($req->query->order)) {
                $orderBy = $req->query->order;
            }

            $library = $this->model->getLibrary($authorFilter, $orderBy);

            return $this->view->response($library);
        }

        public function getBook($req, $res) {
            $id = $req->params->id;
            $book = $this->model->getBook($id);
            if (!$book) {
                return $this->view->response("The book does not exist in our database", 404);
            }
            return $this->view->response($book);
        }

        public function addBook($req, $res) {
            
            if(
                empty($req->body->book_name) ||
                empty($req->body->book_authorid) ||
                empty($req->body->book_series) ||
                empty($req->body->book_seriesnumber) ||
                empty($req->body->book_summary) ||
                empty($req->body->book_img)
            ) {
                return $this->view->response("You must complete all fields.", 400);
            }

            $name = $req->body->book_name;
            $author = $req->body->book_authorid;
            $series = $req->body->book_series;
            $number = $req->body->book_seriesnumber;
            $summary = $req->body->book_summary;
            $img = $req->body->book_img;
            

            $id = $this->model->insertBook($name, $author, $series, $number, $summary, $img);
            
            if($id) {
                return $this->view->response("Book added successfully with the id: " . $id, 201);
                
            } else {
                return $this->view->response("There was an error and the book could not be added.", 500);
            }
        }


        public function deleteBook($req, $res) {
            $id = $req->params->id;
            $book = $this->model->getBook($id);

            if (!$book){
                return $this->view->response('The book does not exist in the database', 404);
            }

            $this->model->eraseBook($id);
            return $this->view->response("The book has been deleted successfully.");
        }

        public function updateBook($req, $res) {
            $id = $req->params->id;
            $book = $this->model->getBook($id);
            if(!$book) {
                return $this->view->response("The book does not exist in the database.", 404);
            }
            if(
                empty($req->body->book_name) ||
                empty($req->body->book_authorid) ||
                empty($req->body->book_series) ||
                empty($req->body->book_seriesnumber) ||
                empty($req->body->book_summary)
            ) {
                return $this->view->response("All the fields must be completed.", 400);
            }

            $name = $req->body->book_name;
            $author = $req->body->book_authorid;
            $series = $req->body->book_series;
            $number = $req->body->book_seriesnumber;
            $summary = $req->body->book_summary;

            $this->model->updateBook($id, $name, $author, $series, $number, $summary);
            $updatedBook = $this->model->getBook($id);
            
            return $this->view->response($updatedBook);
        }

    }
