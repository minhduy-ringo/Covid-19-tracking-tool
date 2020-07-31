<?php
    class DatabaseConnector {

        private $conn;

        private $dsn = 'mysql:dbname=udpt; host=127.0.0.1:3308';
        private $username = "root";
        private $password = "";

        public function __construct()
        {
            try
            {
                $this->conn = new PDO($this->dsn, $this->username, $this->password);
            }
            catch (PDOException $e)
            {
                echo 'Connection failed: ' .$e->getMessage();
            }
        }

        public function getConnection()
        {
            return $this->conn;
        }
    }
?>