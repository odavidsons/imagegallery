<?php 
class dbconnect {

    public $conn;

    function __construct() {

        $dbhost = $GLOBALS['_dbhost'];
        $dbusername = $GLOBALS['_dbusername'];
        $dbport = $GLOBALS['_dbport'];
        $dbpassword = $GLOBALS['_dbpassword'];
        $dbname = $GLOBALS['_dbname'];

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