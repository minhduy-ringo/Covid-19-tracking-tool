<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "www/ulti/ulti.php";

    httpsRedirect();

    if(isset($_SERVER['REQUEST_URI']))
    {
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $query = explode('&', $query);
        
        $username = explode('=', $query[0]);
        $password = explode('=', $query[1]);
        $ipAdress = $_SERVER['REMOTE_ADDR'];

        $data = [
            "username"  => $username[1],
            "password"  => $password[1],
            "ipAddress" => $ipAdress
        ];

        $response = callApi('GET', 'auth', $data);

        if(isset($response['UserId']))
        {
            regenerateSession($response['UserId'], $username[1]);
            setcookie('sessionId', session_id(), time() + 60 * 60, "/", "", true, true);

            echo "success";
        }
        else if(isset($response['ERROR']))
        {
            echo $response['ERROR'];
        }
    }
?>