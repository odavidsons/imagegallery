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
        if (!isset($vect)) {
            echo pg_last_error($this->conn);
            $vect = array();
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
    Get the stats of an image by it's ID
    <integer id
    >object
    */
    function getImageStats($imgId) {
        $query = "SELECT * FROM imagestats WHERE imageid = '".$imgId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getImageStats()";
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
    Get the favourited images of an user by their username
    <string username
    >object
    */
    function getUserFavouriteImages($username) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$_SESSION['username']."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "SELECT * FROM images i INNER JOIN userimagefavourites u ON u.imageid = i.id WHERE u.userid = $userId";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getUserFavouriteImages()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /*
    Get a user vote on an image by the image ID
    <integer imgId
    >object
    */
    function getUserImageVote($imgId) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$_SESSION['username']."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "SELECT * FROM userimagevotes WHERE userid = '".$userId."' AND imageid = '".$imgId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getUserImageVote()";
            exit;
        }
        return ($this->parseResult($result));
    }

    /*
    Get a user image favourite vote by the image ID
    <integer imgId
    >object
    */
    function getUserImageFavourite($imgId) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$_SESSION['username']."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "SELECT * FROM userimagefavourites WHERE userid = '".$userId."' AND imageid = '".$imgId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function getUserImageVote()";
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

        //Insert new entry for image stats in DB
        $imgstatsid = $this->insertImageStats($imgId);
        if (!isset($imgstatsid)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertImage()";
            exit;
        }

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
    Insert a new entry for image stats, pointing it to an image id
    <integer imgId
    >integer imgstatsId
    */
    function insertImageStats($imgId) {
        $query = "INSERT INTO imagestats (imageid) VALUES ('".$imgId."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertImageStats()";
            exit;
        }
        $result = pg_query($this->conn, "SELECT MAX(id) FROM images");
        $row = pg_fetch_row($result, 0);
        $imgstatsId = $row[0];
        return $imgstatsId;
    }

    /*
    Insert a user vote on an image (like, dislike,favourite)
    <string username
    <integer imageid
    >integer voteId
    */
    function insertUserImageVote($username,$imageId,$type) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$username."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "INSERT INTO userimagevotes (userid,imageid,type) VALUES ('".$userId."','".$imageId."','".$type."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertUserImageVote()";
            exit;
        }
        return true;
    }

    /*
    Insert an image favourite vote by a user
    <string username
    <integer imageId
    >boolean
    */
    function insertUserImageFavourite($username,$imageId) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$username."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "INSERT INTO userimagefavourites (userid,imageid) VALUES ('".$userId."','".$imageId."')";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function insertUserImageFavourite()";
            exit;
        }
        return true;
    }

    /*
    Add/Remove or switch an image vote by it's ID and type (like, dislike, favourite)
    <integer imgId
    <string type
    >boolean
    */
    function addImageVote($imgId,$type) {
        //Get the data of the previous vote on this image by this user
        $previousVote = $this->getUserImageVote($imgId);
        //Get the current stats of the image
        $obj_imagestats = $this->getImageStats($imgId);
        switch ($type) {
            case 'like':
                //Check if user has already voted on this image
                if (count($previousVote)>0 && $previousVote[0]->type == 'dislike') {
                    //Remove the dislike and add a like to the image stats. Update the user vote entry
                    $imageVote = $this->updateImageStats($imgId,($obj_imagestats[0]->likes + 1),($obj_imagestats[0]->dislikes - 1),$obj_imagestats[0]->favourites);
                    $updateVote = $this->updateUserImageVote($imgId,'like');
                    $returnMessage = "Vote changed!";
                } elseif (count($previousVote)>0 && $previousVote[0]->type == 'like') {
                    //If there already is a like, remove it
                    $imageVote = $this->updateImageStats($imgId,($obj_imagestats[0]->likes - 1),$obj_imagestats[0]->dislikes,$obj_imagestats[0]->favourites);
                    $updateVote = $this->deleteUserImageVote($imgId);
                    $returnMessage = "Like removed!";
                } elseif (count($previousVote)==0) {
                    //Add a like to the image stats and a new user vote entry
                    $imageVote = $this->updateImageStats($imgId,($obj_imagestats[0]->likes + 1),($obj_imagestats[0]->dislikes),$obj_imagestats[0]->favourites);
                    $addUserVote = $this->insertUserImageVote($_SESSION['username'],$imgId,'like');
                    $returnMessage = "Image liked!";
                }
            break;
            case 'dislike':
                //Check if user has already voted on this image
                if (count($previousVote)>0 && $previousVote[0]->type == 'like') {
                    //Remove the like and add a dislike to the image stats. Update the user vote entry
                    $imageVote = $this->updateImageStats($imgId,($obj_imagestats[0]->likes - 1),($obj_imagestats[0]->dislikes + 1),$obj_imagestats[0]->favourites);
                    $updateVote = $this->updateUserImageVote($imgId,'dislike');
                    $returnMessage = "Vote changed!";
                } elseif (count($previousVote)>0 && $previousVote[0]->type == 'dislike') {
                    //If there already is a dislike, remove it
                    $imageVote = $this->updateImageStats($imgId,$obj_imagestats[0]->likes,($obj_imagestats[0]->dislikes - 1),$obj_imagestats[0]->favourites);
                    $updateVote = $this->deleteUserImageVote($imgId);
                    $returnMessage = "Dislike removed!";
                } elseif (count($previousVote)==0) {
                    //Add a like to the image stats and a new user vote entry
                    $imageVote = $this->updateImageStats($imgId,$obj_imagestats[0]->likes,($obj_imagestats[0]->dislikes + 1),$obj_imagestats[0]->favourites);
                    $addUserVote = $this->insertUserImageVote($_SESSION['username'],$imgId,'dislike');
                    $returnMessage = "Image disliked!";
                }
            break;
            default:
            break;
        }
        if (!isset($returnMessage)) {
            echo pg_last_error($this->conn);
            echo "Error in function addImageVote()";
            exit;
        }
        return $returnMessage;
    }

    /*
    Add/remove an image favourite by an user
    */
    function addImageFavourite($imgId) {
        //Check if the user has already favourited this image
        $previousFavourite = $this->getUserImageFavourite($imgId);
        //Get the current stats of the image
        $obj_imagestats = $this->getImageStats($imgId);
        if (count($previousFavourite)>0) {
            //Remove the image favourite
            $imageFavourite = $this->deleteUserImageFavourite($_SESSION['username'],$imgId);
            $imageVote = $this->updateImageStats($imgId,$obj_imagestats[0]->likes,$obj_imagestats[0]->dislikes,($obj_imagestats[0]->favourites - 1));
            $returnMessage = "Removed from favourites!";
        } else {
            //Add the image favourite
            $imageFavourite = $this->insertUserImageFavourite($_SESSION['username'],$imgId);
            $imageVote = $this->updateImageStats($imgId,$obj_imagestats[0]->likes,$obj_imagestats[0]->dislikes,($obj_imagestats[0]->favourites + 1));
            $returnMessage = "Added to favourites!";
        }
        if (!isset($returnMessage)) {
            echo pg_last_error($this->conn);
            echo "Error in function addImageFavourite()";
            exit;
        }
        return $returnMessage;
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
    Update the stats of an image
    <integer id
    <integer likes
    <integer dislikes
    <integer favourites
    >boolean
    */
    function updateImageStats($id,$likes,$dislikes,$favourites) {
        $query = "UPDATE imagestats SET likes = '".$likes."',dislikes = '".$dislikes."',favourites = '".$favourites."' WHERE imageid = '".$id."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function updateImageStats()";
            exit;
        }
        return true;
    }

    /*
    Update a user vote on an image by the image ID
    <ingeger imgId
    <string type
    >boolean
    */
    function updateUserImageVote($imgId,$type) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$_SESSION['username']."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "UPDATE userimagevotes SET type = '".$type."' WHERE userid = '".$userId."' AND imageid = '".$imgId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function updateUserImageVote()";
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
    Delete a user vote on an image by the image ID
    <integer imgId
    >boolean
    */
    function deleteUserImageVote($imgId) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$_SESSION['username']."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "DELETE FROM userimagevotes WHERE userid = '".$userId."' AND imageid = '".$imgId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function deleteUserImageVote()";
            exit;
        }
        return true;
    }

    /*
    Remove a user image favourite vote by the image ID
    */
    function deleteUserImageFavourite($username,$imgId) {
        //Get the user's ID
        $result = pg_query($this->conn, "SELECT id FROM userinfo WHERE username = '".$_SESSION['username']."'");
        $row = pg_fetch_row($result, 0);
        $userId = $row[0];

        $query = "DELETE FROM userimagefavourites WHERE userid = '".$userId."' AND imageid = '".$imgId."'";
        $result = pg_query($this->conn, $query);
        if (!isset($result)) {
            echo pg_last_error($this->conn);
            echo "Error in function deleteUserImageFavourite()";
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