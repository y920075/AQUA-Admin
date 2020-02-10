<?php
session_start();
//判斷是否登入

if(!isset($_SESSION["username"])) {

    session_destroy();

    header("Refresh:3; url=./login.php");
    echo"請確實登入,3秒後自動回登入頁";
    exit();
}