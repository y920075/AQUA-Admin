<?php
require_once("../template/checkSession.php");

require_once("../template/db.inc.php");

//先查詢特定id
$sqlGetImg = "SELECT `seller_img` FROM `basic_information` WHERE `seller_id` = ? ";
$stmtGetImg = $pdo->prepare($sqlGetImg);

//加入細節
$arrGetImgParam = [
    $_GET["deleteId"]
];

//執行sql語法

$stmtGetImg->execute($arrGetImgParam);

//如果有找到seller_img資料

if($stmtGetImg->rowCount() > 0 ) {
    //取得指定id學生資料
    $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC)[0];

    //如果是seller_img裡面不是空值代表有上船過

    if($arrImg["seller_img"] !== NULL) {

        @unlink("../Img/sellers/" . $arrImg["seller_img"]);
    }
}

//SQL語法

$sql = "DELETE FROM `basic_information` WHERE `seller_id` = ? ";

$arrParam = [
    $_GET["deleteId"]
];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if($stmt->rowCount() > 0 ) {
    header("Refresh: 3; url=./seller.php");
    echo "刪除成功";
} else {
    header("Refresh: 3; url=./seller.php");
    echo "刪除失敗";
}