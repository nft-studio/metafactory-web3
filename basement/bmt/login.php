<?php

include('inc/initialize.php');
if (!isset($_SESSION)) {
	session_start();
}
$host = $_SERVER['HTTP_HOST'];
if (isset($_POST['login'])) {
	$loginFormAction = $_SERVER['PHP_SELF'];
	if (isset($_GET['accesscheck'])) {
		$_SESSION['PrevUrl'] = $_GET['accesscheck'];
	}
	$loginEmail = $_POST['username'];
	$password = hash('sha256', $_POST['password']);
	$MM_redirectLoginSuccess = "/bmt";
	$MM_redirectLoginFailed = "/bmt/login/errore";

	$row_rs_admin = returnDBObject("SELECT * FROM admins WHERE username=? AND password=?", array($loginEmail, $password));

	if ($row_rs_admin['id'] != '') {
		$loginFoundUser = 'yes';
		$userType = $row_rs_admin['level'];
	} else {
		$loginFoundUser = 'no';
	}

	if ($loginFoundUser == 'yes') {
		$_SESSION[$session_code]['Level'] = $userType;
		$_SESSION[$session_code]['Username'] = $loginEmail;
		$_SESSION[$session_code]['id'] = $row_rs_admin['id'];
		$_SESSION[$session_code]['pwd'] = $password;

		if (isset($_POST['remember'])) {
			setcookie($session_code . "_Username", $loginEmail, time() + 2592500, '/', '.' . $host);
			setcookie($session_code . "_Level", $userType, time() + 2592500, '/', '.' . $host);
			setcookie($session_code . "_id", $row_rs_admin['id'], time() + 2592500, '/', '.' . $host);
			setcookie($session_code . "_pwd",  $password, time() + 2592500, '/', '.' . $host);
		}
		header('location:' . $MM_redirectLoginSuccess);
	} else {
		header('location:' . $MM_redirectLoginFailed);
	}
}
?>
<?php include('layout/header.php'); ?>

<body>
	<div class="container wrap-login">
		<div class="form-signin" id="login-form">
			<div id="wrap-login">
				<img src="<?php echo $subdomain; ?>/bmt/layout/images/logo.png" width="60%">
				<form method="post">
					<div class="primary-form">
						<label class="control-label">Username</label>
						<input class="input-block-level" type="text" autocomplete="off" placeholder="Username" name="username" />
						<label class="control-label">Password</label>
						<input class="input-block-level" type="password" autocomplete="off" placeholder="Password" name="password" />
						<button type="submit" class="btn btn-primary btn-block uppercase">Login</button>
						<div class="form-actions">
							<div class="pull-left">
								<label class="rememberme check">
									<input type="checkbox" name="remember" value="1" />Mantieni login</label>
							</div>
						</div>
						<input type="hidden" name="login" value="yes">
					</div>
				</form>
				<!--forget-form-->
			</div>

			<?php include('layout/footer.php'); ?>
			<script>
				var unsaved = false;
				$(window).load(function() {
					h = window.innerHeight;
					h2 = h / 2;
					$('.form-signin').css('height', h + 'px');
					$('#wrap-login').css('margin-top', h2 - 190 + 'px');
				});
				$(window).resize(function() {
					h = window.innerHeight;
					h2 = h / 2;
					$('.form-signin').css('height', h + 'px');
					$('#wrap-login').css('margin-top', h2 - 190 + 'px');
				});
			</script>
</body>

</html>