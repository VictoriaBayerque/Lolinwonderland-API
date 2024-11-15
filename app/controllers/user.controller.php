<?php
include_once './app/models/user.model.php';
include_once './app/views/user.view.php';
include_once './app/views/auth.view.php';

class UserController {

    private $model;
    private $view;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new UserView();
        $this->authView = new AuthView();
    }

    public function showRegisterForm() {
        $this->view->displayRegisterForm();
    }
    public function registerUser() {
        if(
            !isset($_POST['name']) || empty($_POST['name']) ||
            !isset($_POST['lastname']) || empty($_POST['lastname']) ||
            !isset($_POST['email']) || empty($_POST['email']) ||
            !isset($_POST['username']) || empty($_POST['username']) ||
            !isset($_POST['password']) || empty($_POST['password'])
        ) {
            $this->view->showError("You must complete all the fields to complete the registration.");
            die();
        }
        else {
            $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $this->model->insertUser(
                $_POST['name'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['username'],
                $pass);
        }
        header("Location: " . BASE_URL);
    }
    public function showLoginForm() {
        $this->view->displayLoginForm();
    }
    public function loginUser() {
        if (
            !isset($_POST['username']) ||
            empty($_POST['username'])
        ) {
            return $this->authView->authError('You must write your username');
        }
        if (
            !isset($_POST['password']) ||
            empty($_POST['password'])
        ) {
            return $this->authView->authError('You must write your password');
        }

        $user = $this->model->getUser($_POST['username']);

        if (
            isset($user) &&
            $user != null &&
            password_verify($_POST['password'], $user->user_password)
        ) {
            session_start();
            $_SESSION['userId'] = $user->user_id;
            $_SESSION['username'] = $user->user_username;

            header("Location: " . BASE_URL);
        } else {
            $this->authView->authError('You could not login into your account. Please, try again.');
        }
    }
    public function logoutUser() {
        session_start();
        session_destroy();
        header("Location: " . BASE_URL);
    }

    function sessionVerify($data) {
        session_start();
        if(isset($_SESSION['userId'])) {
            return "block";
        } else {
            return ;
            die();
        }
    }
}