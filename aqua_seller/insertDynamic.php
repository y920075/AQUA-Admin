<?php
header("Content-Type: text/html;charset=utf-8");

// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
// exit();
$idd = $_POST["idd"] + 1;

require_once("../template/db.inc.php");

require_once("../template/checkSession.php");
// echo "<pre>";

// print_r($_POST['seller_id']) ;
// print_r( $_POST['seller_id']);
// print_r($_POST['seller_name']);
// print_r($_POST['seller_password']);
// print_r($_POST['seller_address']);
// print_r($_POST['seller_phone']);
// print_r($_POST['seller_mobile']);
// print_r($_POST['seller_status']);
// print_r($_POST['seller_email']);
// print_r($_POST['join_time']);
// print_r($_FILES["seller_img"]["name"]);
// echo "</pre>";

// exit();


// Array
// (
//     [0] => Array
//         (
//             [0] => 單人房
//             [1] => 雙人房
//             [2] => 三人房
//             [3] => vip
//         )

//     [1] => Array
//         (
//             [0] => 4人房
//             [1] => 5人房
//             [2] => 6人房
//             [3] => 7ip
//         )

// )
$sql = "INSERT INTO `basic_information` 
        (`idd`,`seller_id`, `seller_name`, 
        `seller_password`,`seller_address`,
        `seller_phone`,`seller_mobile`,
        `seller_status`,`seller_email`,
        `join_time`,`seller_img`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$pdo_stmt = $pdo->prepare($sql);

$count = 0;
//針對name做count而不是針對下面的[0][1]左count
for($i = 0; $i < count($_FILES["seller_img"]["name"]); $i++){

    if( $_FILES["seller_img"]["error"][$i] === 0 ) {
        //為上傳檔案命名
        $seller_img = date("YmdHis")."_".$i;
        
        //找出副檔名
        $extension = pathinfo($_FILES["seller_img"]["name"][$i], PATHINFO_EXTENSION);

        //建立完整名稱
        $imgFileName = $seller_img.".".$extension;

        //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
        if( !move_uploaded_file($_FILES["seller_img"]["tmp_name"][$i], "../image/sellers/".$imgFileName) ) {
            header("Refresh: 3; url=./seller.php");
            echo "圖片上傳失敗";
            exit();
        }
        $arr = [
            $idd,
            $_POST['seller_id'][$i],
            $_POST['seller_name'][$i],
            $_POST['seller_password'][$i],
            $_POST['seller_address'][$i],
            $_POST['seller_phone'][$i],
            $_POST['seller_mobile'][$i],
            $_POST['seller_status'][$i],
            $_POST['seller_email'][$i],
            $_POST['join_time'][$i],
            $imgFileName
        ];

        $pdo_stmt->execute($arr);
        $count += $pdo_stmt->rowCount();


    }
}
//繫結用陣列

if($count > 0) {
    header("Refresh: 10000; url=./seller.php");
    echo "新增成功";
} else {
    header("Refresh: 10000; url=./seller.php");
    echo "新增失敗";
}
    // if(!$pdo_stmt ){
    //     echo"<pre>";

    //     print_r($pdo->errorInfo());
    //     echo"</pre>";
    //     exit();
    // }
  




