<?php
    require_once 'config/database.php';
    require_once 'controllers/authenticationController.php';
    require_once 'controllers/userController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = explode('/', $uri);

    $requestMethod = $_SERVER["REQUEST_METHOD"];

    if($requestMethod == 'OPTIONS')
    {
        header('HTTP/1.1 200 OK');
        exit();
    }
    
    $db = (new DatabaseConnector())->getConnection();

    switch ($uri[3])
    {
        case 'auth':
            $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
            $query = explode('&', $query);

            $username = explode('=', $query[0]);
            $password = explode('=', $query[1]);
            $ipAdress = explode('=', $query[2]);

            $controller = new AuthenticationController($db, $requestMethod, $username[1], $password[1], $ipAdress[1]);
            $controller->processRequest();
            break;
        case 'user':
            $data = file_get_contents("php://input");
            $userObject = json_decode($data);

            $controller = new UserController($db, $requestMethod, $userObject);
            $controller->processRequest();
            break;
        case 'session':
            $data = file_get_contents("php://input");
            $sessionObject = json_decode($data);

            print_r($sessionObject);

            break;
        default:
            header("HTTP/1.1 404 Not Found");
            exit();
    }

    
?>