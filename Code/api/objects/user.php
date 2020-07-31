<?php
    Class User {
        private $conn;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        /**
         * Insert a new user and create new account. \
         * Password will be default to identityCode if input password is blank.
         */
        public function createNewUser($name, $sex, $address, $identityCode, $phoneNumber, $email, $password = '')
        {
            try
            {
                $sql = "CALL `udpt`.`SP_CREATE_USER`(:name, :sex, :address, :identityCode, :phoneNumber, :email, :password)";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':name', $name, PDO::PARAM_STR);
                $stmt->bindValue(':sex', $sex, PDO::PARAM_STR);
                $stmt->bindValue(':address', $address, PDO::PARAM_STR);
                $stmt->bindValue(':identityCode', $identityCode, PDO::PARAM_STR);
                $stmt->bindValue(':phoneNumber', $phoneNumber, PDO::PARAM_STR);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->bindValue(':password', $password, PDO::PARAM_STR);

                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            }
            catch (PDOException $e)
            {
                die("Error occured: " .$e->getMessage());
            }
        }

    }

?>