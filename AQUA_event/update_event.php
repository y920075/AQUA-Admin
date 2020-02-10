<?php 
    require_once('../template/db.inc.php');
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit();

//設定更新sql語法

if ( $_POST['eventStartDate'] < $_POST['eventEndDate']){
    header("Refresh: 0.1; url=./edit_event.php?editeventId={$_POST['editId']}");
    echo '<script type="text/javascript">alert("活動開始日期不可小於報名截止日期!");</script>';
    exit();
}


$sql = "UPDATE `event_data` 
    SET 
    `eventId` = ?, 
    `eventName` = ?,
    `eventTypeId` = ?,
    `eventLocal` = ?,
    `eventSponsor` = ?,
    `eventStartDate` = ?,
    `eventEndDate` = ?, 
    `eventDesc` = ?, 
    `eventNeedPeople` = ?, 
    `eventNowPeople` = ? ";

if( $_POST['eventLocal'] == 'other' && $_POST['customLocal'] !== ''){
    $local = $_POST['customLocal'];
} else {
    $local = $_POST['eventLocal'];
}

//設定繫結陣列
$arrParam = [
    $_POST['eventId'],
    $_POST['eventName'],
    $_POST['eventTypeId'],
    $local,
    $_POST['eventSponsor'],
    $_POST['eventStartDate'],
    $_POST['eventEndDate'],
    $_POST['eventDesc'],
    $_POST['eventNeedPeople'],
    $_POST['eventNowPeople']
];

//如果檔案成功上傳
if( $_FILES['eventImg']['error'] === 0 ){
    //取得E+時間字串
    $eventImg = 'E'.date('YmdHis');
    //取得副檔名
    $extension = pathinfo( $_FILES['eventImg']['name'],PATHINFO_EXTENSION);
    //建立新檔案名稱 用取得的時間字串+副檔名命名
    $EeventimgFileName = $eventImg.".".$extension;

    //如果檔案移動成功，則表示舊檔案需要被刪除
    if (move_uploaded_file($_FILES['eventImg']['tmp_name'],"../image/eventImg/".$EeventimgFileName)){
        //查詢SQL語法
        $sqlGetImg = "SELECT `eventImg` FROM `event_data` WHERE `eventId` = ?";
        $stmtImg = $pdo->prepare($sqlGetImg);

        //繫結陣列，這裡使用的editId是從隱藏的input元素傳送的
        $arrGetImgParam = [
            $_POST['editId']
        ];

        //執行sql語法
        $stmtImg->execute($arrGetImgParam);
        //如果影響行數大於0 就執行刪除檔案
        if($stmtImg->rowCount() > 0){
            $arrImg = $stmtImg->fetchAll(PDO::FETCH_ASSOC);
            
            //如果資料庫中的eventImg的值不為NULL，則表示有檔案存在
            if( $arrImg[0]['eventImg'] !== NULL ){
                //將檔案強制刪除，並無視錯誤訊息
                @unlink("../image/eventImg/".$arrImg[0]['eventImg']);
            }
            //如果刪除完畢，將eventImg加入原先的SQL語法查詢
            $sql.=",";
            $sql.="`eventImg` = ? ";

            //新增繫結陣列的值
            $arrParam[] = $EeventimgFileName;
        }
    }
}

//加入SQL WHERE篩選條件
$sql.= "WHERE `eventId` = ? ";
//這裡editId值來自於隱藏的input元素傳送的
$arrParam[] = $_POST['editId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if( $stmt->rowCount() > 0 ){
    header("Refresh: 0.1; url=./event-admin.php");
    echo '<script type="text/javascript">alert("資料修改成功!");</script>';
} else {
    header("Refresh: 0.1; url=./event-admin.php");
    echo '<script type="text/javascript">alert("沒有資料被修改!");</script>';
}

?>
