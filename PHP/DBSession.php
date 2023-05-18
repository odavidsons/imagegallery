<?php
class DBSession {
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

    function getSessions() {
        $query = "SELECT * FROM sessions";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getSessions()";
            exit;
        }
        return ($this->parseResult($result));
    }

    function getSessionBySessionId($id) {
        $query = "SELECT * FROM sessions WHERE session_id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getSessionBySessionId()";
            exit;
        }
        return ($this->parseResult($result));
    }
}
?>