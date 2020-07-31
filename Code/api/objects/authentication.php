<?php
    class Authentication {
        private $conn;
        private $table_name = "userauthentication";

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function login($username, $password, $ipAdress)
        {
            try
            {
                $sql = "Call SP_LOGIN(:username, :password, :ipAdress)";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->bindValue(':password', $password, PDO::PARAM_LOB);
                $stmt->bindValue(':ipAdress', $ipAdress, PDO::PARAM_STR);

                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            catch (PDOException $e)
            {
                die("Error occured: " .$e->getMessage());
            }
        }
    }
?>