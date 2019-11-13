<?php
session_start();
require_once('../connect.php');
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header('location: ..\login.php');
}
$username = $_SESSION['username'];

if(isset($_POST) & !empty($_POST)){
  $cpass = md5($_POST['cpass']);
  $newpass = md5($_POST['newpass']);
  $newpass1 = md5($_POST['newpass1']);

  $passsql = "SELECT * FROM `usermanagement` WHERE username='$username'";
  $passres = mysqli_query($connection, $passsql);
  $passr = mysqli_fetch_assoc($passres);

  if($cpass == $passr['password']){
    if($newpass == $newpass1){
      $passusql = "UPDATE `usermanagement` SET password='$newpass' WHERE username='$username'";
      $passures = mysqli_query($connection, $passusql);
      if($passures){
        echo "Password Updated";
      }
    }
  }else{
    echo "Current Password Not Matching";
  }

}

?>

<html>
<head>
<title>Members Area - Edit Profile</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

<link rel="stylesheet" href="../styles.css" >

<!-- JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>


<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Members Area</a>
    </div>


  <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="index.php.php">Manage Profile</a></li>
            <li><a href="update-password.php">Change Password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="..\logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
	<div class="col-sm-3">
		<ul class="nav nav-pills nav-stacked">
		  <li class="active"><a href="#">Home</a></li>
	        <li><a href="#">Menu 2</a></li>
	        <li><a href="#">Menu 3</a></li>
		</ul>

	</div>
	<div class="col-sm-9">
  <?php
    $sql = "SELECT * FROM `usermanagement` WHERE username='$username'";
    $res = mysqli_query($connection, $sql);
    $r = mysqli_fetch_assoc($res);
  ?>
		<div class="panel panel-default">
			<div class="panel-heading"><h4>User Profile</h4></div>
		  <div class="panel-body">

          <div class="col-sm-6 col-centered">

                <div class="form-group">
                    <div align="center"> <img alt="User Pic" src="<?php if(isset($r['profilepic']) & !empty($r['profilepic'])){ echo $r['profilepic']; }else{ echo "https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg";} ?>" id="profileimage" class="img-circle img-responsive"> 
                    <div style="color:#999;" ><a href="upload.php">Upload Profile Pic</a></div>
                    </div>
                    <div class="col-sm-4">
                      
                    </div>
                  </div>

            <form method="post" class="form-horizontal">

                  <div class="form-group">
                      <label for="input1" class="col-sm-4 control-label">Current Password</label>
                      <div class="col-sm-8">
                        <input type="password" name="cpass" class="form-control" placeholder="Current Password">
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="input1" class="col-sm-4 control-label">New Password</label>
                      <div class="col-sm-8">
                        <input type="password" name="newpass" class="form-control" placeholder="New Password">
                      </div>
                  </div>

                  <div class="form-group">
                      <label for="input1" class="col-sm-4 control-label">Repeat Again</label>
                      <div class="col-sm-8">
                        <input type="password" name="newpass1" class="form-control" placeholder="Repeat New Password" required>
                      </div>
                  </div>

                  <input type="submit" class="btn btn-primary col-md-3 col-md-offset-9" value="Update">
            </form> 
          </div>
            <!-- /.box-body -->
          			</div>
          <!-- /.box -->
        		</div>

		  </div>
		</div>
	</div>
</div>
</body>
</html>