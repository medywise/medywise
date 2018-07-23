<?php 
    require_once('config.php');

    class Database
    {
        public $connection;

        public function __construct()
        {
            $this->openDatabaseConnection();
        }

        public function openDatabaseConnection()
        {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->connection->connect_errno) {
                die("Database Connection Failed" . mysqli_error());
            }
        }

        public function query($sql)
        {
            $result = mysqli_query($this->connection, $sql);
            $this->confirmQuery($result);
            return $result;
        }

        private function confirmQuery($result)
        {
            if (!$result) {
                die("Query Failed");
            }
        }

        public function insertId()
        {
            //Get the Last ID Inserted Over the Current DB Connection.
            return mysqli_insert_id($this->connection);
        }

        public function escapeString($string)
        {
            $escapedString =  mysqli_real_escape_string($this->connection, $string);
            return $escapedString;
        }


        //Start of helper functions.

        public function escape($string)
        {
            return mysqli_real_escape_string($this->connection, $string);
        }

        public function fetchArray($resultSet)
        {
            return mysqli_fetch_array($resultSet);
        }

        public function numRows($resultSet)
        {
            return mysqli_num_rows($resultSet);
        }

        public function affectedRows()
        {
            return mysqli_affected_rows($this->connection);
        }

        public function arrayShift($resultSet)
        {
            return array_shift($resultSet);
        }
    }
    $database = new Database();
