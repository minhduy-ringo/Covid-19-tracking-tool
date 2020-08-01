<?php
    require_once 'config/database.php';
    require_once 'controllers/authenticationController.php';
    require_once 'controllers/userController.php';
    require_once 'controllers/sessionController.php';

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

    // Check if data is sent throught JSON or URI
    $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    if($query)
    {
        $query = explode('&', $query);
        $data = [];
        foreach ($query as $key => $value) {
            $row = explode('=', $value);
            $data[$row[0]] = $row[1];
        }
    }
    else
    {
        $json = file_get_contents("php://input");
        if($json)
        {
            $data = get_object_vars(json_decode($json));
        }
        else
        {
            header('HTTP/1.1 400 Bad Request');
            exit();
        }
    }
    
    switch ($uri[3])
    {
        case 'auth':
            $controller = new AuthenticationController($db, $requestMethod, $data);
            $controller->processRequest();
            break;
        case 'user':
            $controller = new UserController($db, $requestMethod, $data);
            $controller->processRequest();
            break;
        case 'session':
            $controller = new SessionController($db, $requestMethod, $data);
            $controller->processRequest();
            break;
        default:
            header("HTTP/1.1 404 Not Found");
            exit();
    }
?>