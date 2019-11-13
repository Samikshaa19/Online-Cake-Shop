<?php
session_start();
require_once('../connect.php');
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header('location: ..\login.php');
}
$username = $_SESSION['username'];

if(isset($_FILES) & !empty($_FILES)){
  $name = $_FILES['profilepic']['name'];
  $size = $_FILES['profilepic']['size'];
  $type = $_FILES['profilepic']['type'];
  $tmp_name = $_FILES['profilepic']['tmp_name'];

  $extension = substr($name, strpos($name, '.') + 1);
  $maxsize = 500000;

  if(isset($name) & !empty($name)){
    if(($extension=="jpeg" || $extension="jpg") & $type == "image/jpeg" & $size <= $maxsize){
      $location = "uploads/";
      if(move_uploaded_file($tmp_name, $location.$username.".jpg")){
        $usql = "UPDATE `usermanagement` SET profilepic='$location$username.jpg' WHERE username='$username'";
        $ures = mysqli_query($connection, $usql);
        if($ures){
          echo "Uploaded successfully";
        }
      }
    }else{
      echo "Please upload only JPEG files & should be below 500kb";
    }
  }else{
  echo "Please select a File";
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

            <form method="post" class="form-horizontal"  enctype="multipart/form-data">
                  <input type="file" name="profilepic" >
                  <input type="submit" class="btn btn-primary col-md-offset-4" value="Upload Profile Pic">
                  <p></p>
                  <a href="delete.php" class="btn btn-danger col-md-offset-4" >Delete Profile Pic</a>
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