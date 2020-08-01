<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'api/objects/session.php';

    class SessionController {
        private $db;
        private $requestMethod;
        private $data;
        
        public function __construct($db, $requestMethod, $data)
        {
            $this->db = $db;
            $this->requestMethod = $requestMethod;
            $this->data = $data;

            $this->db = new Session($db);
        }

        public function processRequest()
        {
                switch ($this->requestMethod) {
                case 'GET':
                    $response = $this->validateSession();
                    break;
                case 'POST':
                    $response = $this->saveSession();
                    break;
                default:
                    $response = $this->notFoundResponse();
                    break;
            }

            header($response['status_code_header']);
            if (isset($response['body'])) 
                echo $response['body'];
        }

        public function saveSession()
        {
            $result = $this->db->saveSession(
                            $this->data['sessionid'],
                            $this->data['userid'],
                            $this->data['username'],
                            $this->data['expirationdate']
            );
            if($result == true)
            {
                $response['status_code_header'] = 'HTTP/1.1 200 OK';
            }
            else
            {
                $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
                $response['body'] = $result;
            }
            return $response;
        }

        public function validateSession()
        {
            $result = $this->db->validateSession($this->data['sessionid']);
            if($result)
            {
                $response['status_code_header'] = 'HTTP/1.1 200 OK';
            }
            else
            {
                $response['status_code_header'] = 'HTTP/1.1 400 Bad Request';
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