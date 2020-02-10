<?php
require_once('../template/db.inc.php');

$eventTypeId = $_POST['eventTypeId'];
//用正規表達式檢查輸入的類別編號是否符合格式
$Regexp = '/^([E][t][y][p][e]+)([0-9]{2})$/m';
//執行正規表達式
preg_match_all($Regexp,$eventTypeId , $matches);

//如果正規表達是沒有配對到值或者類別名稱為空值，就跳轉並退出
if( $matches[0] == NULL || empty($_POST['eventTypeName'])){
    header("Refresh: 0.1 ; url=./event-category.php");
    echo '<script type="text/javascript">alert("請輸入正確的資訊!");</script>';
    exit();
}

//用來驗證編號有沒有重複
$sqlCheckId = "SELECT `eventTypeId`
               FROM `event_type`
               WHERE `eventTypeId`='$eventTypeId'";
$stmtCheckId = $pdo->prepare($sqlCheckId);
$stmtCheckId->execute();
if($stmtCheckId->rowCount() > 0){
    header("Refresh: 0.1 ; url=./event-category.php");
    echo '<script type="text/javascript">alert("類別編號重複!");</script>';
    exit();
}

//SQL新增語法
$sql = "INSERT INTO `event_type` (`eventTypeId`,`eventTypeName`) 
        VALUES ( ?, ?)";

$stmt = $pdo->prepare($sql);
//繫結陣列
$arrStmt = [
    $_POST['eventTypeId'],
    $_POST['eventTypeName']
];
$stmt->execute($arrStmt);

//如果影響行數大於0 就執行
if ( $stmt->rowCount() > 0 ){
    header("Refresh: 0.1 ; url=./event-category.php");
    echo '<script type="text/javascript">alert("新增成功!");</script>';
} else {
    header("Refresh: 0.1 ; url=./event-category.php");
    echo '<script type="text/javascript">alert("新增失敗!");</script>';
}


