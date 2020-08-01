<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . "www/ulti/ulti.php";

    httpsRedirect();

    if(isset($_SERVER['REQUEST_URI']))
    {
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        $query = explode('&', $query);
        
        $username = explode('=', $query[0]);
        $password = explode('=', $query[1]);
        $ipadress = $_SERVER['REMOTE_ADDR'];

        $data = [
            "username"  => $username[1],
            "password"  => $password[1],
            "ipaddress" => $ipadress
        ];

        // GET username and user id 
        $response = callApi('GET', 'auth', $data);
        
        // If returned response array has user id key
        if($response['code'] == '200' && count($response['data']))
        {
            regenerateSession($response['data']['UserId'], $response['data']['UserName']);
            setcookie('sessionId', session_id(), time() + 60 * 60, "/", "", true, true);

            $session = [
                'sessionid'         => session_id(),
                'userid'            => $_SESSION['userId'],
                'username'          => $_SESSION['userName'],
                'expirationdate'    => $_SESSION['expire']
            ];
            callApi('POST', 'session', $session);

            echo "success";
        }
        else if(isset($response['ERROR']))  // else print error code
        {
            echo $response['ERROR'];
        }
    }
?>