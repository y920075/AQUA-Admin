<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AQUA - Login</title>
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<link href="./css/datepicker3.css" rel="stylesheet">
	<link href="./css/styles.css" rel="stylesheet">
	<link rel="shortcut icon" href="./image/aquafavicon.png" type="image/x-icon">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<style>
		body{
			padding: 0;
			overflow: hidden;
			background-image: url(./image/snorkeling-984422_1920.jpg);
			background-size: cover;
		} 
		.login{
			border-radius: 5%;
			margin-top: 150px;
			background-color: rgba(255, 255, 255, .0);
			padding: 0
		}
		.loginbr{
			border-radius: 5%;
		}
	</style>
</head>
<body>
	<div>
		<!-- <div class="background">
			<img src="./image/snorkeling-984422_1920.jpg" alt="">
		</div> -->
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-3 col-md-offset-8 login">
				<div class="login-panel panel panel-default loginbr">
					<img src="./image/logo-19.png" alt="" class="img-responsive center-block">
					<div class="panel-heading text-center">登入管理系統</div>
					<div class="panel-body">
						<form name="myForm" method="post" action="./template/login.php" role="form">
							<fieldset>
								<div class="form-group">
									<input class="form-control" placeholder="Username" name="username" type="text" autofocus="">
								</div>
								<div class="form-group">
									<input class="form-control" placeholder="Password" name="password" type="password" value="">
								</div>
								<br/>
								<button type="submet" class="btn btn-md btn-primary  form-control" > 登入 </button>
					</form>
					</div>
				</div>
				<?php require_once("template/footer.php");?>
			</div><!-- /.col-->
		</div><!-- /.row -->
	</div>	
