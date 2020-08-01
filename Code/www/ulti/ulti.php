<?php
    $api_url = "http://udpt/api/api.php/";
    $domain_url = 'https://udpt/www/';
    /**
     * Redirect user to HTTPS
     */
    function httpsRedirect()
    {
        if($_SERVER['HTTPS'] != "on")
        {
            $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header("Location: $redirect");
        }
    }
    /**
     * 
     */
    function regenerateSession($userId, $userName)
    {
        // New session ID is required to set proper session ID
        // when session ID is not set due to unstable network.
        $new_session_id = session_create_id();
        $_SESSION['new_session_id'] = $new_session_id;
        
        // Set destroy timestamp
        $_SESSION['destroyed'] = time();
        
        // Write and close current session;
        session_commit();

        // Start session with new session ID
        session_id($new_session_id);
        session_start();

        // Set User Id
        $_SESSION['userId'] = $userId;
        $_SESSION['userName'] = $userName;
        
        // Session expire after 1 hour
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $_SESSION['expire'] = time() + (60 * 60);
        
        // New session does not need them
        unset($_SESSION['destroyed']);
        unset($_SESSION['new_session_id']);
    }
    /**
     * 
     */
    function checkSession($sessionId)
    {
        $response = callApi('GET', 'session', ['sessionid' => $sessionId]);

        if($response['code'] == '200')
            return true;
        else
            return false;
    }
    /**
     * Send data to specific API endpoint
     * 
     * @param   string  $method REST methods
     * @param   string  $endpoint specific API endpoint 
     * 
     *          Ex: auth / session
     * @param   array   $data
     * 
     * @return  array   <code> array (
     *  'code'  =>  http response code
     *  'data'  =>  data array); <code>
     */
    function callApi($method, $endpoint, $data)
    {
        $ch = curl_init();

        switch ($method) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if ($data)
                {
                    $data = json_encode($data, JSON_THROW_ON_ERROR);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_PUT, true);
                if ($data)
                {
                    $data = json_encode($data, JSON_THROW_ON_ERROR);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                }
                break;
            default:
                $endpoint = $endpoint . "?" . http_build_query($data);
                break;
        }

        // OPTIONS:
        curl_setopt($ch, CURLOPT_URL, $GLOBALS['api_url'] . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        // echo $GLOBALS['api_url'] . $endpoint;
        // print_r($data);

        $response = json_decode(curl_exec($ch), true);
        $httpCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        curl_close($ch);

        if($httpCode == '404')
        {
            die('Connection to API failed');
        }
        else
        {
            return ['code' => $httpCode, 'data' => $response];
        }
        
    }
?>