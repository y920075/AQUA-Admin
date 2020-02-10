<?php 
// echo"<pre>";

// print_r($_POST);

// echo"</pre>";

header("Content-Type: text/html;charset=utf-8");

require_once("../template/db.inc.php");

// require_once("../template/checkSession.php");

$idd = $_POST["idd"] + 1;
//SQL 敘述
$sql = "INSERT INTO `basic_information` 
        (`idd`,`seller_id`, `seller_name`, 
        `seller_password`,`seller_address`,
        `seller_phone`,`seller_mobile`,
       `seller_email`,`seller_status`,`seller_decrip`,
        `join_time`,`seller_img`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if( $_FILES["seller_img"]["error"] === 0 ) {
        //為上傳檔案命名
        $seller_img = date("YmdHis");
        
        //找出副檔名
        $extension = pathinfo($_FILES["seller_img"]["name"], PATHINFO_EXTENSION);

        //建立完整名稱
        $imgFileName = $seller_img.".".$extension;

        //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
        if( !move_uploaded_file($_FILES["seller_img"]["tmp_name"], "../image/sellers/".$imgFileName) ) {
            header("Refresh: 100000; url=./seller.php");
            echo "圖片上傳失敗";
            exit();
        }
    }
    
        

//繫結用陣列
$arr = [
    $idd,
    $_POST['seller_id'],
    $_POST['seller_name'],
    $_POST['seller_password'],
    $_POST['seller_address'],
    $_POST['seller_phone'],
    $_POST['seller_mobile'],
    $_POST['seller_email'],
    $_POST['seller_status'],
    $_POST['seller_decrip'],
    $_POST['join_time'],
    $imgFileName
];



$pdo_stmt = $pdo->prepare($sql);
$pdo_stmt->execute($arr);


if(!$pdo_stmt ){
    echo"<pre>";

    print_r($pdo->errorInfo());
    echo"</pre>";
    exit();
}
if($pdo_stmt->rowCount() > 0) {
    header("Refresh: 2; url=./seller.php");
    echo "新增成功";
} else {
    print_r($pdo->errorInfo());
    header("Refresh: 100; url=./seller.php");
    echo "新增失敗";
}