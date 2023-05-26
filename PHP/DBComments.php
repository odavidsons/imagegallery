<?php
class DBComments {
    private $conn;

    //Constructor
    function __construct($conn) {
        $this->conn = $conn;
        if (!isset($this->conn)) {
            echo pg_last_error($this->conn);
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
            $vect = array();
        }
        return $vect;
    }

    /*
    Get all the comments of an image by it's ID
    <integer imgId
    >object
    */
    function getImageComments($imgId) {
        $query = "SELECT * FROM imagecomments WHERE imageid = '".$imgId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getImageComment()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /*
    Get the comments of an image made by a given user
    <integer imgId
    <string username
    >object
    */
    function getImageCommentsByUser($imgId,$username) {
        $query = "SELECT * FROM imagecomments WHERE imageid = '".$imgId."' AND username = '".$username."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getImageCommentsByUser()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /*
    Insert a comment by the user in the selected image by it's ID
    <integer imgId
    <string username
    <string text
    >boolean
    */
    function insertImageComment($imgId,$username,$text) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$_SESSION['username']."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "INSERT INTO imagecomments (userid,imageid,text,username) VALUES ('".$userId."','".$imgId."','".$text."','".$username."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getImageComment()";
            exit;
        }
        return true;
    }

    /*
    Delete a comment by it's ID
    <integer id
    >boolean
    */
    function deleteImageComment($id) {
        $query = "DELETE FROM imagecomments WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function deleteImageComment()";
            exit;
        }
        return true;
    }
}
?>