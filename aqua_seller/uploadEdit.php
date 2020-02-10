<?php
//引入判斷是否登入機制
require_once('../template/checkSession.php');

//引用資料庫連線
require_once('../template/db.inc.php');



// echo "<pre>";
// print_r( $_POST['seller_img']);
// echo "</pre>";
// exit();

//先對其他欄位進行sql語法字串相接


$sql = "UPDATE `basic_information`
        SET
        `seller_id` = ?,
        `seller_name` = ?,
        `seller_password` = ?,
        `seller_address` = ?,
        `seller_phone` = ?,
        `seller_mobile` = ?,
        `seller_status` = ?,
        `seller_email` = ?,
        `seller_decrip`= ?,
        `join_time` = ? ";
//         var_dump($sql);
// exit();
$arrParr = [
    $_POST['seller_id'],
    $_POST['seller_name'],
    $_POST['seller_password'],
    $_POST['seller_address'],
    $_POST['seller_phone'],
    $_POST['seller_mobile'],
    $_POST['seller_status'],
    $_POST['seller_email'],
    $_POST['seller_decrip'],
    $_POST['join_time']
];


if($_FILES["seller_img"]["error"] === 0 ) {
    //為上傳檔案命名

    $strDatetime = date("YmdHis");

    //找出附檔名
    $extension = pathinfo($_FILES["seller_img"]["name"], PATHINFO_EXTENSION);
    
    $combineImg = $strDatetime.".".$extension;

    //如果上傳成功,將上傳檔案從站存資料夾移動到指定folder

    if( move_uploaded_file($_FILES["seller_img"]["tmp_name"],"../image/sellers/".$combineImg)){
          /**
         * 刪除先前的舊檔案: 
         * 一、先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
         * 二、刪除實體檔案
         * 三、更新成新上傳的檔案名稱
         *  */ 
        // 一、先查詢出特定 id (editId) 資料欄位中的大頭貼檔案名稱
        $sqlGetImg = "SELECT `seller_img` FROM `basic_information` WHERE `seller_id` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        //加入細節

        $arrParamImg = [
           $_POST["editId"]
        ];

        //執行sql語法

        $stmtGetImg->execute($arrParamImg);

        //如果找到stmtImg資料

        if($stmtGetImg->rowCount() > 0) {
            //取得指定id學生資料

            $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC)[0];
            //如果seller_img不是空值代表過去又上傳過要刪除實體檔案
            if($arrImg["seller_img"] !== NULL){
                //刪除實體檔案
                @unlink("../image/sellers/".$arrImg["seller_img"]);
            }

            $sql.= ",";

            //加入seller_img語句字串
            $sql.= "`seller_img` = ? ";

            //僅對seller_img細節
            $arrParr[] = $combineImg;
        }
    }
}

$sql.="WHERE `seller_id` = ? ";
$arrParr[] = $_POST["editId"];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParr);

// var_dump($stmt);
// exit();

if(!$stmt){
    echo "Prepare failed: (". $pdo->errno.") ".$pdo->error."<br>";
    exit();
}
if( $stmt->rowCount() > 0 ){
    header("Refresh: 3; url=./seller.php");
    echo "更新成功";
} else {
    header("Refresh: 3; url=./seller.php");
    echo "沒有任何更新";
}
?>