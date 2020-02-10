<?php
require_once("../template/checkSession.php");


require_once("../template/db.inc.php");
$sql = "DELETE FROM `basic_information` WHERE `seller_id` = ? ";

$count = 0;

//先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
$sqlGetImg = "SELECT `seller_img` FROM `basic_information` WHERE `seller_id` = ? ";



$stmtGetImg = $pdo->prepare($sqlGetImg);

for($i = 0; $i < count($_POST['chk']); $i++){
    //加入繫結陣列
    $arrGetImgParam = [
        (int)$_POST['chk'][$i]
    ];

    //執行 SQL 語法
    $stmtGetImg->execute($arrGetImgParam);

    //若有找到 studentImg 的資料
    if($stmtGetImg->rowCount() > 0) {
        //取得指定 id 的學生資料 (1筆)
        $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

        //若是 studentImg 裡面不為空值，代表過去有上傳過
        if($arrImg[0]['seller_img'] !== NULL){
            //刪除實體檔案
            @unlink("../image/sellers/".$arrImg[0]['seller_img']);
        }     
    }

    $arrParam = [
        $_POST['chk'][$i]
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);
    $count += $stmt->rowCount();
}

if($count > 0) {
    header("Refresh: 3; url=./seller.php");
    echo "刪除成功";
} else {
    header("Refresh: 3; url=./seller.php");
    echo "刪除失敗";
}