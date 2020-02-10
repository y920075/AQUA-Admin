<?php
header('Content-Type: application/json; charset=utf-8'); //設定資料類型
require_once('../template/db.inc.php'); //引入資料庫連線

$sql = "    SELECT  `event_data`.`eventId`,`event_data`.`eventName`,`event_type`.`eventTypeName`,`location`.`LocationName`, `event_data`.`eventLocal`,`event_data`.`eventSponsor`,`event_data`.`eventStartDate`,`event_data`.`eventEndDate`,`event_data`.`created_at`,`event_data`.`updated_at`
            FROM `event_data`
            INNER JOIN `event_type`
            ON `event_data`.`eventTypeId` = `event_type`.`eventTypeId`
            LEFT JOIN `location`
            ON `event_data`.`eventLocal`= `location`.`LocationID`";
            

$numPerPage = 10 ; //每頁要顯示多少資料
$page = $_POST['page']; //接收從AJAX傳送過來的page值
$type = $_POST['search_type']; //取得AJAX傳送過來的類別值
$date = $_POST['search_date']; //取得AJAX傳送過來的時間值
$arrParam = []; //宣告一個空陣列準備繫結用

//判斷搜尋條件
//DATEDIFF函式可以計算2個日期之間的差距天數 第一個值使用開課時間 第二個則是取得現在系統時間 相減之後小於3/7/30天的就會被列出
//如果不符合任何SWTICH條件，則相當於不加入WHERE條件做查詢，就會查詢出所有資料
 switch ( true ) { 
    case $date=='3day' && $type!=='all' :  //搜尋3天以內的特定類別  
        $sql.= 'WHERE DATEDIFF(`event_data`.`eventStartDate`,NOW())>0 AND DATEDIFF(`event_data`.`eventStartDate`,NOW())<=3 AND `event_data`.`eventTypeId` = ? ';
        $arrParam[]= $type;
        break;
    case $date=='7day' && $type!=='all' :  //搜尋7天以內的特定類別
        $sql.= 'WHERE DATEDIFF(`event_data`.`eventStartDate`,NOW())>0 AND DATEDIFF(`event_data`.`eventStartDate`,NOW())<=7 AND `event_data`.`eventTypeId` = ? ';
        $arrParam[]= $type;
        break;
    case $date=='30day' && $type!=='all' : //搜尋30天以內的特定類別
        $sql.= 'WHERE DATEDIFF(`event_data`.`eventStartDate`,NOW())>0 AND DATEDIFF(`event_data`.`eventStartDate`,NOW())<=30 AND `event_data`.`eventTypeId` = ? ';
        $arrParam[]= $type;
        break;
    case $date=='all' && $type!=='all' :   //搜尋所有時間的特定類別
        $sql.= 'WHERE  `event_data`.`eventTypeId` = ? ';
        $arrParam[]= $type;
        break;
    case $type=='all' && $date=='3day' :  //搜尋3天以內的"所有"類別
        $sql.= 'WHERE DATEDIFF(`event_data`.`eventStartDate`,NOW())>0 AND DATEDIFF(`event_data`.`eventStartDate`,NOW())<=3 ';
        break;
    case $type=='all' && $date=='7day' :  //搜尋7天以內的"所有"類別
        $sql.= 'WHERE DATEDIFF(`event_data`.`eventStartDate`,NOW())>0 AND DATEDIFF(`event_data`.`eventStartDate`,NOW())<=7 ';
        break;
    case $type=='all' && $date=='30day' :  //搜尋30天以內的"所有"類別
        $sql.= 'WHERE DATEDIFF(`event_data`.`eventStartDate`,NOW())>0 AND DATEDIFF(`event_data`.`eventStartDate`,NOW())<=30 ';
        break;
 }



$sql.= 'ORDER BY `event_data`.`id` DESC '; //把排序條件加進去

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
$arr[] = count($arrCount); //返回陣列總長度，作為計算總頁數使用
echo json_encode($arr);
