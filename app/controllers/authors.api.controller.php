<?php
    include_once './app/models/authors.model.php';
    include_once './app/views/json.view.php';
    require_once './helpers/auth.api.helper.php';
    require_once './helpers/auth.api.helper.php';

    class AuthorsController {
        private $model;
        private $view;
        private $authHelper;

        public function __construct() {
            $this->model = new authorsModel();
            $this->view = new JSONView();
            $this->authHelper = new AuthHelper();
        }
        public function getAll($req, $res) {
            $orderBy = null;
            if (isset($req->query->order)) {
                $orderBy = $req->query->order;
            }
            $authors = $this->model->getAuthors(null, $orderBy);
            return $this->view->response($authors);
        }

        public function getAuthor($req, $res) {
            $author = $this->model->getAuthor($req->params->id);
            if(!($author)) {
                return $this->view->response('The requested author does not exist in our database.', 404);
            }
            return $this->view->response($author);
        }

        public function addAuthor($req, $res) {

            $user = $this->authHelper->currentUserData();
            if(!$user) {
                return $this->view->response('Unauthorized user.', 401);
            }

            $user = $this->authHelper->currentUserData();
            if(!$user) {
                return $this->view->response('Unauthorized user.', 401);
            }

            if (
                empty($req->body->author_name) ||
                empty($req->body->author_age) ||
                empty($req->body->author_activity) ||
                empty($req->body->author_img)
            ) {
                return $this->view->response("All the fields must be completed.", 400);
            }
            $name = $req->body->author_name;
            $age = $req->body->author_age;
            $activity = $req->body->author_activity;
            $img = $req->body->author_img;

            $id = $this->model->insertAuthor($name, $age, $activity, $img);
            return $this->view->response("The author has been added successfully with the id: " . $id, 201);
        }
        
        public function deleteAuthor($req, $res) {

            //En la consigna no se pedia el token para borrar, por eso no lo agregué (para no entorpecer durante la corrección).
            //Sin embargo, para que el front me quedara "lógico", el botón de eliminar está oculto para el usuario que no esté logueado,
            //para simular que hubiera una comprobación de token.
            //Dejo comentado el codigo (acá y en la función deleteBook de app.js) por si lo quieren probar.

            // $user = $this->authHelper->currentUserData();
            // if(!$user) {
            //     return $this->view->response('Unauthorized user.', 401);
            // }

            $id = $req->params->id;
            $author = $this->model->getAuthor($id);

            if(!$author) {
                return $this->view->response("The author does not exist in the database.", 404);
            }

            $this->model->eraseAuthor($id);
            return $this->view->response("The author has been deleted successfully.");
        }

        public function updateAuthor($req, $res) {

            $user = $this->authHelper->currentUserData();
            if(!$user) {
                return $this->view->response('Unauthorized user.', 401);
            }

            $user = $this->authHelper->currentUserData();
            if(!$user) {
                return $this->view->response('Unauthorized user.', 401);
            }

            $id = $req->params->id;
            $author = $this->model->getAuthor($id);

            if(!$author) {
                return $this->view->response("The author does not exist in the database.", 404);
            }
            
            if(
                empty($req->body->author_name) ||
                empty($req->body->author_age) ||
                empty($req->body->author_activity)
            ) {
                
                return $this->view->response("All the fields must be completed.", 400);
            }

            $name = $req->body->author_name;
            $age = $req->body->author_age;
            $activity = $req->body->author_activity;

            // if ($req->body->author_img == null) {
                $this->model->updateAuthor($id, $name, $age, $activity);
            // } else {
                
            //     $img = $req->body->author_img;
            //     $this->model->updateAuthor($id, $name, $age, $activity, $img);
            // }

            $modifiedAuthor = $this->model->getAuthor($id);
            return $this->view->response($modifiedAuthor);
        }

        // public function addAuthor() {
        //     if ($_FILES['authorimg']['name']) {
        //         if ($_FILES['authorimg']['type'] == "image/jpeg" ||
        //         $_FILES['authorimg']['type'] == "image/jpg" ||
        //         $_FILES['authorimg']['type'] == "image/png") {
                    
        //             $this->model->insertAuthor(
        //                 $_POST['authorname'],
        //                 $_POST['authorage'],
        //                 $_POST['authoractivity'],
        //                 $_FILES['authorimg']
        //             );
        //         }
        //         else {
        //             $this->view->showError("Insert a valid file type");
        //             die();
        //         }
        //     }
        //     else {
        //         $this->model->insertAuthor(
        //             $_POST['authorname'],
        //             $_POST['authorage'],
        //             $_POST['authoractivity'],
        //         ); 
        //     }
        //     header("Location: " . BASE_URL . "authors");
        // }
        // public function deleteAuthor($id) {
        //     $author = $this->model->getAuthor($id);
        //     if (!$author){
        //         return $this->view->showError('The author does not exist in the database');
        //     }
        //     $this->model->eraseAuthor($id);

        //     header('Location: ' . BASE_URL);
        // } 
        // public function saveAuthor($id) { 
        //     if ($id) {
        //         if ($_FILES['authorimg']['name']) {
        //             if ($_FILES['authorimg']['type'] == "image/jpeg" ||
        //             $_FILES['authorimg']['type'] == "image/jpg" ||
        //             $_FILES['authorimg']['type'] == "image/png") {
                    
        //             $this->model->updateAuthor(
        //                 $id,
        //                 $_POST['authorname'],
        //                 $_POST['authorage'],
        //                 $_POST['authoractivity'],
        //                 $_FILES['authorimg']
        //             );
        //             } else {
        //                 $this->view->showError("Insert a valid file type");
        //                 die();
        //             }
        //         } else {
        //             $this->model->updateAuthor(
        //                 $id,
        //                 $_POST['authorname'],
        //                 $_POST['authorage'],
        //                 $_POST['authoractivity'],
        //             ); 
        //         }
        //     } else {
        //         return $this->view->showError('It is not possible to save the author');
        //     }
        //     header('Location: ' . BASE_URL . 'authors');
        // }
        // public function addAuthorView() {
        //     return $this->view->displayAddAuthor();
        // }
        // public function modifyAuthorForm($id) {
        //     $author = $this->model->getAuthor($id);
        //     return $this->view->modifyAuthor($author);
        // }
    }

