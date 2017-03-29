<?php
/* login.php */
    session_start();
    $_SESSION['message'] = '';
    include 'db.php';

    //the form has been submitted with post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //echo "post" . '</br>';
      
  //define other variables with submitted values from $_POST
  $username = $mysqli->real_escape_string($_POST['username']);

  //md5 hash password for security
  $password = md5($_POST['password']);

  //look for entered user data in database
  $sql = "SELECT * FROM users ".
  "WHERE username = '$username' ";
                
  $result = $mysqli->query( $sql );
  
  if ( $result->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";
    //header("location: login.php");
  } else { // User exists
    $user = $result->fetch_assoc();
    if ( $password == $user['password'] ) {
        
      $_SESSION['avatar'] = $user['avatar'];
        
      // This is how we'll know the user is logged in
      $_SESSION['logged_in'] = true;
      $_SESSION['message'] = "Welcome back $username !";
      header("location: welcome.php");
    } else {
      $_SESSION['message'] = "You have entered wrong password, try again!";
      //header("location: error.php");
    }
}
}

?>
<link rel="stylesheet" href="form.css" type="text/css">
<div class="body-content">
  <div class="module">
    <h1>Login form</h1>
    <form class="form" action="login.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <div class="alert alert-error"><?php $_SESSION['message'] ?></div>
      <input type="text" placeholder="User Name" name="username" required />
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
      <input type="submit" value="Login" name="login" class="btn btn-block btn-primary" />
    </form>
  </div>
</div>