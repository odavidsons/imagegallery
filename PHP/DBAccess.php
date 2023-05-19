<?php
class DBAccess {
    private $conn;

    //Constructor
    function __construct($conn) {
        $this->conn = $conn;
        if (!isset($this->conn)) {
            echo pg_last_error($this->conn);
            exit;
        }
    }

    //Parse query result to an object
    function parseResult($result) {
        $num_rows = pg_num_rows($result);
        unset($vect);
        for ($i = 0; $i < $num_rows; $i++) {
            $vect[$i] = pg_fetch_object($result, $i);
        }
        return $vect;
    }

    //Get all upoaded images in database
    function getImages() {
        $query = "SELECT * FROM images";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            exit;
        }
        return ($this->parseResult($result));
    }

    function getImageById($id) {
        $query = "SELECT * FROM images WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            exit;
        }
        return ($this->parseResult($result));
    }

    function insertImage($name,$path,$description,$author) {
        $query = "INSERT INTO images (name,path,description,uploaded_by) VALUES ('".$name."','".$path."','".$description."','".$author."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            exit;
        }
        $result = pg_query($this->conn, "SELECT MAX(id) FROM images");
        $row = pg_fetch_row($result, 0);
        $imgId = $row[0];
        return ($imgId);
    }

    function deleteImage($id) {
        //Get the image path and delete the file from the website
        $query = "SELECT path FROM images WHERE id ='".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            exit;
        }
        $row = pg_fetch_row($result, 0);
        $delete_file = unlink(''.$row[0].'');
        //If file unlink fails
        if ($delete_file == false) {
            echo pg_last_error($this->conn);
            exit;
        }

        $query = "DELETE FROM images WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            exit;
        }
        return true;
    }
}
?>