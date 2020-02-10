<?php
    require_once('../template/db.inc.php');
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit();

//SQL更新語法
$sql = "UPDATE `class_type` SET `classTypeName` = ? WHERE `classTypeId` = ?";

//繫結陣列
$arrParam = [
    $_POST['classTypeName'],
    $_POST['editId']
];

//執行SQL語法
$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

//如果影響行數大於0 就執行
if( $stmt->rowCount() > 0 ){
    header("Refresh: 0.1; url=./class-category.php");
    echo '<script type="text/javascript">alert("資料修改成功!");</script>';

} else {
    header("Refresh: 0.1; url=./class-category.php");
    echo '<script type="text/javascript">alert("資料修改失敗!");</script>';

}
