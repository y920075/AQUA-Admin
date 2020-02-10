<?php
require_once('../template/db.inc.php');

//先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `blogImages` FROM `blog` WHERE `blogId` = ? ";
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
    if($arrImg[0]['blogImages'] !== NULL){
        //刪除實體檔案
        @unlink("../image/blog/".$arrImg[0]['blogImages']);
    }     
}

//SQL 語法
$sql = "DELETE FROM `blog` WHERE `blogId` = ? ";

$arrParam = [
    $_GET['deleteId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 2; url=./blog.php");
    echo "刪除成功";
} else {
    header("Refresh: 2; url=./blog.php");
    echo "刪除失敗";
}