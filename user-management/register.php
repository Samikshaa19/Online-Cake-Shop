<?php
require_once('connect.php');
include('config.php');
include('recaptchalib.php');
$response = null;
$reCaptcha = new ReCaptcha($secret);
if(isset($_POST) & !empty($_POST)){

	if($_POST['g-recaptcha-response']){
		$response = $reCaptcha->verifyResponse(
				$_SERVER['REMOTE_ADDR'],
				$_POST['g-recaptcha-response']
			);

	}

	if($response != null && $response->success){
		$username = mysqli_real_escape_string($connection, $_POST['username']);
		$verification_key = md5($username);
		$email = mysqli_real_escape_string($connection, $_POST['email']);
		$password = md5($_POST['password']);
		$passwordagain = md5($_POST['passwordagain']);
		if($password == $passwordagain){
			$fmsg = "";
			
			$usernamesql = "SELECT * FROM `usermanagement` WHERE username='$username'";
			$usernameres = mysqli_query($connection, $usernamesql);
			$count = mysqli_num_rows($usernameres);
			if($count == 1){
				$fmsg .= "Username exists in Database, please try different user name";
			}

			$emailsql = "SELECT * FROM `usermanagement` WHERE email='$email'";
			$emailres = mysqli_query($connection, $emailsql);
			$emailcount = mysqli_num_rows($emailres);
			if($emailcount == 1){
				$fmsg .= "Email exists in Database, please reset your password";
			}


			echo $sql = "INSERT INTO `usermanagement` (username, email, password, verification_key) VALUES ('$username', '$email', '$password', '$verification_key')";
			$result = mysqli_query($connection, $sql);
			if($result){
				$smsg = "User Registered succesfully";
				$id = mysqli_insert_id($connection);
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

					$mail->Subject = 'Verify Your Email';
					$mail->Body    = "http://localhost/user-management/verify.php?key=$verification_key&id=$id";
					$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

					if(!$mail->send()) {
					    echo 'Message could not be sent.';
					    echo 'Mailer Error: ' . $mail->ErrorInfo;
					} else {
					    echo 'Message has been sent';
					}

			}else{
				$fmsg .= "Failed to register user";
			}
		}else{
			$fmsg = "Password not matching";
		}
	}
}
?>
<html>
<head>
<title>User Registration Script in PHP & MySQL</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >

<link rel="stylesheet" href="styles.css" >
<script   src="https://code.jquery.com/jquery-3.1.1.js" ></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	$('#usernameLoading').hide();
	$('#username').keyup(function(){
	  $('#usernameLoading').show();
      $.post("check.php", {
        username: $('#username').val()
      }, function(response){
        $('#usernameResult').fadeOut();
        setTimeout("finishAjax('usernameResult', '"+escape(response)+"')", 400);
      });
    	return false;
	});
});

function finishAjax(id, response) {
  $('#usernameLoading').hide();
  $('#'+id).html(unescape(response));
  $('#'+id).fadeIn();
} //finishAjax
</script>

</head>
<body>
	<div class="container">
      <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert"> <?php echo $smsg; ?> </div><?php } ?>
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Please Register</h2>
        <div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">@</span>
		  <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php if(isset($username) & !empty($username)){ echo $username; } ?>" required>
			<span id="usernameLoading" class="input-group-addon"><img src="loading.gif" height="30px" alt="Ajax Indicator" /></span>
		</div>
		<span id="usernameResult"></span> 
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?php if(isset($email) & !empty($username)){ echo $email; } ?>" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <label for="inputPassword" class="sr-only">Password Again</label>
        <input type="password" name="passwordagain" id="inputPassword" class="form-control" placeholder="Password Again" required>
        <div class="g-recaptcha" data-sitekey="6LeuQwkUAAAAAPrlzSQ-xxxxxxxxxx"></div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
        <a class="btn btn-lg btn-primary btn-block" href="login.php">Login</a>
      </form>
</div>
<?php require_once('credits.php'); ?>
</body>
</html>