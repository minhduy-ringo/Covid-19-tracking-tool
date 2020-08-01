<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'api/objects/user.php';

    class UserController {
        private $db;
        private $requestMethod;
        private $data;

        public function __construct($db, $requestMethod, $data)
        {
            $this->db = new User($db);
            $this->requestMethod = $requestMethod;
            
            
            if(count($data) == 6)
            {
                $data['password'] = '';
            }
            if(count($data) != 7)
            {
                header('HTTP/1.1 400 Bad Request');
                $response = "ERROR: USER_CREATE_ERROR_BLANK";
                echo json_encode($response);
                exit();
            }
            $this->data = $data;
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
                                    $this->data["name"],
                                    $this->data["sex"],
                                    $this->data["address"],
                                    $this->data["identity"],
                                    $this->data["phone"],
                                    $this->data["email"],
                                    $this->data["password"]
                                );
            if($result)
            {
                $response['body'] = json_encode($result);
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