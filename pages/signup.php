<?php

?>

<div class="signup_form">
<form action="index.php?page=signupAction" method="POST">
<h2>Signup</h2>
  <div class="mb-3">
    <label for="inputUsername" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="inputUsername" required>
  </div>
  <div class="mb-3">
    <label for="inputPassword" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="inputPassword" required>
  </div>
  <div id="formError" style="color:red;" class="form-text"><?php echo $error ?></div>
  <p>Already have an account? <a href="index.php?page=login">Login</a></p>
  <button type="submit" class="btn btn-dark">Register</button>
</form>
</div>