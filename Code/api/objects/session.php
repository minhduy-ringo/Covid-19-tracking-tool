<?php
    Class Session {
        private $conn;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        /**
         * Insert a new user and create new account. \
         * Password will be default to identityCode if input password is blank.
         * 
         * @param   string  $sessionId
         * @param   string  $userId
         * @param   string  $userName
         * @param   string  $expirationDate UNIX time
         * 
         */
        public function saveSession($sessionId, $userId, $userName, $expirationDate)
        {
            try
            {
                $sql = "INSERT INTO `session`
                        VALUES (:SessionId, :UserId, :UserName, FROM_UNIXTIME(:ExpirationDate))";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':SessionId', $sessionId, PDO::PARAM_STR);
                $stmt->bindValue(':UserId', $userId, PDO::PARAM_INT);
                $stmt->bindValue(':UserName', $userName, PDO::PARAM_STR);
                $stmt->bindValue(':ExpirationDate', $expirationDate, PDO::PARAM_STR);

                $result = $stmt->execute();
                return $result;
            }
            catch (PDOException $e)
            {
                return $e->getMessage();
            }
        }

        /**
         * Check if session id exist in Session table
         * 
         * @param   string  $sessionId
         * 
         * @return  TRUE if sessionId 
         */
        public function validateSession($sessionId)
        {
            try
            {
                $sql = "SELECT EXISTS ( SELECT * FROM `session` WHERE `SessionId` = :SessionId) AS RESULT";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':SessionId', $sessionId, PDO::PARAM_STR);

                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                return $result['RESULT'];
            }
            catch (PDOException $e)
            {
                echo $e->getMessage();
                die("Error occured: " .$e->getMessage());
            }
        }
    }

?>