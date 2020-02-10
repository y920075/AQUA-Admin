<?php
header("Content-Type: text/html; chartset=utf-8");

//引入判斷是否登入機制
// require_once('./checkSession.php');

//引用資料庫連線
require_once('../template/db.inc.php');

$idd = (int)$_POST['idd'] + 1;

// echo "<pre>";
// echo ($idd);
// echo "</pre>";
// // SQL 敘述
// // echo "<pre>";
// // print_r($_POST);
// // print_r($_FILES);
// // echo "</pre>";
// exit();



$sql = "INSERT INTO `blog`
        (`idd`, `blogId`, `blogCategory`, `blogTitle`, `blogContent`, `blogImages`) 
        VALUES (?, ?, ?, ?, ?, ?)";
// var_dump($sql);
// exit();

if( $_FILES["blogImages"]["error"] === 0 ) {
    //為上傳檔案命名
    $blogImages = date("YmdHis");
    
    //找出副檔名
    $extension = pathinfo($_FILES["blogImages"]["name"], PATHINFO_EXTENSION);

    //建立完整名稱
    $imgFileName = $blogImages.".".$extension;

    //若上傳成功，則將上傳檔案從暫存資料夾，移動到指定的資料夾或路徑
    if( !move_uploaded_file($_FILES["blogImages"]["tmp_name"], "../image/blog/".$imgFileName) ) {
        header("Refresh: 1; url=./blog.php");
        echo "圖片上傳失敗";
        exit();
    }
}
else{
    $imgFileName =" ";
}

//繫結用陣列
$arr = [
    $idd,
    $_POST['blogId'],
    $_POST['blogCategory'],
    $_POST['blogTitle'],
    $_POST['blogContent'],
    $imgFileName
];

$pdo_stmt = $pdo->prepare($sql);
// var_dump($pdo_stmt);
// exit();

$pdo_stmt->execute($arr);
// var_dump($re);
// exit();


// if(!$pdo_stmt){
//     echo "<pre>";
//     print_r($pdo_stmt->errorInfo());
//     echo "</pre>";
//     }
if($pdo_stmt->rowCount() > 0) {
    header("Refresh: 1; url=./blog.php");
    echo "新增成功";
} else {
    header("Refresh: 3; url=./blog.php");
    echo "新增失敗";
}