<?php
header('Content-Type: application/json; charset=utf-8'); //設定資料類型
require_once('../template/db.inc.php'); //引入資料庫連線


$sql = "    SELECT  `class_data`.`classId`,`class_data`.`className`,`class_type`.`classTypeName`,`class_level`.`classLevel`,
                `class_data`.`sellerID`,`class_data`.`classStartDate`,`class_data`.`classPrice`,
                `class_data`.`created_at`,`class_data`.`updated_at`
            FROM `class_data`
            INNER JOIN `class_type`
            ON `class_data`.`classTypeId` = `class_type`.`classTypeId`
            INNER JOIN `class_level`
            ON `class_data`.`classLevelID`= `class_level`.`classLevelId`";
            
$numPerPage = 10 ; //每頁要顯示多少資料
$page = $_POST['page']; //接收從AJAX傳送過來的page值
$keyword = $_POST['keyword'];
$type = $_POST['search_type'];
$date = $_POST['search_date'];
$arrParam = []; //宣告一個空陣列準備繫結用

//判斷搜尋條件
//DATEDIFF函式可以計算2個日期之間的差距天數 第一個值使用開課時間 第二個則是取得現在系統時間 相減之後小於3/7/30天的就會被列出
//如果不符合任何SWTICH條件，則相當於不加入WHERE條件做查詢，就會查詢出所有資料
 switch ( true ) { 
    case $date=='3day' && $type!=='all' :  //搜尋3天以內的特定類別  
        $sql.= "WHERE DATEDIFF(`class_data`.`classStartDate`,NOW())>=0 AND DATEDIFF(`class_data`.`classStartDate`,NOW())<=3 AND `class_data`.`classTypeId` = ? AND `class_data`.`className` LIKE '%$keyword%' ";
        $arrParam[]= $type;
        break;
    case $date=='7day' && $type!=='all' :  //搜尋7天以內的特定類別
        $sql.= "WHERE DATEDIFF(`class_data`.`classStartDate`,NOW())>=0 AND DATEDIFF(`class_data`.`classStartDate`,NOW())<=7 AND `class_data`.`classTypeId` = ? AND `class_data`.`className` LIKE '%$keyword%' ";
        $arrParam[]= $type;
        break;
    case $date=='30day' && $type!=='all' : //搜尋30天以內的特定類別
        $sql.= "WHERE DATEDIFF(`class_data`.`classStartDate`,NOW())>=0 AND DATEDIFF(`class_data`.`classStartDate`,NOW())<=30 AND `class_data`.`classTypeId` = ? AND `class_data`.`className` LIKE '%$keyword%'  ";
        $arrParam[]= $type;
        break;
    case $date=='all' && $type!=='all' :   //搜尋所有時間的特定類別
        $sql.= "WHERE `class_data`.`classTypeId` = ? AND `class_data`.`className` LIKE '%$keyword%' ";
        $arrParam[]= $type;
        break;
    case $type=='all' && $date=='3day' :  //搜尋3天以內的"所有"類別
        $sql.= "WHERE DATEDIFF(`class_data`.`classStartDate`,NOW())>=0 AND DATEDIFF(`class_data`.`classStartDate`,NOW())<=3 AND `class_data`.`className` LIKE '%$keyword%' ";
        break;
    case $type=='all' && $date=='7day' :  //搜尋7天以內的"所有"類別
        $sql.= "WHERE DATEDIFF(`class_data`.`classStartDate`,NOW())>=0 AND DATEDIFF(`class_data`.`classStartDate`,NOW())<=7 AND `class_data`.`className` LIKE '%$keyword%'  ";
        break;
    case $type=='all' && $date=='30day' :  //搜尋30天以內的"所有"類別
        $sql.= "WHERE DATEDIFF(`class_data`.`classStartDate`,NOW())>=0 AND DATEDIFF(`class_data`.`classStartDate`,NOW())<=30 AND `class_data`.`className` LIKE '%$keyword%'  ";
        break;
    default :
        $sql.= "WHERE `class_data`.`className` LIKE '%$keyword%' ";
        break;
 } 




$sql.= ' ORDER BY `class_data`.`id` DESC '; //把排序條件加進去

//先取得一次總筆數用來計算總頁數
$stmtCount = $pdo->prepare($sql);
$stmtCount->execute($arrParam);
$arrCount = $stmtCount->fetchAll(PDO::FETCH_ASSOC);

$sql.= ' LIMIT ?,? '; //加入限制顯示筆數

$arrParam[] = ($page-1 ) * $numPerPage; //從第幾筆開始顯示
$arrParam[] = $numPerPage; //總共要顯示幾筆

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);


$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
$arr[] = count($arrCount); //把總比數加入到陣列最後

echo json_encode($arr);




