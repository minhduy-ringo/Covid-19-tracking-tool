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
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
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