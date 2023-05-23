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
        return $vect;
    }

    /* 
    Get all images uploaded in the database
    >object 
    */
    function getImages() {
        $query = "SELECT * FROM images";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getImages()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /* 
    Get the data of an image by it's ID
    <integer id
    >object 
    */
    function getImageById($id) {
        $query = "SELECT * FROM images WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getImageById()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /* 
    Get all the images uploaded by a given user
    <string username
    >object 
    */
    function getImagesByUser($username) {
        $query = "SELECT * FROM images WHERE uploaded_by = '".$username."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getImagesByUser()";
            exit;
        }
        return ($this->parseResult($result));
    }


    /* 
    Get all the image categories in the database
    >object 
    */
    function getCategories() {
        $query = "SELECT * FROM categories";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getCategories()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /* 
    Get an image category by it's ID
    <integer id
    >object 
    */
    function getCategoryById($id) {
        $query = "SELECT * FROM categories WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getCategoryById()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /*
    Get all the existing logs of all types
    >object
    */
    function getLogs() {
        $query = "SELECT * FROM logs ORDER BY date DESC";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getLogs()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /*
    Get all the existing logs of a given type (ex: upload logs)
    <string type
    >object
    */
    function getLogsByType($type) {
        $query = "SELECT * FROM logs WHERE type = '".$type."' ORDER BY date DESC";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getLogsByType()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /* 
    Insert a new image
    <string name
    <string path
    <string description
    <string author
    <string category
    >integer imgId
    */
    function insertImage($name,$path,$description,$author,$category) {
        //Generate an image insertion log
        $this->insertLog('insert_image','Name:'.$name.'Description:'.$description.'Path:'.$path.'Category:'.$category.'',$_SESSION['username']);

        $query = "INSERT INTO images (name,path,description,uploaded_by,category) VALUES ('".$name."','".$path."','".$description."','".$author."','".$category."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertImage()";
            exit;
        }
        $result = pg_query($this->conn, "SELECT MAX(id) FROM images");
        $row = pg_fetch_row($result, 0);
        $imgId = $row[0];
        return ($imgId);
    }

    /*
    Insert a new image category
    <string name
    >integer id
    */
    function insertCategory($name) {
        //Generate a category insertion log
        $this->insertLog('insert_category','Name:'.$name.'',$_SESSION['username']);

        $query = "INSERT INTO categories (name) VALUES ('".$name."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertCategory()";
            exit;
        }
        $result = pg_query($this->conn, "SELECT MAX(id) FROM categories");
        $row = pg_fetch_row($result, 0);
        $Id = $row[0];
        return ($Id);
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
    Update an existing image
    <integer id
    <string name
    <string description
    <string category
    >boolean
    */
    function updateImage($id,$name,$description,$category) {
        //Generate an image update log
        $obj_old_img = $this->getImageById($id);
        $this->insertLog('update_image','Old name:'.$obj_old_img[0]->name.' | New name:'.$name.' | Old description:'.$obj_old_img[0]->description.' | New description:'.$description.' | Old category:'.$obj_old_img[0]->category.' | New category:'.$category.' | Path:'.$obj_old_img[0]->path,$_SESSION['username']);

        //Execute the update query
        $query = "UPDATE images SET name = '".$name."',description = '".$description."',category = '".$category."' WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function updateImage()";
            exit;
        }
        return true;
    }

    /* 
    Delete an image by it's ID
    <integer id
    >boolean
    */
    function deleteImage($id) {
        //Generate an image deletion log
        $obj_deleted_img = $this->getImageById($id);
        $this->insertLog('delete_image',$obj_deleted_img[0]->path,$_SESSION['username']);

        //Get the image path and delete the file from the website
        $query = "SELECT path FROM images WHERE id ='".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function deleteImage()";
            exit;
        }
        $row = pg_fetch_row($result, 0);
        $delete_file = unlink(''.$row[0].'');
        //If file unlink fails
        if ($delete_file == false) {
            echo pg_last_error($this->conn);
            echo "Error in function deleteImage()";
            exit;
        }

        //Delete image entry from DB
        $query = "DELETE FROM images WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function deleteImage()";
            exit;
        }

        return true;
    }

    /*
    Delete a category by it's ID
    <integer id
    >boolean
    */
    function deleteCategory($id) {
         //Generate a category deletion log
         $obj_old_category = $this->getCategoryById($id);
         $this->insertLog('delete_category','Name:'.$obj_old_category[0]->name.'',$_SESSION['username']);

        $query = "DELETE FROM categories WHERE id = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function deleteCategory()";
            exit;
        }
        return true;
    }
}
?>