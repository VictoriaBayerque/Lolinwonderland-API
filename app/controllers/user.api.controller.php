<?php
include_once './app/models/user.model.php';
include_once './app/views/json.view.php';
include_once './helpers/auth.api.helper.php';

class UserController {

    private $model;
    private $view;
    private $authHelper;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new JSONView();
        $this->authHelper = new AuthHelper();
    }

    public function getPermissionWithToken($req, $res) {
        
        $basic = $this->authHelper->getAuthHeader();

        if (empty($basic)) {
            return $this->view->response('Missing authentication data', 401);
        }

        $basic = explode(' ', $basic);
        if ($basic[0] != "Basic") {
            return $this->view->response('Wrong authentication headers.', 401);
        }

        $userpass = base64_decode($basic[1]);
        $userpass = explode(':', $userpass);

        $userDB = $this->model->getUser($userpass[0]);

        if(!$userDB) {
            return $this->view->response('The user does not exist in the database', 404);
        }

        if (!password_verify($userpass[1], $userDB->user_password)) {
            return $this->view->response('The password is not correct. Please, try again', 401);
        }

        $data = $this->authHelper->getToken($userDB);
        $token = $data[2];

        return $this->view->response($token);
    }

    public function getSessionWithLogin($req, $res) {

        if (empty($req->body->user_username) || empty($req->body->user_password)) {
            return $this->view->response('Missing username or password.', 400);
        }

        $user = $req->body->user_username;
        $pass = $req->body->user_password;

        $userDB = $this->model->getUser($user);

        if(!$userDB) {
            return $this->view->response('The user does not exist in the database', 404);
        }

        if (!password_verify($pass, $userDB->user_password)) {
            return $this->view->response('The password is not correct. Please, try again', 401);
        }

        $data = $this->authHelper->getToken($userDB);
        //  

        return $this->view->response($data);
    }
}