<?php
require_once('connect.php');
include('config.php');
  if(isset($_POST) & !empty($_POST)){
    $input = $_POST['input'];
    $sql = "SELECT * FROM `usermanagement` WHERE ";
      if(filter_var($input, FILTER_VALIDATE_EMAIL)){
        $sql .= "email='$input'";
      }else{
        $sql .= "username='$input'";
      }
    $res = mysqli_query($connection, $sql);
    $count = mysqli_num_rows($res);
    if($count == 1){
      $r = mysqli_fetch_assoc($res);
      $password = $r['password'];
      require 'PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = $smtphost;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpuser;
        $mail->Password = $smtppass;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('info@pixelw3.com', 'PixelW3 Technologies');
        $mail->addAddress('vivek@codingcyber.com', 'Vivek Vengala'); 

        $mail->Subject = 'Your Password';
        $mail->Body    = "Your Password is $password";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

  }
?>

<html>
<head>
<title>Forgot Password Script in PHP & MySQL</title>
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
        <h2 class="form-signin-heading">Reset Your Password</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="text" name="input" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
        <a class="btn btn-lg btn-primary btn-block" href="login.php">Login</a>
      </form>
</div>
<?php require_once('credits.php'); ?>
</body>
</html>