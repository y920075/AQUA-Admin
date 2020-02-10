<?php
require_once("./checkSession.php");

if(isset($_GET["logout"]) && $_GET["logout"] == "1"){

    session_destroy();

    //3秒後跳頁
    header("Refresh: 3;url=./index.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lumino - Login</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="alert alert-warning" role="alert">
            <strong>您已登出</strong> <br/>
            <strong>4秒後自動跳回登入頁</strong> 
            </div>
        </div>
</div>
</body>
</html>

<?php
exit();
}
?>