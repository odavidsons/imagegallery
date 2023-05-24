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

    /* 
    Parse a query result into an object
    <result
    >object 
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

    /* 
    Get the ID of a user by it's username
    <string username
    >integer result row
    */
    function getUserId($username) {
        $query = "SELECT id FROM userinfo WHERE username = '".$username."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getUserId()";
            exit;
        }
        $row = pg_fetch_row($result, 0);
        $id = $row[0];
        return ($id);
    }

    /* 
    Get all data from a user by it's ID
    <integer id
    >object 
    */
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

    /* 
    Get the stats of a given user by it's ID
    <integer id
    >object 
    */
    function getStatsByUserId($id) {
        $query = "SELECT * FROM userstats WHERE userid = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getStatsByUserId()";
            exit;
        }
        return ($this->parseResult($result));
    }


    /* 
    Get the type of a given user by it's username
    <string username
    >integer result row
    */
    function getUserType($username) {
        $query = "SELECT type FROM userinfo WHERE username = '".$username."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getUserType()";
            exit;
        }
        $row = pg_fetch_row($result, 0);
        $type = $row[0];
        return ($type);
    }

    /* 
    Insert a new user
    <string username
    <string password
    >integer userId
    */
    function insertUser($username,$password) {
        //Generate a user insertion log
        $this->insertLog('insert_user','Username:'.$username.'',$_SESSION['username']);

        $query = "INSERT INTO userinfo (username,password) VALUES ('".$username."','".password_hash($password,PASSWORD_BCRYPT)."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertUser()";
            exit;
        }
        $result = pg_query($this->conn, "SELECT max(id) FROM userinfo");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];
        
        //Create entry for user stats in DB
        $statsId = $this->insertUserStats($userId);
        if (!isset($statsId)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertUserStats()";
            exit;
        }
        return $userId;
    }

    /* 
    Insert default stats for a new user
    <integer id
    >integer statsId
    */
    function insertUserStats($userId) {
        //Generate a user insertion log
        $obj_new_user = $this->getUserById($userId);
        $this->insertLog('insert_stats','Username:'.$obj_new_user[0]->username.'',$_SESSION['username']);

        $query = "INSERT INTO userstats (userid) VALUES ('".$userId."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertUserStats()";
            exit;
        }
        $result = pg_query($this->conn, "SELECT max(id) FROM userstats");
        $row = pg_fetch_row($result, 0);
        $statsId = $row[0];
        return $statsId;
    }

    /*
    Insert a new operation log
    <string type
    <string name
    <string username
    >integer logId
    */
    function insertLog($type,$name,$username) {
        $query = "INSERT INTO logs (type,name,username) VALUES ('".$type."','".$name."','".$username."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertLog()";
            exit;
        }
        $result = pg_query($this->conn, "SELECT MAX(id) FROM logs");
        $row = pg_fetch_row($result, 0);
        $logId = $row[0];
        return ($logId);
    }

    /* 
    Update the stats of a user by it's ID
    <integer id
    <integer total
    <integer active
    >boolean
    */
    function updateUSerStats($userId,$total,$active) {
        //Generate a stats update log
        $obj_user = $this->getUserById($userId);
        $obj_user_stats = $this->getStatsByUserId($userId);
        $this->insertLog('update_stats','Username:'.$obj_user[0]->username.' | Old total:'.$obj_user_stats[0]->total.' | New total:'.$total.'Old active:'.$obj_user_stats[0]->active.' | New active:'.$active.'',$_SESSION['username']);
        
        $query = "UPDATE userstats SET total_uploaded = '".$total."',active_uploaded = '".$active."' WHERE userid = '".$userId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function updateUSerStats()";
            exit;
        }
        return true;
    }

    /* 
    Delete a user
    <integer id
    >boolean
    */
    function deleteUser($userId) {
        //Generate a user deletion log
        $obj_old_user_stats = $this->getStatsByUserId($userId);
        $obj_old_user = $this->getUserById($userId);
        $this->insertLog('delete_user','Username:'.$obj_old_user[0]->username.'Total images:'.$obj_old_user_stats[0]->total.'Active images:'.$obj_old_user_stats[0]->active.'',$_SESSION['username']);

        $query = "DELETE FROM userinfo WHERE id = '".$userId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function deleteUser()";
            exit;
        }
        return true;
    }

}
?>