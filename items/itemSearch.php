<?php

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

header('Content-Type: application/json; charset=utf-8'); //設定資料類型
require_once('../template/db.inc.php'); //引入資料庫連線

$searchType = $_POST['searchType'];
$keyword = $_POST['keyword'];

$sql = " SELECT `itemId`, `itemName`, `itemImg`, `itemCategoryId`, 
                `itemSellerId`, `itemPrice`, `itemQty`, `itemStatus`, 
                `updated_at`
        FROM `items`
        ";

switch ($searchType) {
        case 'itemSellerId':
                $sql.= "WHERE `itemSellerId` LIKE '%$keyword%'";
                break;

        case 'itemId':
                $sql.= "WHERE `itemId` LIKE '%$keyword%'";
                break;

        case 'itemName':
                $sql.= "WHERE `itemName` LIKE '%$keyword%'";
                break;

        case 'itemCategoryId':
                $sql.= "WHERE `itemCategoryId` LIKE '%$keyword%'";
                break;
}



$stmt = $pdo->prepare($sql);
$stmt->execute();


$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($arr);