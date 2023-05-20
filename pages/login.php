<?php
//If form is submitted, login to a user session
$username = $_POST['username'];
$password = $_POST['password'];
$error = "";
if (isset($username) && isset($password)) {
    //Get hashed password from database
    $result = pg_query($dbconnect->conn, "SELECT password FROM userinfo WHERE username = '".$username."'");
    $row = pg_fetch_row($result, 0);
    $password_hash = $row[0];
    //If result is returned, it means the user exists
    if ($row == 0) {
      $error = "This user does not exist";
      header('index.php?page=login&error='.$error);
    } else {
      //Check if user credentials match
      if (password_verify($password,$password_hash) == false) {
          $error = "Your login credentials are incorrect";
          header('index.php?page=login&error='.$error);
      } else {
          session_start();
          $_SESSION['username'] = $username;
          $_SESSION['usertype'] = "0";
          header('index.php?page=home&login=success');
          ?>
          <script type="text/javascript">
        location = "index.php?page=home&login=success"
        </script>
          <?php
      }
    }
}
?>

<div class="login_form">
<form action="index.php?page=login" method="POST">
<h2>Login</h2>
  <div class="mb-3">
    <label for="inputUsername" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="inputUsername" required>
  </div>
  <div class="mb-3">
    <label for="inputPassword" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="inputPassword" required>
  </div>
  <div id="formError" style="color:red;" class="form-text"><?php echo $error ?></div>
  <button type="submit" class="btn btn-dark">Login</button>
</form>
</div>