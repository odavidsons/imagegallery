<?php 
class dbconnect {

    public $conn;

    function __construct() {
        $dbhost = 'localhost';
        $dbusername = 'postgres';
        $dbport = '5432';
        $dbpassword = 'postgres';
        $dbname = 'imagegallery';

        $this->conn = pg_connect("host=$dbhost port=$dbport dbname=$dbname user=$dbusername password=$dbpassword");

        if (!isset($this->conn)){
            pg_last_error("Error connecting to database");
            echo 'Error connecting to database';
            exit;
        }
        pg_set_client_encoding($this->conn, "UTF-8");
    }
}
?>