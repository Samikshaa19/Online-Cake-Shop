<?php
session_start();
require_once('connect.php');

if(isset($_SESSION['username']) & !empty($_SESSION['username'])){
  //$smsg = "Already Logged In" . $_SESSION['username'];
  header('location: members/index.php');
}

if(isset($_POST) & !empty($_POST)){
  $username = mysqli_real_escape_string($connection, $_POST['username']);
  $password = md5($_POST['password']);
  $sql = "SELECT * FROM `usermanagement` WHERE ";
  if(filter_var($username, FILTER_VALIDATE_EMAIL)){
    $sql .= "email='$username'";
  }else{
    $sql .= "username='$username'";
  }
  $sql .= " AND password='$password' AND active=1";
  $sql;
  $res = mysqli_query($connection, $sql);
  $count = mysqli_num_rows($res);

  if($count == 1){
    $_SESSION['username'] = $username;
    header('location: login.php');
  }else{
    $fmsg = "User does not exist";
  }
}
?>
<html>
<head>
<title>User Login Script in PHP & MySQL</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

<link rel="stylesheet" href="styles.css" >
<script   src="https://code.jquery.com/jquery-3.1.1.js" ></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
	<div class="container">
      <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Please Login</h2>
        <div class="input-group">
    		  <span class="input-group-addon" id="basic-addon1">@</span>
    		  <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
    		</div>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a>
      </form>
</div>
<?php require_once('credits.php'); ?>
</body>
</html>