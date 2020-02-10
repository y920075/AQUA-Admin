<?php
header("Content-Type: text/html; charset=utf-8");
require_once('../template/db.inc.php');

// echo "<pre>";
// print_r($_POST);
// print_r($_FILES);
// echo "</pre>";

//SQL 敘述

$idd = (int)$_POST['idd'] + 1;

$sql = "INSERT INTO `my_member`
(`idd`, `memberId`, `loginId`, `loginPwd`, `avatar`, `fullName`, `gender`, `birthDate`, `email`, `mobileNumber`, `address`, `joinDate`, `currentStatus`, `rankCoin`, `rankId` ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // var_dump($sql);
        // // exit;

if( $_FILES["avatar"]["error"] === 0 ) {

    $avatar = date("YmdHis");
    $extension = pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);

    $imgFileName = $avatar.".".$extension;

    if( !move_uploaded_file($_FILES["avatar"]["tmp_name"], "../image/avatar/".$imgFileName) ) {
        header("Refresh: 3; url=./member.php");
        echo "圖片上傳失敗";
        exit();
    }
}
// } else {
//     $imgFileName = " ";
// }

$arr = [
    $idd,
    $_POST['memberId'],
    $_POST['loginId'],
    $_POST['loginPwd'],
    $imgFileName,
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

$pdo_stmt = $pdo->prepare($sql);
// var_dump($pdo_stmt);
// // exit;
$resulttest = $pdo_stmt->execute($arr);
// var_dump($resulttest);
// // exit;

// if(!$pdo_stmt){
// echo "<pre>";
// print_r($pdo_stmt->errorInfo());
// echo "</pre>";
// exit();
// }

if($pdo_stmt->rowCount() > 0) {
    header("Refresh: 1; url=./member.php");
    echo '<script language="javascript">';
    echo 'alert("新增成功")';
    echo '</script>';

} else {
    header("Refresh: 30; url=./member.php");
    echo '<script language="javascript">';
    echo 'alert("新增失敗")';
    echo '</script>';
 
    // if (!$st->execute()) {
    //     print_r($st->errorInfo());
    // }
    // print_r($pdo_stmt->errorInfo());
}