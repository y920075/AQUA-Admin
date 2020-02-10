<?php
// require_once('./checkSession.php');
require_once('../template/db.inc.php');

// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
// exit();

//先對其它欄位，進行 SQL 語法字串連接
$sql = "UPDATE `my_member` 
        SET 
        `memberId` = ?, 
        `loginId` = ?,
        `loginPwd` = ?,
        `fullName` = ?,
        `gender` = ?,
        `birthDate` = ?, 
        `email` = ?,
        `mobileNumber` = ?,
        `address` = ?,
        `joinDate` = ?,
        `currentStatus` = ?,
        `rankCoin` = ?,
        `rankId` = ? ";

//先對其它欄位進行資料繫結設定
$arrParam = [
    $_POST['memberId'],
    $_POST['loginId'],
    $_POST['loginPwd'],
    $_POST['fullName'],
    $_POST['gender'],
    $_POST['birthDate'],
    $_POST['email'],
    $_POST['mobileNumber'],
    $_POST['address'],
    $_POST['joinDate'],
    $_POST['currentStatus'],
    $_POST['rankCoin'],
    $_POST['rankId']
];

//判斷檔案上傳是否正常，error = 0 為正常
if( $_FILES["avatar"]["error"] === 0 ) {
    //為上傳檔案命名
    $strDatetime = date("YmdHis");
        
    //找出副檔名
    $extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $avatar = $strDatetime.".".$extension;

    //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if( move_uploaded_file($_FILES["avatar"]["tmp_name"], "./Img/avatar/".$avatar) ) {
        /**
         * 刪除先前的舊檔案: 
         * 一、先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
         * 二、刪除實體檔案
         * 三、更新成新上傳的檔案名稱
         *  */ 

        //先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `avatar` FROM `my_member` WHERE `memberId` = ? ";
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
            if($arrImg[0]['avatar'] !== NULL){
                //刪除實體檔案
                @unlink("./image/avatar/".$arrImg[0]['avatar']);
            } 
            
            /**
             * 因為前面 `studentDescription` = ? 後面沒有加「,」，
             * 若是這裡會有更新 studentImg 的需要，
             * 代表 `studentDescription` = ? 後面缺一個「,」，
             * 不然會報錯
             */
            $sql.= ",";

            //studentImg SQL 語句字串
            $sql.= "`avatar` = ? ";

            //僅對 studentImg 進行資料繫結
            $arrParam[] = $avatar;
            
        }
    }
}

//SQL 結尾
$sql.= "WHERE `memberId` = ? ";
$arrParam[] = $_POST['editId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if( $stmt->rowCount() > 0 ){
    header("Refresh: 1; url=./member.php");
    echo '<script language="javascript">';
    echo 'alert("更新成功")';
    echo '</script>';
} else {
    header("Refresh: 1; url=./member.php");
    echo '<script language="javascript">';
    echo 'alert("更新失敗")';
    echo '</script>';
}