<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $_MAIN__CONFIGS_010[3]; ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="icon" type="image/png" href="<?php echo $_MAIN__CONFIGS_010[7]; ?>">
	<link href="themes/admin_LTE/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="themes/admin_LTE/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="themes/admin_LTE/bootstrap/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	<link href="themes/admin_LTE/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

	<style>
		html {
			min-height: 100%;
		}

		body {
			background: url(_assets/_images/img_jpg1.jpg) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover;
		}
	</style>

</head>

<body>
	<div class="login-box">
		<!-- /.login-logo -->
		<div class="login-box-body">
			<img src="_assets/_images/logo2.png"></img>
			<p class="login-box-msg"><?php echo $message_login; ?></p>
			<p class="login-box-msg">Silahkan Login untuk mulai bertransaksi</p>
			<form action="index.php" method="post">
				<div class="form-group has-feedback">
					<input type="text" name="username_input" class="form-control" placeholder="<?php echo $_MAIN__CONFIGS_010[5]; ?>">
					<span class="glyphicon glyphicon-envelop"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" name="password_input" class="form-control" placeholder="<?php echo $_MAIN__CONFIGS_010[6]; ?>">
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					<input type="hidden" name="main" value="<?php echo $_MAIN__CONFIGS_010[2]; ?>">
				</div>
				<div class="row">
					<div class="col-xs-8"></div>
					<!-- /.col -->
					<div class="col-xs-4">
						<button type="submit" class="btn btn-warning btn-block btn-flat">Sign In</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
			<!-- /.social-auth-links -->
			<a href="#" onclick="bukaModalHelmizz301('#tempatmodal','main_010_01.php','','#tampil0');">Saya Lupa Password</a>
		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->
	<div class="tempatmodal"></div>
	<script src="themes/admin_LTE/plugins/jQuery/jQuery-2.1.3.min.js"></script>
	<!-- Bootstrap 3.3.2 JS -->
	<script src="themes/admin_LTE/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>