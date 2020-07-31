<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'api/objects/authentication.php';

    class AuthenticationController {
        private $db;
        private $requestMethod;
        private $username;
        private $password;
        private $ipAdress;
        
        public function __construct($db, $requestMethod, $username, $password, $ipAdress)
        {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->username = $username;
            $this->password = $password;
            $this->ipAdress = $ipAdress;
            $this->db = new Authentication($db);
        }

        public function processRequest()
        {
                switch ($this->requestMethod) {
                case 'GET':
                    $response = $this->loginAuthentication();
                    break;
                default:
                    $response = $this->notFoundResponse();
                    break;
            }

            header($response['status_code_header']);
            if ($response['body']) 
                echo $response['body'];
        }

        private function loginAuthentication()
        {
            $result = $this->db->login($this->username, $this->password, $this->ipAdress);
            $response['body'] = json_encode($result);
            if(array_key_exists('ERROR', $result))
            {
                $response['status_code_header'] = 'HTTP/1.1 403 Forbidden';
            }
            else
            {
                $response['status_code_header'] = 'HTTP/1.1 200 OK';
            }
            return $response;
        }

        private function notFoundResponse()
        {
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = null;
            return $response;
        }
    }
?>