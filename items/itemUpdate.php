<?php
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

//引用資料庫連線
require_once('../template/db.inc.php');

/**
 * 注意：
 * 
 * 因為要判斷更新時檔案有無上傳，
 * 所以要先對前面/其它的欄位先進行 SQL 語法字串連接，
 * 再針對圖片上傳的情況，給予對應的 SQL 字串和資料繫結設定。
 * 
 */

//先對其它欄位，進行 SQL 語法字串連接
$sql = "UPDATE `items` 
        SET 
        `itemName` = ?, 
        `itemDescription` = ?,
        `itemCategoryId` = ?,
        `itemTypeId` = ?,
        `itemMaterial` = ?,
        `itemBrandId` = ?,
        `itemPrice` = ?,
        `itemQty` = ?,
        `itemSize` = ? ";

//先對其它欄位進行資料繫結設定
$arrParam = [
    $_POST['itemName'],
    $_POST['itemDescription'],
    $_POST['itemCategoryId'],
    $_POST['itemTypeId'],
    $_POST['itemMaterial'],
    $_POST['itemBrandId'],
    $_POST['itemPrice'],
    $_POST['itemQty'],
    $_POST['itemSize']
];

//判斷檔案上傳是否正常，error = 0 為正常
if( $_FILES["itemImg"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["itemImg"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $imgFileName = $strDatetime.".".$extension;

    //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if( move_uploaded_file($_FILES["itemImg"]["tmp_name"], "../image/items/".$imgFileName) ) {
        /**
         * 刪除先前的舊檔案: 
         * 一、先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
         * 二、刪除實體檔案
         * 三、更新成新上傳的檔案名稱
         *  */ 

        //先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `itemImg` FROM `items` WHERE `itemId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            $_POST['editId']
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
            
            /**
             * 因為前面 `studentDescription` = ? 後面沒有加「,」，
             * 若是這裡會有更新 studentImg 的需要，
             * 代表 `studentDescription` = ? 後面缺一個「,」，
             * 不然會報錯
             */
            $sql.= ",";

            //studentImg SQL 語句字串
            $sql.= "`itemImg` = ? ";

            //僅對 studentImg 進行資料繫結
            $arrParam[] = $imgFileName;
            
        }
    } 

    
}



//SQL 結尾
$sql.= "WHERE `itemId` = ? ";
$arrParam[] = $_POST['editId'];

$stmt = $pdo->prepare($sql);

if(!$stmt){
    print_r($pdo->errorInfo());
    exit();
}

$stmt->execute($arrParam);

$previousPage = $_SERVER["HTTP_REFERER"];
if( $stmt->rowCount() > 0 ){
    header("Refresh: 0.1; url=./items.php");
    echo "<script>alert('修改成功')</script>";
    exit();
} else {
    header("Refresh: 3; url=./items.php");
    echo "<script>alert('修改失敗')</script>";
    exit();
}