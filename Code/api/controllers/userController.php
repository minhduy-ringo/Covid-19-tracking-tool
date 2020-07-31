<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'api/objects/user.php';

    class UserController {
        private $db;
        private $userVars;
        private $requestMethod;

        public function __construct($db, $requestMethod, $userObject)
        {
            $this->db = new User($db);
            $this->requestMethod = $requestMethod;
            $this->userVars = get_object_vars($userObject);

            if(count($this->userVars) != 7)
            {
                header('HTTP/1.1 400 Bad Request');
                echo 'USER_CREATE_ERROR_BLANK';
                exit();
            }
        }

        public function processRequest() {
            switch($this->requestMethod) {
                case 'GET':
                break;
                case 'POST':
                    $response = $this->createUser();
                    break;
                case 'UPDATE':
                break;
                case 'DELETE':
                break;
                default:
                    $response = $this->notFoundResponse();
                    break;
            }

            header($response['status_code_header']);
            if ($response['body']) 
                echo $response['body'];
        }

        private function createUser() {
            $result = $this->db->createNewUser(
                                    $this->userVars["name"],
                                    $this->userVars["sex"],
                                    $this->userVars["address"],
                                    $this->userVars["identity"],
                                    $this->userVars["phone"],
                                    $this->userVars["email"],
                                    $this->userVars["password"]
                                );
            $response['body'] = json_encode($result);
            if($response['body'] != '')
            {
                $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
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