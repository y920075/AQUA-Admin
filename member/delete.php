<?php
//引入判斷是否登入機制
// require_once('./checkSession.php');

//引用資料庫連線
require_once('../template/db.inc.php');

//先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `avatar` FROM `my_member` WHERE `memberId` = ? ";
$stmtGetImg = $pdo->prepare($sqlGetImg);

//加入繫結陣列
$arrGetImgParam = [
    $_GET['deletememberId']
];

//執行 SQL 語法
$stmtGetImg->execute($arrGetImgParam);

//若有找到 studentImg 的資料
if($stmtGetImg->rowCount() > 0) {
    //取得指定 id 的學生資料 (1筆)
    $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

    //若是 studentImg 裡面不為空值，代表過去有上傳過
    if($arrImg[0]['avatar'] !== NULL){
        //刪除實體檔案
        @unlink("./image/avatar/".$arrImg[0]['avatar']);
    }     
}

//SQL 語法
$sql = "DELETE FROM `my_member` WHERE `memberId` = ? ";

$arrParam = [
    $_GET['deletememberId']
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0) {
    header("Refresh: 1; url=./member.php");
    echo '<script language="javascript">';
    echo 'alert("刪除成功")';
    echo '</script>';

} else {
    header("Refresh: 1; url=./member.php");
    echo '<script language="javascript">';
    echo 'alert("刪除失敗")';
    echo '</script>';
}