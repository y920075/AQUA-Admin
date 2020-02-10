<?php
// require_once("./checkSession.php");
// echo "<pre>";
// print_r($_FILES);
// echo "</pre>";
// exit();

require_once('../template/db.inc.php');

$sql = "INSERT INTO `items`(`itemId`, `itemImg`, `itemName`, `itemDescription`, `itemCategoryId`, `itemTypeId`, `itemMaterial`, `itemBrandId`, `itemPrice`, 
                    `itemQty`, `itemSize`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if( $_FILES["itemImg"]["error"] == 0 ){
    $itemImg = date("YmdHis");
    $extension = pathinfo($_FILES["itemImg"]["name"], PATHINFO_EXTENSION);
    $imgFileName = $itemImg.".".$extension;

    if(!move_uploaded_file($_FILES["itemImg"]["tmp_name"], "../image/items/".$imgFileName)){
        header("Refresh: 5; url=./items.php");
        echo "<script>alert('上傳失敗')</script>";
        exit();
    } 
} else{
    $imgFileName = " ";
}

$arrParam = [
    $_POST['itemId'],
    $imgFileName,
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

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

// if(!$stmt){
//     print_r($pdo->errorInfo());
//     exit();
// }


if( $stmt->rowCount() > 0 ){
    header("Refresh: 0.1; url=./items.php");
    echo "<script>alert('新增成功')</script>";
    exit();
} else {
    // print_r($pdo->errorInfo());
    header("Refresh: 5; url=./items.php");
    echo "<script>alert('新增失敗')</script>";
    exit();
}