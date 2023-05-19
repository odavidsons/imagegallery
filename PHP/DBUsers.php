<?php
class DBUsers{
    public $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
        if (!isset($this->conn)) {
            echo "Error getting the connection variable";
            exit;
        }
    }

    /*Parse a query result into an object
    @param result
    @returns object
    */
    function parseResult($result) {
        $num_rows = pg_num_rows($result);
        unset($vect);
        for ($i = 0; $i < $num_rows; $i++) {
            $vect[$i] = pg_fetch_object($result, $i);
        }
        if (!isset($vect)) {
            echo pg_last_error($this->conn);
            echo "Error in function parseResult()";
            exit;
        }
        return $vect;
    }

    function getUserById($id) {
        $query = "SELECT * FROM userinfo WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getUserById()";
            exit;
        }
        return ($this->parseResult($result));
    }

    function insertUser($username,$password) {
        $query = "INSERT INTO userinfo (username,password) VALUES ('".$username."','".$password."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertUser()";
            exit;
        }
        $result = pg_query($this->conn, "SELECT max(id) FROM userinfo");
        $row = pg_fetch_row($result, 0);
        $id = $row[0];
        return $id;
    }

}
?>