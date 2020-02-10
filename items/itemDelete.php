<?php

//引用資料庫連線
require_once('../template/db.inc.php');

//先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `itemImg` FROM `items` WHERE `itemId` = ? ";
$stmtGetImg = $pdo->prepare($sqlGetImg);

//加入繫結陣列
$arrGetImgParam = [
    $_GET['deleteId']
];

//執行 SQL 語法
$stmtGetImg->execute($arrGetImgParam);

//若有找到 studentImg 的資料
if($stmtGetImg->rowCount() > 0) {
    //取得指定 id 的學生資料 (1筆)
    $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

    //若是 studentImg 裡面不為空值，代表過去有上傳過
    if($arrImg[0]['itemImg'] !== NULL){
        //刪除實體檔案
        @unlink("../image/items/".$arrImg[0]['itemImg']);
    }     
}

//SQL 語法
$sql = "DELETE FROM `items` WHERE `itemId` = ? ";

$arrParam = [
    $_GET['deleteId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 0.1; url=./items.php");
    echo "<script>alert('刪除成功')</script>";
} else {
    header("Refresh: 0.1; url=./items.php");
    echo "<script>alert('刪除失敗')</script>";
}