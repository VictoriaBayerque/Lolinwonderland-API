<?php

class UserView {

    private $user = null;

    public function displayRegisterForm() {
        require 'templates/forms/registerform.phtml';
    }
    public function displayLoginForm() {
        require 'templates/forms/loginform.phtml';
    }
    
}
