<?php
require_once 'config.php';

    class AuthHelper {
        
        public function getToken($user) {

            $token = $this->createToken($user);
            $data = [
                'user_id' => $user->user_id,
                'username' => $user->user_username,
                'password' => $user->user_password,
                'user_token' => $token ];
    
            return $data;
        }

        public function b64URLencode($data) {
            $newData = rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
            return $newData;
        }

        public function getAuthHeader() {
            $header = "";
            if(isset($_SERVER['HTTP_AUTHORIZATION'])) {
                $header = $_SERVER['HTTP_AUTHORIZATION'];
            }
            if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $header = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            }
            return $header;
        }

        public function createToken($payload) {
            $header = array(
                'alg' => 'HS256',
                'typ' => 'JWT'
            );

            $header = $this->b64URLencode(json_encode($header));
            $payload = $this->b64URLencode(json_encode($payload));
            
            $signature = hash_hmac('SHA256', "$header.$payload", JWT_KEY, true);
            $signature = $this->b64URLencode($signature);

            $token = "$header.$payload.$signature";

            return $token;
        }

        public function verifyToken($token) {
            $token = explode('.', $token);
            $header = $token[0];
            $payload = $token[1];
            $signature = $token[2];

            $newSignature = hash_hmac('SHA256', "$header.$payload", JWT_KEY, true);
            $newSignature = $this->b64URLencode($newSignature);

            if($signature != $newSignature) {
                var_dump('Signatures are different');
                return false;
            }

            $payload = json_decode(base64_decode($payload));

            return $payload;
        }

        public function currentUserData() {
            $authHeader = $this->getAuthHeader();

            if(empty($authHeader)) {
                var_dump('Token data is empty');
                return false;
            }

            $authHeader = explode(' ', $authHeader);
            
            if($authHeader[0] != 'Bearer') {
                var_dump('It is not the correct authorization header.');
                var_dump($authHeader);
                return false;
            } else if(!isset($authHeader[1]) || empty($authHeader[1])) {
                var_dump('Missing token.');
                return false;
            }

            $token = $authHeader[1];
            return $this->verifyToken($token);
        }

    }