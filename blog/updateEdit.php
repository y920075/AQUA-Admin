<?php
require_once('../template/db.inc.php');

/**
 * 注意：
 * 
 * 因為要判斷更新時檔案有無上傳，
 * 所以要先對前面/其它的欄位先進行 SQL 語法字串連接，
 * 再針對圖片上傳的情況，給予對應的 SQL 字串和資料繫結設定。
 * 
 */

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

//先對其它欄位，進行 SQL 語法字串連接
$sql = "UPDATE `blog` 
        SET 
        `blogCategory` = ?, 
        `blogTitle` = ?,
        `blogContent` = ? ";

//先對其它欄位進行資料繫結設定
$arrParam = [
    $_POST['blogCategory'],
    $_POST['blogTitle'],
    $_POST['blogContent']
];


//判斷檔案上傳是否正常，error = 0 為正常
if( $_FILES["blogImages"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["blogImages"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $blogImages = $strDatetime.".".$extension;

    //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if( move_uploaded_file($_FILES["blogImages"]["tmp_name"], "../image/blog/".$blogImages) ) {
        /**
         * 刪除先前的舊檔案: 
         * 一、先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
         * 二、刪除實體檔案
         * 三、更新成新上傳的檔案名稱
         *  */ 

        //先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `blogImages` 
                        FROM `blog` 
                        WHERE `blogId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入繫結陣列
        $arrGetImgParam = [
            $_POST['blogId']
        ];
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // exit();

        //執行 SQL 語法
        $stmtGetImg->execute($arrGetImgParam);

        //若有找到 studentImg 的資料
        if($stmtGetImg->rowCount() > 0) {
            //取得指定 id 的學生資料 (1筆)
            $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

            //若是 studentImg 裡面不為空值，代表過去有上傳過
            if($arrImg[0]['blogImages'] !== NULL){
                //刪除實體檔案
                @unlink("./image/blog/".$arrImg[0]['blogImages']);
            } 
            
            /**
             * 因為前面 `studentDescription` = ? 後面沒有加「,」，
             * 若是這裡會有更新 studentImg 的需要，
             * 代表 `studentDescription` = ? 後面缺一個「,」，
             * 不然會報錯
             */
            $sql.= ",";

            //studentImg SQL 語句字串
            $sql.= "`blogImages` = ? ";

            //僅對 studentImg 進行資料繫結
            $arrParam[] = $blogImages;
            
        }
    }
}

//SQL 結尾            
$sql.= "WHERE `blogId` = ? ";
$arrParam[] = $_POST['blogId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if( $stmt->rowCount() > 0 ){
    header("Refresh: 2; url=./blog.php");
    echo "更新成功";
    exit();
} else {
    header("Refresh: 2; url=./blog.php");
    echo "沒有任何更新";
    exit();
}