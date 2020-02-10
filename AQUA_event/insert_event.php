<?php
require_once('../template/db.inc.php');

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit();

if ( (int)$_POST['eventNowPeople'] > (int)$_POST['eventNeedPeople'] ) {
    header("Refresh: 0.1 ; url=./event-admin.php");
    echo '<script type="text/javascript">alert("現在人數不可大於徵求人數!");</script>';
    exit();
}

$eventId = $_POST['eventId'];
$maxId = (int)$_POST['maxId'] + 1;

$sql = "INSERT INTO `event_data` 
        (`eventId`,`maxId`,`eventName`,`eventTypeId`,`eventLocal`,`eventSponsor`,`eventStartDate`,`eventEndDate`,`eventDesc`,`eventNeedPeople`,`eventNowPeople`,`eventImg`) 
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

//如果檔案正常上傳
if($_FILES['eventImg']['error'] === 0){
    //取得時間字串 格式為 E + 年月日時分秒
    $eventImg = 'E'.date('YmdHis');
    //取得副檔名
    $extension = pathinfo($_FILES['eventImg']['name'],PATHINFO_EXTENSION);
    //建立新檔案名稱 用取得的時間字串+副檔名 命名 
    $EeventimgFileName = $eventImg.".".$extension;

    //如果檔案沒有被移動，則提示上傳失敗並退出
    if(!move_uploaded_file($_FILES['eventImg']['tmp_name'],"../image/eventImg/".$EeventimgFileName)){
        header("Refresh: 2 ; url=./event-admin.php");
        echo '圖片上傳失敗';
        exit();
    }
} else {
    $EeventimgFileName = '';
}

$stmt = $pdo->prepare($sql);

if( $_POST['eventLocal'] == 'other' && $_POST['customLocal'] !== ''){
    $local = $_POST['customLocal'];
} else {
    $local = $_POST['eventLocal'];
}


//繫結陣列
$arrStmt = [
    $eventId,
    $maxId,
    $_POST['eventName'],
    $_POST['eventTypeId'],
    $local,
    $_POST['eventSponsor'],
    $_POST['eventStartDate'],
    $_POST['eventEndDate'],
    $_POST['eventDesc'],
    $_POST['eventNeedPeople'],
    $_POST['eventNowPeople'],
    $EeventimgFileName
];
$stmt->execute($arrStmt);

//如果SQL語法影響行數大於0 就跳轉回去
if ( $stmt->rowCount() > 0 ){
    header("Refresh: 0.1 ; url=./event-admin.php");
    echo '<script type="text/javascript">alert("新增成功!");</script>';
    exit();
} else {
    header("Refresh: 0.1 ; url=./addevent.php");
    echo '<script type="text/javascript">alert("新增失敗，請檢查是否有資料輸入錯誤!");</script>';
}