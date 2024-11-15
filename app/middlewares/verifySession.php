<?php
    function verifySession($user) {
        session_start();
        if (isset($_SESSION['userId'])) {
            $user->loggeduser = new stdClass();
            $user->loggeduser->user_id = $_SESSION['userId'];
            $user->loggeduser->user_username = $_SESSION['username'];
            return $user->loggeduser;
        } else {
            echo 'The user could have not been verified.';
            die();
        }
    }