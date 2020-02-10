<?php 
    header('Content-Type: application/json; charset=utf-8'); //設定資料類型
    require_once('../template/db.inc.php'); //引入資料庫連線

    //取得AJAX傳送過來的值
    $select_Cond = $_POST['select_CondA'];

    
