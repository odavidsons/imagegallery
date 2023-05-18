<?php
//If form is submitted, login to a user session
$username = $_POST['username'];
$password = $_POST['password'];
$error = "";
if (isset($username) && isset($password)) {
    $query = "SELECT * FROM userinfo WHERE username = '".$username."' AND password = '".$password."'";
    $result = pg_query($dbconnect->conn, $query);
    $rows = pg_num_rows($result);
    if ($rows == 0) {
        $error = "Your login credentials are incorrect";
        header('index.php?page=login&error='.$error);
    } else {
        session_start();
        $_SESSION['username'] = $username;
        header('index.php?page=home&login=success');
        ?>
        <script type="text/javascript">
			location = "index.php?page=home&login=success"
	    </script>
        <?php
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
  <button type="submit" class="btn btn-dark">Register</button>
</form>
</div>