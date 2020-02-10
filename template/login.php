<?php

session_start();

header("Content-Type:text/html;charset=utf-8");

require_once("db.inc.php");

if(isset($_POST["username"]) && isset($_POST["password"])){
	$sql = "SELECT `username`,`password`
			FROM `admin`
			WHERE `username`=?
			AND `password` = ?";

	$arrP = [
		$_POST["username"],
		sha1($_POST["password"])
	];

	$pdoState = $pdo->prepare($sql);

	if(!$pdoState){
		echo"<pre>";

		print_r($pdo->errorInfo());
		echo"</pre>";
		exit();

	}

	$pdoState->execute($arrP);

	if($pdoState->rowCount() > 0) {
		header("Refresh: 0;url=../dashboard\dashboard.php");
		$_SESSION["username"] = $_POST["username"];
	}else{
		header("Refresh: 3;url=../index.php");
		echo "login:fail1登入失敗,3秒會回登入頁";

	}
}else{
	header("Refresh: 3;url=../index.php");
	echo "login:fail2:請確實登入,3秒會回登入頁";
}
	



?>
